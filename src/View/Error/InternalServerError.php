<?php
namespace VoicesTest\View\Error;

use VoicesTest\View\View;

final class InternalServerError extends View {
    protected function index() {
        extract($this->data);
        require '500.php';
    }
}