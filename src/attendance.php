<?php
// src/attendance.php
require_once __DIR__.'/db.php';
require_once __DIR__.'/helpers.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if(!$data || empty($data['payload'])) {
    json_response(['error'=>'invalid_payload'], 400);
}
$payload = json_decode($data['payload'], true);
if(!$payload || empty($payload['uid']) || empty($payload['token'])) {
    json_response(['error'=>'invalid_payload_format'], 400);
}

$uid = intval($payload['uid']);
$token = $payload['token'];
$type = ($data['type'] === 'out') ? 'out' : 'in';

$stmt = $pdo->prepare("SELECT id, qr_token FROM users WHERE id = ?");
$stmt->execute([$uid]);
$user = $stmt->fetch();
if(!$user || !hash_equals($user['qr_token'], $token)) {
    json_response(['error'=>'unauthorized'], 403);
}

// Optional: rules, mis. hanya 1 check-in per day
// Simpan attendance
$ip = $_SERVER['REMOTE_ADDR'];
$stmt = $pdo->prepare("INSERT INTO attendance (user_id, type, scanned_token, ip_address) VALUES (?, ?, ?, ?)");
$stmt->execute([$uid, $type, $token, $ip]);

json_response(['success'=>true, 'message'=>'Presensi berhasil']);
