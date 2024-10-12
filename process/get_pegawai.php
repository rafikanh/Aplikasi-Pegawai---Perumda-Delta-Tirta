<?php
include '../db_connect.php'; // Pastikan path ini benar

header('Content-Type: application/json');

$sql = "SELECT p.nip, p.nama, p.alamat, p.tgl_lahir, r.keterangan 
        FROM pegawai p 
        JOIN ruangan r ON p.id_ruangan = r.id_ruangan";
$result = $conn->query($sql);

$pegawai = [];
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pegawai[] = $row;
        }
    }
} else {
    // Jika query gagal, masukkan pesan kesalahan
    echo json_encode(['error' => 'Query error: ' . $conn->error]);
    exit; // Menghentikan eksekusi script
}

echo json_encode($pegawai);
$conn->close();
?>
