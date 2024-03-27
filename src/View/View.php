<?php
namespace VoicesTest\View;

use Exception;

//
use VoicesTest\Config;

/**
 * Abstract class representing a view within the application.
 * Views can have different facts. These facets are manifested / expressed
 * in abd by the different methods that they emplement.
 */
abstract class View {
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Constructs a new instance of this class
     *
     * @param array $data The data to set/inject into the view
     */
    public function __construct(array $data = []){
        $this->data = $data;
        $this->data['app_name'] = Config::read('app_name');
    }

    protected function index() {
        echo '';
    }

    /**
     * Assigns a variable into this view
     * @param string The name of the variable
     * @param mixed The value of the variable
     */
    public function assign(string $key, mixed $value):void {
        $this->data[$key] = $value;
    }

    public function __get(string $name):mixed {
        if(isset($this->data[$name])){
            return $this->data[$name];
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value):void {
        $this->assign($name, $value);
    }

    /**
	 *
	 * @param string $method
	 * @param array $arguments
	 * @throws Exception
	 */
	public function __call ( string $method, array $arguments ) {
        $called_class = get_called_class();

		if ( method_exists( $called_class, $method ) ) {
            
			ob_start();
            $this->{$method}();
            $template = ob_get_clean();
            
            extract($this->data);
            require_once "layout.default.php";

            $page = ob_get_contents();
            ob_end_clean();

            return $page;
		} else {
			throw new Exception( "Method '{$method}' of the view '{$called_class}' does not exist." );
		}
	}
}