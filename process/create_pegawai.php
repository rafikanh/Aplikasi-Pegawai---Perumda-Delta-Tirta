<?php
include '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $id_ruangan = $_POST['id_ruangan'];

    $sql = "INSERT INTO pegawai (nama, alamat, tgl_lahir, id_ruangan) VALUES ('$nama', '$alamat', '$tgl_lahir', $id_ruangan)";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Data berhasil ditambahkan']);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}
$conn->close();
?>
