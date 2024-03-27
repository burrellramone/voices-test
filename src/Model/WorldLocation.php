<?php
namespace VoicesTest\Model;

final class WorldLocation extends Model {
    const TYPE_COUNTRY = 1;
    const TYPE_REGION = 2;

    public $locale_name;
    public $country_id;
    public $type_id;


    /**
     * Gets the locale name for this world location
     *
     * @return string The locale name for this world location
     */
    public function getLocaleName():string {
        return $this->locale_name;
    }

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTableName():string {
        return 'world_location';
    }
}