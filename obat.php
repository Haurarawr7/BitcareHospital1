<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $kode_obat = $_POST["kode_obat"];
        $nama_obat = $_POST["nama_obat"];
        $dosis = $_POST["dosis"];
        $tanggal_produksi = $_POST["tanggal_produksi"];
        $stok = $_POST["stok"];
        $harga = $_POST["harga"];
    
        $query = "INSERT INTO obat (kode_obat, nama_obat, dosis, tanggal_produksi, stok, harga) 
            VALUES ('$kode_obat', '$nama_obat', '$dosis', '$tanggal_produksi', '$stok', '$harga')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $kode_obat = $_POST["kode_obat"];
        $nama_obat = $_POST["nama_obat"];
        $dosis = $_POST["dosis"];
        $tanggal_produksi = $_POST["tanggal_produksi"];
        $stok = $_POST["stok"];
        $harga = $_POST["harga"];
        $query = "UPDATE obat SET nama_obat='$nama_obat', dosis='$dosis', tanggal_produksi='$tanggal_produksi', stok='$stok', harga='$harga' WHERE kode_obat='$kode_obat'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $kode_obat = $_POST["kode_obat"];
        $query = "DELETE FROM obat WHERE kode_obat='$kode_obat'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all medicines
$query = 'SELECT * FROM obat;'; 
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
        <h2>Data Obat</h2>
        <button onclick="openModal()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">Kode Obat</th>
                <th scope="col">Nama Obat</th>
                <th scope="col">Dosis</th>
                <th scope="col">Tanggal kadaluarsa</th>
                <th scope="col">Stok</th>
                <th scope="col">Harga (Rp)</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($obat = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $obat->kode_obat ?></td>
                    <td><?= $obat->nama_obat ?></td>
                    <td><?= $obat->dosis ?></td>
                    <td><?= $obat->tanggal_kadaluarsa ?></td>
                    <td><?= $obat->stok ?></td>
                    <td><?= $obat->harga ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $obat->kode_obat ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $obat->kode_obat ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<!-- Modal for adding/editing medicine data -->
<div id="obatModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Obat</h2>
        <form id="obatForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="kode_obat" id="kodeObatInput" value="">
            
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" required>
            </div>
            <div class="form-group">
                <label for="dosis">Dosis</label>
                <input type="text" name="dosis" id="dosis" required>
            </div>
            <div class="form-group">
                <label for="tanggal_produksi">Tanggal Produksi</label>
                <input type="date" name="tanggal_produksi" id="tanggal_produksi" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" required>
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
        <p>Masukkan Kode Obat untuk menghapus data obat:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="kode_obat_delete">Kode Obat</label>
                <input type="text" name="kode_obat" id="kode_obat_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(obatData = null) {
        document.getElementById('obatForm').reset();
        document.getElementById('kodeObatInput').value = '';

        if (obatData) {
            document.getElementById('action').value = 'edit';
            document.getElementById('kodeObatInput').value = obatData.kode_obat;
            document.getElementById('nama_obat').value = obatData.nama_obat;
            document.getElementById('dosis').value = obatData.dosis;
            document.getElementById('tanggal_produksi').value = obatData.tanggal_produksi;
            document.getElementById('stok').value = obatData.stok;
            document.getElementById('harga').value = obatData.harga;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('obatModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('obatModal').style.display = 'none';
    }

    function openDeleteModal(kode_obat) {
        document.getElementById('kode_obat_delete').value = kode_obat; // Set the kode_obat to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(kode_obat) {

        openModal({ kode_obat: kode_obat, nama_obat: 'isi disini', dosis: '500mg', tanggal_produksi: '2023-01-01', stok: 10, harga: 15000 });
    }
</script>

<?php include 'layouts/footer.php'; ?>
