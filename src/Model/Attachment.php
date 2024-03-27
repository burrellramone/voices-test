<?php
namespace VoicesTest\Model;

final class Attachment extends Model {
    private $name;
    private $type;
    private $extension;
    private $size;
    private $path;
    private $datetime_created;

    public function getName():string {
        return $this->name; 
    }

    public function getType():string {
        return $this->type;
    }

    public function getExtension():string {
        return $this->extension;
    }

    public function getSize():int {
        return $this->size;
    }

    public function getPath():string {
        return $this->path; 
    }

    /**
     * @inheritdoc
     * @return void
     */
    public function delete():void {
        //unlink file form filesystem
        unlink(DOCUMENT_ROOT . "/public/" . $this->path);

        parent::delete();
    }

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTableName():string {
        return 'attachment';
    }
}