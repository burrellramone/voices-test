<?php
namespace VoicesTest\View;

final class Jobs extends View {
    protected function index() {
        extract($this->data);
        require 'jobs/index.php';
    }

    protected function add() {
        extract($this->data);
        require 'jobs/add.php';
    }

    protected function view() {
        extract($this->data);
        require 'jobs/view.php';
    }
}