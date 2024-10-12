<?php
include '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];

    $stmt = $conn->prepare("DELETE FROM pegawai WHERE nip = ?");
    $stmt->bind_param("s", $nip); 
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Pegawai berhasil dihapus']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close(); 
}
$conn->close();
?>
