<?php
namespace VoicesTest\View;

final class Jobs extends View {
    protected function index() {
        require 'jobs/index.php';
    }

    protected function add() {
        require 'jobs/add.php';
    }
}