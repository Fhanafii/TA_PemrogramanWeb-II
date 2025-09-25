<?php
class Controller {
    protected function render($view, $data = []) {
        extract($data); // ubah array jadi variabel
        require __DIR__ . "/../views/$view.php";
    }
}
