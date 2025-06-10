<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $tanggal_rekam = $_POST["tanggal_rekam"];
        $id_pasien = $_POST["id_pasien"];
        $riwayat = $_POST["riwayat"];
        $id_dokter = $_POST["id_dokter"];
    
        $query = "INSERT INTO rekam_medis (tanggal_rekam, id_pasien, riwayat, id_dokter) 
            VALUES ('$tanggal_rekam', '$id_pasien', '$riwayat', '$id_dokter')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $tanggal_rekam = $_POST["tanggal_rekam"];
        $id_pasien = $_POST["id_pasien"];
        $riwayat = $_POST["riwayat"];
        $id_dokter = $_POST["id_dokter"];
        
        $query = "UPDATE rekam_medis SET tanggal_rekam='$tanggal_rekam', id_pasien='$id_pasien', riwayat='$riwayat', id_dokter='$id_dokter' WHERE no_rekam_medis='$no_rekam_medis'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $query = "DELETE FROM rekam_medis WHERE no_rekam_medis='$no_rekam_medis'";
        $query = "DELETE FROM tindakan_medis WHERE no_rekam_medis='$no_rekam_medis'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all medical records
$query = 'SELECT * FROM rekam_medis;'; 
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
        <h2>Data Rekam Medis</h2>
        <button onclick="openModal()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">No. Rekam Medis</th>
                <th scope="col">Tanggal rekam</th>
                <th scope="col">ID Pasien</th>
                <th scope="col">Riwayat Penyakit/Keluhan</th>
                <th scope="col">ID Dokter</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="rekamMedisTableBody">
            <?php while ($rekam = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $rekam->no_rekam_medis ?></td>
                    <td><?= $rekam->tanggal_rekam ?></td>
                    <td><?= $rekam->id_pasien ?></td>
                    <td><?= $rekam->riwayat ?></td>
                    <td><?= $rekam->id_dokter ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $rekam->no_rekam_medis ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $rekam->no_rekam_medis ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<!-- Modal for adding/editing medical record data -->
<div id="rekamMedisModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Rekam Medis</h2>
        <form id="rekamMedisForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="no_rekam_medis" id="noRekamMedisInput" value="">
            
            <div class="form-group">
                <label for="tanggalRekamMedis">tanggal_rekam Rekam Medis:</label>
                <input type="date" id="tanggalRekamMedis" name="tanggal_rekam" required>
            </div>
            <div class="form-group">
                <label for="idPasienRm">ID Pasien:</label>
                <input type="text" id="idPasienRm" name="id_pasien" required>
            </div>
            <div class="form-group">
                <label for="riwayatRekamMedis">Riwayat Penyakit/Keluhan:</label>
                <textarea id="riwayatRekamMedis" name="riwayat" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="idDokterRm">ID Dokter:</label>
                <input type="text" id="idDokterRm" name="id_dokter" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan</button>
                <button type="button" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan No Rekam Medis untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="no_rekam_medis_delete">No Rekam Medis</label>
                <input type="text" name="no_rekam_medis" id="no_rekam_medis_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(dataRekamMedis = null) {
        document.getElementById('rekamMedisForm').reset();
        document.getElementById('noRekamMedisInput').value = '';

        if (dataRekamMedis) {
            document.getElementById('action').value = 'edit';
            document.getElementById('noRekamMedisInput').value = dataRekamMedis.no_rekam_medis;
            document.getElementById('tanggalRekamMedis').value = dataRekamMedis.tanggal_rekam;
            document.getElementById('idPasienRm').value = dataRekamMedis.id_pasien;
            document.getElementById('riwayatRekamMedis').value = dataRekamMedis.riwayat;
            document.getElementById('idDokterRm').value = dataRekamMedis.id_dokter;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('rekamMedisModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('rekamMedisModal').style.display = 'none';
    }

    function openDeleteModal(no_rekam_medis) {
        document.getElementById('no_rekam_medis_delete').value = no_rekam_medis; // Set the no_rekam_medis to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(no_rekam_medis) {
        // Fetch the data for the selected medical record and open the formulir
        // This function should be implemented to fetch data from the server
        openModal({ no_rekam_medis: no_rekam_medis, tanggal_rekam: '2023-01-01', id_pasien: 'isi disini', riwayat: 'isi disini', id_dokter: 'isi disini' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
