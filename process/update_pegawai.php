<?php
include '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $id_ruangan = $_POST['id_ruangan'];

    $sql = "UPDATE pegawai SET nama=?, alamat=?, tgl_lahir=?, id_ruangan=? WHERE nip=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nama, $alamat, $tgl_lahir, $id_ruangan, $nip);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data berhasil diupdate']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
}
$conn->close();
?>
