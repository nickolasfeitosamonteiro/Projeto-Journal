<?php
header("Content-Type: application/json");

// Dados de conexão
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "journal";

// Recebe os dados enviados
$entryData = json_decode(file_get_contents("php://input"), true);

if (!$entryData) {
    echo json_encode(["success" => false, "error" => "Dados inválidos"]);
    exit;
}

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Erro na conexão com o banco: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO journal (entries) VALUES (?)");
$jsonEntry = json_encode($entryData, JSON_UNESCAPED_UNICODE);
$stmt->bind_param("s", $jsonEntry);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();