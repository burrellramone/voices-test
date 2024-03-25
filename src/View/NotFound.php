<?php
namespace VoicesTest\View;

final class NotFound extends View {
    protected function index() {
        require '404.php';
    }
}