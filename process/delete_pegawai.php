<?php
include '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];

    // Gunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("DELETE FROM pegawai WHERE nip = ?");
    $stmt->bind_param("s", $nip); // Ganti "s" dengan "i" jika nip adalah integer

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Pegawai berhasil dihapus']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close(); // Tutup statement
}
$conn->close();
?>
