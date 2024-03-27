<?php
namespace VoicesTest\Controller\Error;

use VoicesTest\View\Error\InternalServerError as InternalServerErrorView;
use VoicesTest\Controller\Controller;

final class InternalServerError extends Controller {
    public function __construct(){
        parent::__construct();

        $this->tmpl = new InternalServerErrorView();
    }

    protected function index():void {
        $this->tmpl->assign("page_title", "500 Internal Server Error");
    }

    public function getStatus(): string {
        return $_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error';
    }
}