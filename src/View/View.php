<?php
namespace VoicesTest\View;

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
	 * @throws NoSuchMethodException
	 */
	public function __call ( string $method, array $arguments ) {
        $called_class = get_called_class();

		if ( method_exists( $called_class, $method ) ) {
            extract($this->data);

			ob_start();
            $this->{$method}();
            $template = ob_get_clean();

            require_once "layout.default.php";

            $page = ob_get_clean();
            ob_end_flush();

            return $page;
		} else {
			throw new NoSuchMethodException( "Method '{$method}' of the view '{$called_class}' does not exist." );
		}
	}
}