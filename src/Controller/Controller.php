<?php
namespace VoicesTest\Controller;

abstract class Controller {
    protected $tmpl;

    public function __construct(){
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
	 * @throws Exception
	 * @throws NoSuchMethodException
	 */
	public function __call ( string $method, array $arguments ) {
        $called_class = get_called_class();

		if ( method_exists( $called_class, $method ) ) {
            $this->{$method}();
            return $this->tmpl->{$method}();
		} else {
			throw new NoSuchMethodException( "Action '{$method}' of the controller '{$called_class}' does not exist." );
		}
	}
}