<?php
namespace VoicesTest\Controller;

use stdClass;
use PDO;

//
use VoicesTest\Exception\ActionNotExist;

abstract class Controller {
    public $tmpl;

    protected ?stdClass $parameters;

    protected ?PDO $db;

    public function __construct(PDO $db = null){
        $this->db = $db;

        $this->parameters = new stdClass;

        $parameters = array_merge($_GET, $_REQUEST, $_POST);

        foreach($parameters as $key => $value){
            $this->parameters->{$key} = $value;
        }
    }

    /**
     * Redirect the application to a specified location
     *
     * @param string $location The location to direct the application to
     * @return void
     */
    protected function redirect(string $location):void {
        header("Location: {$location}");
        exit; 
    }

    public function getStatus(): string {
        return $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
    }

    public function sendHeaders(): void {
        header($this->getStatus());
        header('Content-Type: text/html');
    }

     /**
	 *
	 * @param string $method
	 * @param array $arguments
	 * @throws ActionNotExist
	 */
	public function __call ( string $method, array $arguments ) {
        $called_class = get_called_class();

		if ( method_exists( $called_class, $method ) ) {
            $this->{$method}();
            return $this->tmpl->{$method}();
		} else {
			throw new ActionNotExist( "Action '{$method}' of the controller '{$called_class}' does not exist." );
		}
	}
}