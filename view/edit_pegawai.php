<?php
include '../db_connect.php';

// Ambil NIP dari URL
$nip = $_GET['nip'];

// Query untuk mengambil data pegawai berdasarkan NIP
$sql = "SELECT * FROM pegawai WHERE nip = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();

$pegawai = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Edit Data Pegawai</h2>
                </div>
                <div class="card-body">
                    <form id="pegawaiForm" onsubmit="return simpanPegawai(event)">
                        <input type="hidden" name="nip" value="<?php echo $pegawai['nip']; ?>">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $pegawai['nama']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $pegawai['alamat']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo date('Y-m-d', strtotime($pegawai['tgl_lahir'])); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="id_ruangan">Nama Ruangan</label>
                            <select class="form-control" id="id_ruangan" name="id_ruangan" required>
                                <option value="">Pilih Ruangan</option>
                                <?php
                                include '../db_connect.php'; // Memasukkan koneksi database lagi untuk mendapatkan data ruangan
                                // Query untuk mengambil data ruangan
                                $sql = "SELECT id_ruangan, keterangan FROM ruangan";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Tandai ruangan yang sesuai dengan pegawai saat ini
                                        $selected = ($pegawai['id_ruangan'] == $row['id_ruangan']) ? 'selected' : '';
                                        echo "<option value='" . $row['id_ruangan'] . "' $selected>" . $row['keterangan'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Ruangan tidak tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Data</button>
                        <a href="../index.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function simpanPegawai(event) {
        event.preventDefault(); 

        const formData = new FormData(document.getElementById('pegawaiForm'));
        fetch('../process/update_pegawai.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.message) {
                  // Tampilkan SweetAlert di tengah halaman
                  Swal.fire({
                      icon: 'success',
                      title: data.message,
                      position: 'center', 
                      showConfirmButton: false,
                      timer: 2000
                  }).then(() => {
                      window.location.href = '../index.php'; 
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Terjadi kesalahan',
                      text: data.error
                  });
              }
          })
          .catch(error => {
              console.error('Error:', error);
              Swal.fire({
                  icon: 'error',
                  title: 'Terjadi kesalahan saat menyimpan data.'
              });
          });
    }
</script>

</body>
</html>
