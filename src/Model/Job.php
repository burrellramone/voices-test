<?php
namespace VoicesTest\Model;

use DateTime;
use Exception;

final class Job extends Model {

    public static  $table_name = 'world_location';

    private ?string $title;
    private ?string $location_id;
    private ?string $additional_information;
    private ?int $attachment_id;
    private string|DateTime $datetime_created = '';

    /**
     * The attachment for the job
     *
     * @var Attachment|null
     */
    private ?Attachment $attachment;

    /**
     * Constructs a new instance of this class
     *
     * @param string|null $title The title of the job
     * @param string|null $location_id The location id of the job
     * @param string|null $additional_information Additional information about the job
     */
    public function __construct(string $title = null, string $location_id = null, string $additional_information = null){
        parent::__construct();

        if($title){
            $this->setTitle($title);
        }

        if($location_id){
            $this->setLocationId($location_id);
        }

        if($additional_information){
            $this->setAdditionalInformation($additional_information);
        }

        $this->attachment = null;
    }

    /**
     * Sets the title of this job
     *
     * @param string $title The title of the job
     * @return void
     */
    public function setTitle(string $title):void {
        $this->title = $title;
    }

    /**
     * Gets the title of the job
     *
     * @return string The title of the job
     */
    public function getTitle():string {
        return $this->title;
    }

     /**
     * Sets the location id of this job
     *
     * @param string $location_id The location id of the job
     * @return void
     */
    public function setLocationId(string $location_id):void {
        $this->location_id = $location_id;
    }

    /**
     * Gets the location (province/state) of this job
     *
     * @return WorldLocation The location of the job
     */
    public function getLocation():WorldLocation {
        return WorldLocation::findById($this->location_id);
    }

     /**
     * Sets additional information about this job
     *
     * @param string $additional_information The additional information about the job
     * @return void
     */
    public function setAdditionalInformation(string $additional_information):void {
        $this->additional_information = $additional_information;
    }

    /**
     * Gets any additional information set for this job
     *
     * @return string The additional information for this job
     */
    public function getAdditionalInformation():string {
        return $this->additional_information;
    }

     /**
     * Sets the id of the attachment of this job
     *
     * @param int $attachment_id The id of the attachment of the job
     * @return void
     */
    public function setAttachmentId(int $attachment_id):void {
        $this->attachment_id = $attachment_id;
    }

    /**
     * Gets the attachment for for the jon
     *
     * @return Attachment|NULL An instance of Attachment if the job has an attachment,
     *      NULL otherwise
     */
    public function getAttachment():?Attachment {
        if(!$this->attachment && $this->attachment_id){
            $this->attachment = Attachment::findById($this->attachment_id);
        }

        return $this->attachment;
    }

    /**
     * Undocumented function
     *
     * @return DateTime
     */
    public function getDateTimeCreated():DateTime {
        if(!($this->datetime_created instanceof DateTime)){
            $this->datetime_created = new DateTime($this->datetime_created);
        }

        return $this->datetime_created;
    }

    /**
     * @inheritdoc
     * @return void
     */
    public function delete():void {
        $attachment = $this->getAttachment();

        if($attachment){
            $attachment->delete();
        }

        parent::delete();
    }

    public static function validate(array $data):void {
        if(empty($data)){
            throw new Exception("Job information not provided");
        } elseif(empty($data['title'])) {
            throw new Exception("Job title not provided");
        } elseif(empty($data['location_id'])) {
            throw new Exception("Job location id not provided");
        }
    }

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTableName():string {
        return 'job';
    }
}