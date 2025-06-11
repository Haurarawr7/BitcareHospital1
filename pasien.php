<?php 
include("koneksi.php"); 

// --- BAGIAN BARU UNTUK MENGAMBIL DATA VIA AJAX ---
// Cek jika ini adalah request GET dengan action=get_data dan ada id
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'get_data' && isset($_GET['id'])) {
    $id_pasien = $_GET['id'];
    
    // Query untuk mengambil satu data pasien
    $query = "SELECT * FROM pasien WHERE id = ?";
    
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_pasien);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    // Set header sebagai JSON dan kirim datanya
    header('Content-Type: application/json');
    echo json_encode($data);
    exit(); // Penting: hentikan eksekusi script agar tidak menampilkan sisa HTML
}

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    // --- FUNGSI INSERT (TAMBAH DATA) ---
    if ($action == 'insert') {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $no_telepon = $_POST["no_telepon"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $gol_darah = $_POST["gol_darah"];
        $alamat = $_POST["alamat"];
        $no_antrian = $_POST["no_antrian"];
    
        // KEAMANAN: Gunakan prepared statement untuk mencegah SQL Injection
        $query = "INSERT INTO pasien (id, nama_pasien, tanggal_lahir, no_telepon, jenis_kelamin, gol_darah, alamat, no_antrian) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'issssssi', $id, $nama, $tanggal_lahir, $no_telepon, $jenis_kelamin, $gol_darah, $alamat, $no_antrian);
        
        if (!mysqli_stmt_execute($stmt)) {
            // Handle error jika ID sudah ada (duplicate key)
            if (mysqli_errno($koneksi) == 1062) {
                echo "<script>alert('ID Pasien atau No Antrian sudah ada. Gunakan yang berbeda.');</script>";
            } else {
                echo "<script>alert('Gagal menambah data pasien: " . mysqli_error($koneksi) . "');</script>";
            }
        }

    // --- FUNGSI UPDATE (EDIT DATA) ---
    } elseif ($action == 'edit') {
        $id_baru = $_POST["id"];
        $id_lama = $_POST["id_lama"]; // ID asli sebelum diubah
        $nama = $_POST["nama"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $no_telepon = $_POST["no_telepon"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $gol_darah = $_POST["gol_darah"];
        $alamat = $_POST["alamat"];
        $no_antrian = $_POST["no_antrian"];
        
        // KEAMANAN: Gunakan prepared statement untuk query UPDATE
        $query = "UPDATE pasien SET id=?, nama_pasien=?, tanggal_lahir=?, no_telepon=?, jenis_kelamin=?, gol_darah=?, alamat=?, no_antrian=? WHERE id=?";
        
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'issssssii', $id_baru, $nama, $tanggal_lahir, $no_telepon, $jenis_kelamin, $gol_darah, $alamat, $no_antrian, $id_lama);
        
        if (!mysqli_stmt_execute($stmt)) {
            // Handle error jika ID baru sudah ada (saat mengubah ID)
            if (mysqli_errno($koneksi) == 1062) {
                echo "<script>alert('ID Pasien atau No Antrian sudah ada. Gunakan yang berbeda.');</script>";
            } else {
                echo "<script>alert('Gagal mengupdate data pasien: " . mysqli_error($koneksi) . "');</script>";
            }
        }

    // --- FUNGSI DELETE (HAPUS DATA) ---
    } elseif ($action == 'delete') {
        $id_pasien = $_POST["id_pasien"];

        // PERBAIKAN: Hapus data terkait terlebih dahulu untuk menghindari foreign key constraint error
        try {
            // Mulai transaction untuk memastikan semua operasi berhasil atau semua gagal
            mysqli_autocommit($koneksi, FALSE);
            
            // 1. Hapus data di tabel pelayanan yang mereferensi pasien ini
            $query_pelayanan = "DELETE FROM pelayanan WHERE id_pasien = ?";
            $stmt_pelayanan = mysqli_prepare($koneksi, $query_pelayanan);
            mysqli_stmt_bind_param($stmt_pelayanan, 'i', $id_pasien);
            mysqli_stmt_execute($stmt_pelayanan);
            
            // 2. Hapus data di tabel rekam_medis jika ada
            $query_rekam = "DELETE FROM rekam_medis WHERE id_pasien = ?";
            $stmt_rekam = mysqli_prepare($koneksi, $query_rekam);
            mysqli_stmt_bind_param($stmt_rekam, 'i', $id_pasien);
            mysqli_stmt_execute($stmt_rekam);
            
            // 3. Hapus data di tabel perawat yang mereferensi pasien ini
            $query_perawat = "DELETE FROM perawat WHERE id_pasien = ?";
            $stmt_perawat = mysqli_prepare($koneksi, $query_perawat);
            mysqli_stmt_bind_param($stmt_perawat, 'i', $id_pasien);
            mysqli_stmt_execute($stmt_perawat);
            
            // 4. Terakhir hapus data pasien
            $query_pasien = "DELETE FROM pasien WHERE id = ?";
            $stmt_pasien = mysqli_prepare($koneksi, $query_pasien);
            mysqli_stmt_bind_param($stmt_pasien, 'i', $id_pasien);
            mysqli_stmt_execute($stmt_pasien);
            
            // Commit transaction jika semua berhasil
            mysqli_commit($koneksi);
            echo "<script>alert('Data pasien dan semua data terkait berhasil dihapus.');</script>";
            
        } catch (Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($koneksi);
            echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "');</script>";
        }
        
        // Kembalikan autocommit ke true
        mysqli_autocommit($koneksi, TRUE);
    }

    // Redirect untuk mencegah form dikirim ulang jika halaman di-refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data pasien untuk ditampilkan
$query = 'SELECT * FROM pasien ORDER BY id;'; 
$result = mysqli_query($koneksi, $query); 

include 'layouts/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    * { box-sizing: border-box; }
    body { 
        margin: 0; 
        font-family: 'Poppins', sans-serif; 
        display: flex; 
        min-height: 100vh; 
        background: linear-gradient(135deg, #333446 0%, #2575fc 100%); 
        color: #fff; 
    }
    .sidebar { width: 250px;
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column; 
        align-items: flex-start; 
    }
    .sidebar h2 { 
        margin-bottom: 1.5rem;
        font-weight: 600; 
        font-size: 1.5rem; 
        text-align: left; 
    }
    .menu-item { margin: 0.5rem 0; 
        padding: 0.5rem 1rem; 
        border-radius: 8px; 
        cursor: pointer; 
        transition: background 0.3s ease; 
        width: 100%; 
        text-align: left; 
    }
    .menu-item:hover { 
        background: rgba(255, 255, 255, 0.2); 
    }
    .main-content { 
        flex: 1; 
        padding: 2rem; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
    }
    header { 
        margin-bottom: 2rem; 
        text-align: center; 
    }
    header h1 { 
        font-weight: 600; 
        font-size: 2.5rem; 
        letter-spacing: 0.05em; 
        text-shadow: 0 2px 6px rgba(0,0,0,0.3); 
        margin: 0; 
        animation: fadeIn 1s ease-in-out; 
    }
    @keyframes fadeIn { 
        from { 
            opacity: 0; 
            transform: translateY(-20px); 
        } 
        to { opacity: 1; 
            transform: translateY(0); 
        } 
    }
    .formulir { 
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); padding-top: 60px; }
    .formulir-content { 
        color : black;
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px; 
        border: 1px solid #888; 
        width: 80%; 
        max-width: 500px; 
        border-radius: 8px; }
    .close-btn { 
        color: #aaa; 
        float: right; 
        font-size: 28px; 
        font-weight: bold; 
    }
    .close-btn:hover, .close-btn:focus { 
        color: black; 
        text-decoration: none; 
        cursor: pointer; 
    }
    .form-group { 
        margin-bottom: 15px; 
    }
    .form-group label { 
        display: block; 
        margin-bottom: 5px; 
    }
    .form-group input[type="text"], .form-group input[type="number"], .form-group input[type="date"], .form-group select { 
        width: calc(100% - 22px); 
        padding: 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }

</style>

<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <div class="menu-item" onclick="window.location.href='pelayanan.php'">Administrasi</div>
    <div class="menu-item" onclick="window.location.href='tindakanmedis.php'">Tindakan medis</div>
    <div class="menu-item" onclick="window.location.href='rekammedis.php'">Rekam medis</div>
    <div class="menu-item" onclick="window.location.href='obat.php'">Obat</div>
    <div class="menu-item" onclick="window.location.href='transaksi.php'">Transaksi</div>
    <div class="menu-item" onclick="window.location.href='ruangan.php'">Ruangan</div>
    <div class="menu-item" onclick="window.location.href='staff.php'">Staf</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item" onclick="window.location.href='perawat.php'">Perawat</div>
    <div class="menu-item" onclick="window.location.href='dokter.php'">Dokter</div>
  </div>

<section class="p-4 ml-5 mr-5 w-75">
    <div class="d-flex flex-row justify-content-between">
        <h2>Data Pasien</h2>
        <button onclick="openModal()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">ID Pasien</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">No. Telepon</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Golongan Darah</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. Antrian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pasien = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $pasien->id ?></td>
                    <td><?= $pasien->nama_pasien ?></td>
                    <td><?= $pasien->tanggal_lahir ?></td>
                    <td><?= $pasien->no_telepon?></td>
                    <td><?= $pasien->jenis_kelamin?></td>
                    <td><?= $pasien->gol_darah?></td>
                    <td><?= $pasien->alamat ?></td>
                    <td><?= $pasien->no_antrian?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $pasien->id ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $pasien->id ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<!-- Modal for adding/editing patient data -->
<div id="patientModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Pasien</h2>
        <form id="patientForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <!-- Hidden field untuk menyimpan ID pasien lama saat edit -->
            <input type="hidden" name="id_lama" id="idLama" value="">
            
            <div class="form-group">
                <label for="id">ID Pasien</label>
                <input type="number" name="id" id="id" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Pasien</label>
                <input type="text" name="nama" id="nama" required>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" required>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gol_darah">Golongan Darah</label>
                <select name="gol_darah" id="gol_darah" required>
                    <option value="">Pilih Golongan Darah</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Pasien</label>
                <input type="text" name="alamat" id="alamat" required>
            </div>
            <div class="form-group">
                <label for="no_antrian">No Antrian</label>
                <input type="number" name="no_antrian" id="no_antrian" required>
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p><strong>PERINGATAN:</strong> Menghapus pasien akan menghapus semua data terkait (pelayanan, rekam medis, dll.)</p>
        <p>Masukkan ID Pasien untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="id_pasien_delete">ID Pasien</label>
                <input type="number" name="id_pasien" id="id_pasien_delete" required>
            </div>
            <button type="submit" style="background-color: #dc3545;">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(mode, dataPasien = null) {
        // Reset form setiap kali dibuka
        document.getElementById('patientForm').reset();

        const modalTitle = document.getElementById('modalTitle');
        const actionInput = document.getElementById('action');
        const idLamaInput = document.getElementById('idLama');

        if (mode === 'edit' && dataPasien) {
            // --- MODE EDIT ---
            modalTitle.innerText = 'Edit Data Pasien';
            actionInput.value = 'edit';
            
            // Simpan ID lama untuk referensi update
            idLamaInput.value = dataPasien.id;
            
            // Isi semua field dengan data yang didapat dari server
            document.getElementById('id').value = dataPasien.id;
            document.getElementById('nama').value = dataPasien.nama_pasien;
            document.getElementById('tanggal_lahir').value = dataPasien.tanggal_lahir;
            document.getElementById('no_telepon').value = dataPasien.no_telepon;
            document.getElementById('jenis_kelamin').value = dataPasien.jenis_kelamin;
            document.getElementById('gol_darah').value = dataPasien.gol_darah;
            document.getElementById('alamat').value = dataPasien.alamat;
            document.getElementById('no_antrian').value = dataPasien.no_antrian;

        } else {
            // --- MODE TAMBAH ---
            modalTitle.innerText = 'Tambah Data Pasien';
            actionInput.value = 'insert';
            idLamaInput.value = ''; // Kosongkan ID lama
        }

        // Tampilkan modal
        document.getElementById('patientModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('patientModal').style.display = 'none';
    }

    function openDeleteModal(id_pasien) {
        document.getElementById('id_pasien_delete').value = id_pasien;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id_pasien) {
        // URL ke endpoint AJAX yang kita buat di PHP
        const url = `pasien.php?action=get_data&id=${id_pasien}`;

        // Gunakan Fetch API untuk mengambil data dari server
        fetch(url)
            .then(response => {
                // Periksa apakah request berhasil (status code 200-299)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Ubah response menjadi JSON
                return response.json();
            })
            .then(data => {
                // Jika berhasil mendapatkan data, panggil modal dalam mode 'edit'
                // dan kirim data yang didapat dari server
                if(data) {
                    openModal('edit', data);
                } else {
                    alert('Data pasien tidak ditemukan.');
                }
            })
            .catch(error => {
                // Tangani jika ada error saat fetching data
                console.error('Error fetching patient data:', error);
                alert('Gagal mengambil data pasien. Silakan coba lagi.');
            });
    }
</script>

<?php include 'layouts/footer.php'; ?>