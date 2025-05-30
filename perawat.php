<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id_perawat = $_POST["id_perawat"];
        $nama = $_POST["nama"];
        $id_pasien = $_POST["id_pasien"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $spesialisasi = $_POST["spesialisasi"];
    
        $query = "INSERT INTO perawat (id_perawat, nama, id_pasien, nomor_telepon, spesialisasi) 
            VALUES ('$id_perawat', '$nama', '$id_pasien', '$nomor_telepon', '$spesialisasi')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $id_perawat = $_POST["id_perawat"];
        $nama = $_POST["nama"];
        $id_pasien = $_POST["id_pasien"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $spesialisasi = $_POST["spesialisasi"];
        
        $query = "UPDATE perawat SET nama='$nama', id_pasien='$id_pasien', nomor_telepon='$nomor_telepon', spesialisasi='$spesialisasi' WHERE id_perawat='$id_perawat'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $id_perawat = $_POST["id_perawat"];
        $query = "DELETE FROM perawat WHERE id_perawat='$id_perawat'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all nurses
$query = 'SELECT * FROM perawat;'; 
$result = mysqli_query($koneksi, $query); 

include 'layouts/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap');
    * { box-sizing: border-box; }
    body { 
        margin: 0; 
        font-family: 'Nunito Sans', sans-serif; 
        display: flex; 
        min-height: 100vh; 
        background: linear-gradient(135deg, #f4f7f6 0%, #00897b 100%); 
        color: #3c4858; 
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
    .modal { 
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); padding-top: 60px; }
    .modal-content { 
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
    .form-group { margin-bottom: 15px; }
    .form-group label { 
        display: block; 
        margin-bottom: 5px; 
    }
    .form-group input[type="text"], .form-group input[type="number"], .form-group input[type="tel"] { 
        width: calc(100% - 22px);
        padding: 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }

</style>

<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <div class="menu-item">Tindakan medis</div>
    <div class="menu-item">Rekam medis</div>
    <div class="menu-item" onclick="window.location.href='obat.php'">Obat</div>
    <div class="menu-item">Transaksi</div>
    <div class="menu-item">Ruangan</div>
    <div class="menu-item">Staff</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item" onclick="window.location.href='perawat.php'">Perawat</div>
    <div class="menu-item">Dokter</div>
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
                    <td><?= $perawat->nama ?></td>
                    <td><?= $perawat->id_pasien ?></td>
                    <td><?= $perawat->nomor_telepon ?></td>
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
<div id="perawatModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModalPerawat()">&times;</span>
        <h2 id="modalTitlePerawat">Tambah Data Perawat</h2>
        <form id="perawatForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="id_perawat" id="idPerawatInput" value="">
            
            <div class="form-group">
                <label for="nama">Nama Perawat</label>
                <input type="text" name="nama" id="namaPerawat" required>
            </div>
            <div class="form-group">
                <label for="id_pasien">ID Pasien</label>
                <input type="text" name="id_pasien" id="idPasienPerawat" required>
            </div>
            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="tel" name="nomor_telepon" id="teleponPerawat" required>
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
<div id="deleteModal" class="modal">
    <div class="modal-content">
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
    function openModalPerawat(dataPerawat = null) {
        document.getElementById('perawatForm').reset();
        document.getElementById('idPerawatInput').value = '';

        if (dataPerawat) {
            document.getElementById('action').value = 'edit';
            document.getElementById('idPerawatInput').value = dataPerawat.id_perawat;
            document.getElementById('namaPerawat').value = dataPerawat.nama;
            document.getElementById('idPasienPerawat').value = dataPerawat.id_pasien;
            document.getElementById('teleponPerawat').value = dataPerawat.nomor_telepon;
            document.getElementById('spesialisasiPerawat').value = dataPerawat.spesialisasi;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('perawatModal').style.display = 'block';
    }

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

    function toggleEditForm(id_perawat) {
        // Fetch the data for the selected nurse and open the modal
        // This function should be implemented to fetch data from the server
        openModalPerawat({ id_perawat: id_perawat, nama: 'Dummy', id_pasien: 'Dummy', nomor_telepon: 'Dummy', spesialisasi: 'Dummy' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
