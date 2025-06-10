<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $no_tindakan = $_POST["no_tindakan"];
        $tanggal_tindakan = $_POST["tanggal_tindakan"];
        $id_dokter = $_POST["id_dokter"];
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $jenis_tindakan = $_POST["jenis_tindakan"];

        $query = "INSERT INTO tindakan_medis (no_tindakan, tanggal_tindakan, id_dokter, no_rekam_medis, jenis_tindakan) 
            VALUES ('$no_tindakan', '$tanggal_tindakan', '$id_dokter', '$no_rekam_medis', '$jenis_tindakan')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $no_tindakan = $_POST["no_tindakan"];
        $tanggal_tindakan = $_POST["tanggal_tindakan"];
        $id_dokter = $_POST["id_dokter"];
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $jenis_tindakan = $_POST["jenis_tindakan"];

        $query = "UPDATE tindakan_medis SET tanggal_tindakan='$tanggal_tindakan', id_dokter='$id_dokter', no_rekam_medis='$no_rekam_medis', jenis_tindakan='$jenis_tindakan' WHERE no_tindakan='$no_tindakan'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $query = "DELETE FROM rekam_medis WHERE no_rekam_medis='$no_rekam_medis'";
        $query = "DELETE FROM tindakan_medis WHERE no_rekam_medis='$no_rekam_medis'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all medical actions
$query = 'SELECT * FROM tindakan_medis;'; 
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
    <div class="menu-item" onclick="window.location.href='tindakan_medis.php'">Tindakan medis</div>
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
        <h2>Data Tindakan Medis</h2>
        <button onclick="openModalTindakan()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">No. Tindakan</th>
                <th scope="col">Tanggal Tindakan</th>
                <th scope="col">ID Dokter</th>
                <th scope="col">No. Rekam Medis</th>
                <th scope="col">Jenis Tindakan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="tindakanTableBody">
            <?php while ($tindakan = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $tindakan->no_tindakan ?></td>
                    <td><?= $tindakan->tanggal_tindakan ?></td>
                    <td><?= $tindakan->id_dokter ?></td>
                    <td><?= $tindakan->no_rekam_medis ?></td>
                    <td><?= $tindakan->jenis_tindakan ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $tindakan->no_tindakan ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $tindakan->no_rekam_medis ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<!-- Modal for adding/editing medical action data -->
<div id="tindakanModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModalTindakan()">&times;</span>
        <h2 id="modalTitleTindakan">Tambah Data Tindakan Medis</h2>
        <form id="tindakanForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="no_tindakan" id="noTindakanInput" value="">
            
            <div class="form-group">
                <label for="noTindakan">No Tindakan:</label>
                <input type="text" name="no_tindakan" id="noTindakan" required>
            </div>
            <div class="form-group">
                <label for="tanggalTindakan">Tanggal Tindakan:</label>
                <input type="date" name="tanggal_tindakan" id="tanggalTindakan" required>
            </div>
            <div class="form-group">
                <label for="idDokter">ID Dokter:</label>
                <input type="text" name="id_dokter" id="idDokter" required>
            </div>
            <div class="form-group">
                <label for="noRekamMedis">No Rekam Medis:</label>
                <input type="text" name="no_rekam_medis" id="noRekamMedis" required>
            </div>
            <div class="form-group">
                <label for="jenisTindakan">Jenis Tindakan:</label>
                <input type="text" name="jenis_tindakan" id="jenisTindakan" required>
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModalTindakan()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan No Rekam Medis untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="no_rekammedis_delete">No Rekam Medis</label>
                <input type="text" name="no_rekam_medis" id="no_rekammedis_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModalTindakan(dataTindakan = null) {
        document.getElementById('tindakanForm').reset();
        document.getElementById('noTindakanInput').value = '';

        if (dataTindakan) {
            document.getElementById('action').value = 'edit';
            document.getElementById('noTindakanInput').value = dataTindakan.no_tindakan;
            document.getElementById('noTindakan').value = dataTindakan.no_tindakan;
            document.getElementById('tanggalTindakan').value = dataTindakan.tanggal_tindakan;
            document.getElementById('idDokter').value = dataTindakan.id_dokter;
            document.getElementById('noRekamMedis').value = dataTindakan.no_rekam_medis;
            document.getElementById('jenisTindakan').value = dataTindakan.jenis_tindakan;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('tindakanModal').style.display = 'block';
    }

    function closeModalTindakan() {
        document.getElementById('tindakanModal').style.display = 'none';
    }

    function openDeleteModal(no_rekam_medis) {
        document.getElementById('no_rekammedis_delete').value = no_rekam_medis; // Set the no_rekam_medis to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(no_tindakan) {
        // Fetch the data for the selected medical action and open the modal
        openModalTindakan({ no_tindakan: no_tindakan, tanggal_tindakan: 'Dummy', id_dokter: 'Dummy', no_rekam_medis: 'Dummy', jenis_tindakan: 'Dummy' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
