<?php
namespace VoicesTest\Controller;

use VoicesTest\View\Jobs as JobsView;

final class Jobs extends Controller {
    public function __construct(){
        parent::__construct();

        $this->tmpl = new JobsView();
    }

    protected function index():void {
        $jobs = [];
        
        $this->tmpl->assign('jobs', $jobs);
        $this->tmpl->assign('page_title', "Jobs");
    }

    protected function add():void {
        $this->tmpl->assign('page_title', "Add Job");
    }
}