<?php
// src/helpers.php
function generate_token($len = 64) {
    return bin2hex(random_bytes($len/2));
}

function json_response($data, $code=200) {
    header('Content-Type: application/json');
    http_response_code($code);
    echo json_encode($data);
    exit;
}
