<?php
header("Content-Type: application/json");

// Dados de conexão
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "journal";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$result = $conn->query("SELECT id, entries FROM journal ORDER BY created_at ASC");

$entries = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $entry = json_decode($row['entries'], true);
        if ($entry) {
            $entry['id'] = $row['id']; // <--- Adiciona o ID
            $entries[] = $entry;
        }
    }
}
echo json_encode($entries, JSON_UNESCAPED_UNICODE);

$conn->close();