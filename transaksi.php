<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $no_transaksi = $_POST["no_transaksi"];
        $tanggal_transaksi = $_POST["tanggal_transaksi"];
        $no_ruang = $_POST["no_ruang"];
        $id_pasien = $_POST["id_pasien"];
        $jenis_transaksi = $_POST["jenis_transaksi"];
        $total_harga = $_POST["total_harga"];
        $asuransi = $_POST["asuransi"] ?? null;

        $query = "INSERT INTO transaksi (no_transaksi, tanggal_transaksi, no_ruang, id_pasien, jenis_transaksi, total_harga, asuransi) 
            VALUES ('$no_transaksi', '$tanggal_transaksi', '$no_ruang', '$id_pasien', '$jenis_transaksi', '$total_harga', '$asuransi')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $no_transaksi = $_POST["no_transaksi"];
        $tanggal_transaksi = $_POST["tanggal_transaksi"];
        $no_ruang = $_POST["no_ruang"];
        $id_pasien = $_POST["id_pasien"];
        $jenis_transaksi = $_POST["jenis_transaksi"];
        $total_harga = $_POST["total_harga"];
        $asuransi = $_POST["asuransi"] ?? null;

        $query = "UPDATE transaksi SET tanggal_transaksi='$tanggal_transaksi', no_ruang='$no_ruang', id_pasien='$id_pasien', jenis_transaksi='$jenis_transaksi', total_harga='$total_harga', asuransi='$asuransi' WHERE no_transaksi='$no_transaksi'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $no_transaksi = $_POST["no_transaksi"];
        $query = "DELETE FROM transaksi WHERE no_transaksi='$no_transaksi'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all transactions
$query = 'SELECT * FROM transaksi;'; 
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
    <div class="menu-item" onclick="window.location.href='ruangan.php'">Ruangan</div>
    <div class="menu-item" onclick="window.location.href='staff.php'">Staff</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item" onclick="window.location.href='perawat.php'">Perawat</div>
    <div class="menu-item" onclick="window.location.href='dokter.php'">Dokter</div>
  </div>

<section class="p-4 ml-5 mr-5 w-75">
    <div class="d-flex flex-row justify-content-between">
        <h2>Data Staff</h2>
        <button onclick="openModal()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">No Transaksi</th>
                <th scope="col">Tanggal Transaksi</th>
                <th scope="col">No Ruangan</th>
                <th scope="col">Id_pasien</th>
                <th scope="col">Jenis Transaksi</th>
                <th scope="col">Total harga</th>
                <th scope="col">Asuransi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="transaksiTableBody">
            <?php while ($transaksi = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $transaksi->no_transaksi ?></td>
                    <td><?= $transaksi->tanggal_transaksi ?></td>
                    <td><?= $transaksi->no_ruang ?></td>
                    <td><?= $transaksi->id_pasien ?></td>
                    <td><?= $transaksi->jenis_transaksi ?></td>
                    <td><?= $transaksi->total_harga ?></td>
                    <td><?= $transaksi->asuransi ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $transaksi->no_transaksi ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $transaksi->no_transaksi ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<!-- Modal for adding/editing transaction data -->
<div id="transaksiModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModalTransaksi()">&times;</span>
        <h2 id="modalTitleTransaksi">Tambah Data Transaksi</h2>
        <form id="transaksiForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="no_transaksi" id="kodeTransaksiInput" value="">
            
            <div class="form-group">
                <label for="kodeTransaksi">Kode Transaksi:</label>
                <input type="text" name="no_transaksi" id="kodeTransaksi" required>
            </div>
            <div class="form-group">
                <label for="tanggalTransaksi">Tanggal Transaksi:</label>
                <input type="date" name="tanggal_transaksi" id="tanggalTransaksi" required>
            </div>
            <div class="form-group">
                <label for="noRuang">Nomor Ruang:</label>
                <input type="text" name="no_ruang" id="noRuang" required>
            </div>
            <div class="form-group">
                <label for="idPasien">ID Pasien:</label>
                <input type="text" name="id_pasien" id="idPasien" required>
            </div>
            <div class="form-group">
                <label for="jenisTransaksi">Jenis Transaksi:</label>
                <input type="text" name="jenis_transaksi" id="jenisTransaksi" required>
            </div>
            <div class="form-group">
                <label for="totalHarga">Total Harga (Rp):</label>
                <input type="number" name="total_harga" id="totalHarga" required>
            </div>
            <div class="form-group">
                <label for="asuransi">Asuransi:</label>
                <input type="text" name="asuransi" id="asuransi">
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModalTransaksi()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan Kode Transaksi untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="kode_transaksi_delete">Kode Transaksi</label>
                <input type="text" name="no_transaksi" id="kode_transaksi_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModalTransaksi(dataTransaksi = null) {
        document.getElementById('transaksiForm').reset();
        document.getElementById('kodeTransaksiInput').value = '';

        if (dataTransaksi) {
            document.getElementById('action').value = 'edit';
            document.getElementById('kodeTransaksiInput').value = dataTransaksi.no_transaksi;
            document.getElementById('kodeTransaksi').value = dataTransaksi.no_transaksi;
            document.getElementById('tanggalTransaksi').value = dataTransaksi.tanggal_transaksi;
            document.getElementById('noRuang').value = dataTransaksi.no_ruang;
            document.getElementById('idPasien').value = dataTransaksi.id_pasien;
            document.getElementById('jenisTransaksi').value = dataTransaksi.jenis_transaksi;
            document.getElementById('totalHarga').value = dataTransaksi.total_harga;
            document.getElementById('asuransi').value = dataTransaksi.asuransi;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('transaksiModal').style.display = 'block';
    }

    function closeModalTransaksi() {
        document.getElementById('transaksiModal').style.display = 'none';
    }

    function openDeleteModal(kodeTransaksi) {
        document.getElementById('kode_transaksi_delete').value = kodeTransaksi; // Set the no_transaksi to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(kodeTransaksi) {
        // Fetch the data for the selected transaction and open the formulir
        openModalTransaksi({ no_transaksi: kodeTransaksi, tanggal_transaksi: 'isi disini', no_ruang: 'isi disini', id_pasien: 'isi disini', jenis_transaksi: 'isi disini', total_harga: 0, asuransi: 'isi disini' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
