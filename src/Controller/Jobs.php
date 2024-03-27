<?php
namespace VoicesTest\Controller;

use PDO;
use Exception;

//VoicesTest
use VoicesTest\UploadedFile;
use VoicesTest\View\Jobs as JobsView;
use VoicesTest\Model\Job;
use VoicesTest\Exception\NotFound as NotFoundException;

final class Jobs extends Controller {
    public function __construct(PDO $db){
        parent::__construct($db);

        $this->tmpl = new JobsView();
    }

    protected function index():void {
        $jobs = $this->getJobs();
        
        $job_submitted = $_SESSION['job_submitted']??false;
        $job_deleted = $_SESSION['job_deleted']??false;
        
        unset($_SESSION['job_submitted']);
        unset($_SESSION['job_deleted']);

        $this->tmpl->assign('page_title', "Jobs");
        $this->tmpl->assign('jobs', $jobs);
        $this->tmpl->assign('job_submitted', $job_submitted);
        $this->tmpl->assign('job_deleted', $job_deleted);
    }

    protected function add():void {

        $countries = $this->getCountries();
        
        foreach($countries as $country){
            $country_id = $country->getId();

            $states[$country_id] = $this->getStates($country_id);
        }


        $this->tmpl->assign('page_title', "Add Job");
        $this->tmpl->assign('countries', $countries);
        $this->tmpl->assign('states', $states);
    }

    protected function view():void {
        $id = $this->parameters->id;

        if(!$id){
            throw new NotFoundException("Job id not provided");
        }

        $job = Job::findById($id);

        if(!$job){
            throw new NotFoundException("Job not found");
        }

        $this->tmpl->assign('page_title', $job->getTitle());
        $this->tmpl->assign('job', $job);
    }

    public function create():void{        
        Job::validate($_POST);
        
        $title = $_POST['title'];
        $location_id = $_POST['location_id'];
        $additional_information = $_POST['additional_information'];
        $attachment_id = null;

        if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] != UPLOAD_ERR_NO_FILE){
            $uploaded_file = UploadedFile::get('attachment');

            //move file
            $filename = $uploaded_file->name;
            $attachment_relpath = "attachments/{$filename}";
            move_uploaded_file($uploaded_file->tmp_name, DOCUMENT_ROOT . "/public/{$attachment_relpath}");

            //Insert attachment
            $query = "INSERT INTO attachment (`name`, `type`, `extension`, `size`, `path`) 
                        VALUES (:name, :type, :extension, :size, :path)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $uploaded_file->name);
            $stmt->bindParam(':type', $uploaded_file->type);
            $stmt->bindParam(':extension', $uploaded_file->extension);
            $stmt->bindParam(':size', $uploaded_file->size);
            $stmt->bindParam(':path', $attachment_relpath);

            $stmt->execute();
            
            $attachment_id = $this->db->lastInsertId();
        }

        $query = "INSERT INTO job (title, location_id, additional_information, attachment_id) 
                    VALUES (:title, :location_id, :additional_information, :attachment_id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':location_id', $location_id);
        $stmt->bindParam(':additional_information', $additional_information);
        $stmt->bindParam(':attachment_id', $attachment_id);
       
        $stmt->execute();
        $job_id = $this->db->lastInsertId();
        $job = Job::findById($job_id);

        //Send email confirmation
        $this->sendJobEmailConfirmation($job);

        $_SESSION['job_submitted'] = true;

        $this->redirect("/jobs");  
    }

    public function delete():void {
        $id = $_GET['id'];
        $job = Job::findById($id);

        if(!$job){
            throw new Exception("Job not found");
        }

        $job->delete();

        $_SESSION['job_deleted'] = true;

        $this->redirect("/jobs"); 
    }

    private function getJobs():array {
        $countries = [];

        $stmt = $this->db->query("SELECT * FROM `job` ORDER BY datetime_created DESC", PDO::FETCH_CLASS, "VoicesTest\Model\Job");
        $countries = $stmt->fetchAll();

        return $countries;
    }


    private function getCountries():array {
        $countries = [];

        $stmt = $this->db->query("SELECT * FROM `world_location` WHERE type_id = 1", PDO::FETCH_CLASS, "VoicesTest\Model\WorldLocation");
        $countries = $stmt->fetchAll();

        return $countries;
    }

    private function getStates(int $country_id):array {
        $stmt = $this->db->query("SELECT * FROM `world_location` WHERE type_id = 2 AND country_id = {$country_id}", PDO::FETCH_CLASS, "VoicesTest\Model\WorldLocation");
        $states = $stmt->fetchAll();

        return $states;
    }

    private function sendJobEmailConfirmation(Job $job):void {

        $to = ADMIN_EMAIL;
        $subject = "New Job - {$job->getTitle()}";
        $headers = [
            "From" => "Ramone Burrell <". ADMIN_EMAIL . ">",
            "Content-Type" => "text/html",
        ];

        $message = "Good Day Ramone: <br/><br/>
                    This is to confirm that a new job has been created. Please see below for a summary of the job listing.
                    <br/><br/>
                    <strong>Title:</strong> {$job->getTitle()}
                    <br/>
                    <strong>Location:</strong> {$job->getLocation()->getLocaleName()}
                    <br/>
                    <p>{$job->getAdditionalInformation()}</p>";

        if(!mail($to, $subject, $message, $headers)){
            error_log("Could not send job email confirmation");
        }
    }
}