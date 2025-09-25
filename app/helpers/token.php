<?php
function generateToken($payload, $secret, $expSeconds)
{
  $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
  $payload['exp'] = time() + $expSeconds;
  $payload = base64_encode(json_encode($payload));
  $signature = hash_hmac('sha256', "$header.$payload", $secret);
  return "$header.$payload.$signature";
}

function verifyToken($token, $secret)
{
  $parts = explode('.', $token);
  if (count($parts) !== 3) return false;

  [$header, $payload, $signature] = $parts;
  $check = hash_hmac('sha256', "$header.$payload", $secret);

  if (!hash_equals($check, $signature)) return false;

  $data = json_decode(base64_decode($payload), true);
  if (!$data || $data['exp'] < time()) return false;

  return $data;
}
