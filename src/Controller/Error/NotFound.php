<?php
namespace VoicesTest\Controller\Error;

use VoicesTest\View\Error\NotFound as NotFoundView;
use VoicesTest\Controller\Controller;

final class NotFound extends Controller {
    public function __construct(){
        parent::__construct();

        $this->tmpl = new NotFoundView();
    }

    protected function index():void {
        $this->tmpl->assign("page_title", "404 Not Found");
    }

    public function getStatus(): string
    {
        return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
    }
}