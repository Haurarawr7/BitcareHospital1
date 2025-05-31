<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $nomor_ruangan = $_POST["nomor_ruangan"];
        $nomor_lantai = $_POST["nomor_lantai"];
        $jenis_ruangan = $_POST["jenis_ruangan"];
        $kapasitas = $_POST["kapasitas"];
        $alat_ruangan = $_POST["alat_ruangan"];
    
        $query = "INSERT INTO ruangan (nomor_ruangan, nomor_lantai, jenis_ruangan, kapasitas, alat_ruangan) 
            VALUES ('$nomor_ruangan', '$nomor_lantai', '$jenis_ruangan', '$kapasitas', '$alat_ruangan')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $nomor_ruangan = $_POST["nomor_ruangan"];
        $nomor_lantai = $_POST["nomor_lantai"];
        $jenis_ruangan = $_POST["jenis_ruangan"];
        $kapasitas = $_POST["kapasitas"];
        $alat_ruangan = $_POST["alat_ruangan"];
        
        $query = "UPDATE ruangan SET nomor_lantai='$nomor_lantai', jenis_ruangan='$jenis_ruangan', kapasitas='$kapasitas', alat_ruangan='$alat_ruangan' WHERE nomor_ruangan='$nomor_ruangan'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $nomor_ruangan = $_POST["nomor_ruangan"];
        $query = "DELETE FROM ruangan WHERE nomor_ruangan='$nomor_ruangan'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all rooms
$query = 'SELECT * FROM ruangan;'; 
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
    <div class="menu-item" onclick="window.location.href='pelayanan.php'">Pelayanan</div>
    <div class="menu-item" onclick="window.location.href='tindakanmedis.php'">Tindakan medis</div>
    <div class="menu-item" onclick="window.location.href='rekammedis.php'">Rekam medis</div>
    <div class="menu-item" onclick="window.location.href='obat.php'">Obat</div>
    <div class="menu-item" onclick="window.location.href='transaksi.php'">Transaksi</div>
    <div class="menu-item" onclick="window.location.href='urangan.php'">Ruangan</div>
    <div class="menu-item" onclick="window.location.href='staff.php'">Staff</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item" onclick="window.location.href='perawat.php'">Perawat</div>
    <div class="menu-item" onclick="window.location.href='dokter.php'">Dokter</div>
  </div>

<section class="p-4 ml-5 mr-5 w-75">
    <div class="d-flex flex-row justify-content-between">
        <h2>Data Ruangan</h2>
        <button onclick="openModal()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">Nomor Ruangan</th>
                <th scope="col">Nomor Lantai</th>
                <th scope="col">Jenis Ruangan</th>
                <th scope="col">Kapasitas</th>
                <th scope="col">Alat di Ruangan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="ruanganTableBody">
            <?php while ($ruangan = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $ruangan->nomor_ruangan ?></td>
                    <td><?= $ruangan->nomor_lantai ?></td>
                    <td><?= $ruangan->jenis_ruangan ?></td>
                    <td><?= $ruangan->kapasitas ?></td>
                    <td><?= $ruangan->alat_ruangan ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $ruangan->nomor_ruangan ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $ruangan->nomor_ruangan ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<!-- Modal for adding/editing room data -->
<div id="ruanganModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Ruangan</h2>
        <form id="ruanganForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="nomor_ruangan" id="nomorRuanganInput" value="">
            
            <div class="form-group">
                <label for="nomorRuangan">Nomor Ruangan</label>
                <input type="text" name="nomor_ruangan" id="nomorRuangan" required>
            </div>
            <div class="form-group">
                <label for="nomorLantai">Nomor Lantai</label>
                <input type="number" name="nomor_lantai" id="nomorLantai" required>
            </div>
            <div class="form-group">
                <label for="jenisRuangan">Jenis Ruangan</label>
                <input type="text" name="jenis_ruangan" id="jenisRuangan" required>
            </div>
            <div class="form-group">
                <label for="kapasitas">Kapasitas</label>
                <input type="number" name="kapasitas" id="kapasitas" required>
            </div>
            <div class="form-group">
                <label for="alatRuangan">Alat di Ruangan</label>
                <input type="text" name="alat_ruangan" id="alatRuangan" required>
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
        <p>Masukkan Nomor Ruangan untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="nomor_ruangan_delete">Nomor Ruangan</label>
                <input type="text" name="nomor_ruangan" id="nomor_ruangan_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(ruanganData = null) {
        document.getElementById('ruanganForm').reset();
        document.getElementById('nomorRuanganInput').value = '';

        if (ruanganData) {
            document.getElementById('action').value = 'edit';
            document.getElementById('nomorRuanganInput').value = ruanganData.nomor_ruangan;
            document.getElementById('nomorRuangan').value = ruanganData.nomor_ruangan;
            document.getElementById('nomorLantai').value = ruanganData.nomor_lantai;
            document.getElementById('jenisRuangan').value = ruanganData.jenis_ruangan;
            document.getElementById('kapasitas').value = ruanganData.kapasitas;
            document.getElementById('alatRuangan').value = ruanganData.alat_ruangan;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('ruanganModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('ruanganModal').style.display = 'none';
    }

    function openDeleteModal(nomor_ruangan) {
        document.getElementById('nomor_ruangan_delete').value = nomor_ruangan; // Set the nomor_ruangan to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(nomor_ruangan) {
        // Fetch the data for the selected room and open the formulir
        openModal({ nomor_ruangan: nomor_ruangan, nomor_lantai: 'Dummy', jenis_ruangan: 'Dummy', kapasitas: 10, alat_ruangan: 'Dummy' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
