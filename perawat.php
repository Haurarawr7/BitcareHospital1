<?php 
include("koneksi.php"); 

// --- BAGIAN BARU UNTUK MENGAMBIL DATA VIA AJAX ---
// Cek jika ini adalah request GET dengan action=get_data dan ada id
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'get_data' && isset($_GET['id'])) {
    $id_perawat = $_GET['id'];
    
    // Query untuk mengambil satu data perawat
    $query = "SELECT * FROM perawat WHERE id_perawat = ?";
    
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_perawat);
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
        // Ambil data dari form, KECUALI id_perawat
        $nama_perawat = $_POST["nama_perawat"];
        $id_pasien = $_POST["id_pasien"];
        $no_telepon = $_POST["no_telepon"];
        $spesialisasi = $_POST["spesialisasi"];
    
        // PERBAIKAN: Hapus 'id_perawat' dari query. Biarkan database mengisinya otomatis.
        // KEAMANAN: Gunakan prepared statement untuk mencegah SQL Injection.
        $query = "INSERT INTO perawat (nama_perawat, id_pasien, no_telepon, spesialisasi) VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($koneksi, $query);
        // 'siss' artinya tipe data: String, Integer, String, String
        mysqli_stmt_bind_param($stmt, 'siss', $nama_perawat, $id_pasien, $no_telepon, $spesialisasi);
        mysqli_stmt_execute($stmt);

    // --- FUNGSI UPDATE (EDIT DATA) ---
    } elseif ($action == 'edit') {
        $id_perawat = $_POST["id_perawat"];
        $nama_perawat = $_POST["nama_perawat"];
        $id_pasien = $_POST["id_pasien"];
        $no_telepon = $_POST["no_telepon"];
        $spesialisasi = $_POST["spesialisasi"];
        
        // KEAMANAN: Gunakan prepared statement untuk query UPDATE
        $query = "UPDATE perawat SET nama_perawat=?, id_pasien=?, no_telepon=?, spesialisasi=? WHERE id_perawat=?";
        
        $stmt = mysqli_prepare($koneksi, $query);
        // 'sissi' artinya: String, Integer, String, String, Integer
        mysqli_stmt_bind_param($stmt, 'sissi', $nama_perawat, $id_pasien, $no_telepon, $spesialisasi, $id_perawat);
        mysqli_stmt_execute($stmt);

    // --- FUNGSI DELETE (HAPUS DATA) ---
    } elseif ($action == 'delete') {
        $id_perawat = $_POST["id_perawat"];

        // KEAMANAN: Gunakan prepared statement untuk query DELETE
        $query = "DELETE FROM perawat WHERE id_perawat=?";
        
        $stmt = mysqli_prepare($koneksi, $query);
        // 'i' artinya tipe data: Integer
        mysqli_stmt_bind_param($stmt, 'i', $id_perawat);
        mysqli_stmt_execute($stmt);
    }

    // Redirect untuk mencegah form dikirim ulang jika halaman di-refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data perawat untuk ditampilkan
$query = 'SELECT * FROM perawat;'; 
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
    .form-group input[type="text"], .form-group input[type="number"], .form-group input[type="date"] { 
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
        <h2>Data Perawat</h2>
        <button onclick="openModalPerawat()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">ID Perawat</th>
                <th scope="col">Nama</th>
                <th scope="col">ID Pasien</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Spesialisasi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="perawatTableBody">
            <?php while ($perawat = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $perawat->id_perawat ?></td>
                    <td><?= $perawat->nama_perawat ?></td>
                    <td><?= $perawat->id_pasien ?></td>
                    <td><?= $perawat->no_telepon ?></td>
                    <td><?= $perawat->spesialisasi ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $perawat->id_perawat ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $perawat->id_perawat ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<!-- Modal for adding/editing nurse data -->
<div id="perawatModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModalPerawat()">&times;</span>
        <h2 id="modalTitlePerawat">Tambah Data Perawat</h2>
        <form id="perawatForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="id_perawat" id="idPerawatInput" value="">
            
            <div class="form-group">
                <label for="nama_perawat">Nama Perawat</label>
                <input type="text" name="nama_perawat" id="namaPerawat" required>
            </div>
            <div class="form-group">
                <label for="id_pasien">ID Pasien</label>
                <input type="text" name="id_pasien" id="idPasienPerawat" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>
                <input type="tel" name="no_telepon" id="teleponPerawat" required>
            </div>
            <div class="form-group">
                <label for="spesialisasi">Spesialisasi</label>
                <input type="text" name="spesialisasi" id="spesialisasiPerawat" required>
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModalPerawat()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan ID Perawat untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="id_perawat_delete">ID Perawat</label>
                <input type="text" name="id_perawat" id="id_perawat_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>

    function closeModalPerawat() {
        document.getElementById('perawatModal').style.display = 'none';
    }

    function openDeleteModal(id_perawat) {
        document.getElementById('id_perawat_delete').value = id_perawat; // Set the id_perawat to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function openModalPerawat(mode, dataPerawat = null) {
        // Reset form setiap kali dibuka
        document.getElementById('perawatForm').reset();

        const modalTitle = document.getElementById('modalTitlePerawat');
        const actionInput = document.getElementById('action');
        const idInput = document.getElementById('idPerawatInput');

        if (mode === 'edit' && dataPerawat) {
            // --- MODE EDIT ---
            modalTitle.innerText = 'Edit Data Perawat';
            actionInput.value = 'edit';
            
            // Isi semua field dengan data yang didapat dari server
            idInput.value = dataPerawat.id_perawat;
            document.getElementById('namaPerawat').value = dataPerawat.nama_perawat;
            document.getElementById('idPasienPerawat').value = dataPerawat.id_pasien;
            document.getElementById('teleponPerawat').value = dataPerawat.no_telepon;
            document.getElementById('spesialisasiPerawat').value = dataPerawat.spesialisasi;

        } else {
            // --- MODE TAMBAH ---
            modalTitle.innerText = 'Tambah Data Perawat';
            actionInput.value = 'insert';
            idInput.value = ''; // Pastikan ID kosong saat tambah data
        }

        // Tampilkan modal
        document.getElementById('perawatModal').style.display = 'block';
    }

    function toggleEditForm(id_perawat) {
        // URL ke endpoint AJAX yang kita buat di PHP
        const url = `perawat.php?action=get_data&id=${id_perawat}`;

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
                    openModalPerawat('edit', data);
                } else {
                    alert('Data perawat tidak ditemukan.');
                }
            })
            .catch(error => {
                // Tangani jika ada error saat fetching data
                console.error('Error fetching perawat data:', error);
                alert('Gagal mengambil data perawat. Silakan coba lagi.');
            });
    }

</script>

<?php include 'layouts/footer.php'; ?>
