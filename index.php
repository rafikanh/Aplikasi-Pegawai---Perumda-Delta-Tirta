<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Pegawai</h2>
        <a href="view/input_pegawai.php" class="btn btn-success mb-3">Tambah Pegawai</a>
        <table class="table table-bordered" id="pegawaiTable">
            <thead>
                <tr>
                    <th class="text-center" style="background-color: #87CEEB;">NIP</th>
                    <th class="text-center" style="background-color: #87CEEB;">Nama</th>
                    <th class="text-center" style="background-color: #87CEEB;">Alamat</th>
                    <th class="text-center" style="background-color: #87CEEB;">Tanggal Lahir</th>
                    <th class="text-center" style="background-color: #87CEEB;">Nama Ruangan</th>
                    <th class="text-center" style="background-color: #87CEEB;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk mengambil data pegawai
        function loadPegawai() {
            fetch('process/get_pegawai.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok, status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.querySelector('#pegawaiTable tbody');
                    tableBody.innerHTML = ''; 

                    // Cek jika data berisi pesan kesalahan
                    if (data.error) {
                        alert(data.error); 
                        return;
                    }

                    // Cek apakah data pegawai ada
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data pegawai.</td></tr>';
                        return;
                    }

                    data.forEach(pegawai => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pegawai.nip}</td>
                            <td>${pegawai.nama}</td>
                            <td>${pegawai.alamat}</td>
                            <td>${pegawai.tgl_lahir}</td>
                            <td>${pegawai.keterangan}</td>
                            <td class="text-center">
                                <a href="view/edit_pegawai.php?nip=${pegawai.nip}" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="hapusPegawai('${pegawai.nip}')">Hapus</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat memuat data pegawai: ' + error.message);
                });
        }
        
        // Fungsi untuk menghapus pegawai
        function hapusPegawai(nip) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('process/delete_pegawai.php', { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `nip=${nip}`
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok, status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Tampilkan alert sukses
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data telah dihapus.",
                            icon: "success"
                        });
                        loadPegawai(); 
                    })
                    .catch(error => {
                        console.error('Error deleting pegawai:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menghapus pegawai.',
                            text: error.message
                        });
                    });
                }
            });
        }

        // Panggil fungsi untuk memuat pegawai saat halaman dimuat
        loadPegawai();
    </script>

</body>

</html>