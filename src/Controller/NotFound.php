<?php
namespace VoicesTest\Controller;

use VoicesTest\View\NotFound as NotFoundView;

final class NotFound extends Controller {
    public function __construct(){
        parent::__construct();

        $this->tmpl = new NotFoundView();
    }

    protected function index():void {
        
    }

    public function getStatus(): string
    {
        return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
    }
}