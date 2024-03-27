<?php
namespace VoicesTest\View\Error;

use VoicesTest\View\View;

final class NotFound extends View {
    protected function index() {
        extract($this->data);
        require '404.php';
    }
}