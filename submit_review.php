<?php
header('Content-Type: application/json');

try {
    $a = $_POST['avaliacao'] ?? null;
    $p = $_POST['problem'] ?? null;

    if (!$a) {
        throw new Exception('Campo avaliacao é obrigatório');
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Prototype";

    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4", 
        $username, 
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $stmt = $conn->prepare("INSERT INTO Reviews (Avaliacao, Problema) VALUES (:avaliacao, :problema)");
    $stmt->bindParam(':avaliacao', $a);
    $stmt->bindParam(':problema', $p);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Avaliação inserida com sucesso']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
