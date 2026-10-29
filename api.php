<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$file = 'users.json';

// Kalau file users.json belum ada, otomatis dibikin + akun admin default
if (!file_exists($file)) {
    $defaultData = [
        "admin" => [
            "username" => "admin",
            "password" => "admin123", // GANTI PASSWORD INI
            "role" => "admin",
            "expiredAt" => null,
            "quota" => null,
            "createdAt" => round(microtime(true) * 1000)
        ]
    ];
    file_put_contents($file, json_encode($defaultData, JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Ambil data user
    echo file_get_contents($file);
} elseif ($method === 'POST') {
    // Simpan data user
    $input = file_get_contents('php://input');
    if (json_decode($input) !== null) {
        file_put_contents($file, $input);
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Format salah"]);
    }
}
?>