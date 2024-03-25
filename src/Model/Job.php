<?php
namespace VoicesTest\Model;

final class Job extends Model {
    private ?string $title;
    private ?string $location_id;
    private ?string $additional_information;
    private ?int $attachment_id;

    /**
     * Constructs a new instance of this class
     *
     * @param string|null $title The title of the job
     * @param string $location_id The location id of the job
     * @param string|null $additional_information Additional information about the job
     */
    public function __construct(string $title = null, string $location_id, string $additional_information = null){
        parent::__construct();

        if($title){
            $this->setTitle($title);
        }

        if($location_id){
            $this->setLocationId($location_id);
        }

        if($additional_information){
            $this->setAdditionalInformation();
        }
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
     * Sets the location id of this job
     *
     * @param string $location_id The location id of the job
     * @return void
     */
    public function setLocationId(string $location_id):void {
        $this->location_id = $location_id;
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
     * Sets the id of the attachment of this job
     *
     * @param string $attachment_id The id of the attachment of the job
     * @return void
     */
    public function setAttachmentId(string $attachment_id):void {
        $this->attachment_id = $attachment_id;
    }

}