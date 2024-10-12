<?php include '../db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pegawai</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Input Data Pegawai</h2>
                    </div>
                    <div class="card-body">
                        <form id="pegawaiForm" onsubmit="return simpanPegawai(event)">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                            </div>

                            <div class="form-group">
                                <label for="id_ruangan">Nama Ruangan</label>
                                <select class="form-control" id="id_ruangan" name="id_ruangan" required>
                                    <option value="">Pilih Ruangan</option>
                                    <?php
                                    // Query untuk mengambil data ruangan
                                    $sql = "SELECT id_ruangan, keterangan FROM ruangan";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id_ruangan'] . "'>" . $row['keterangan'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Ruangan tidak tersedia</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Data</button>
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
            event.preventDefault(); // Mencegah reload halaman

            const formData = new FormData(document.getElementById('pegawaiForm'));
            fetch('../process/create_pegawai.php', { // Path API untuk simpan data
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Tampilkan SweetAlert di tengah halaman
                        Swal.fire({
                            position: 'center', // Posisi di tengah
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000 // Durasi 3 detik
                        }).then(() => {
                            // Redirect ke halaman index.php setelah alert ditutup
                            window.location.href = '../index.php'; // Arahkan ke index.php di luar folder view
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