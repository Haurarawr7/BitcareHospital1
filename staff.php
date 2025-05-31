<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id_staf = $_POST["id_staf"];
        $nama = $_POST["nama"];
        $jabatan = $_POST["jabatan"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $ruang = $_POST["ruang"];
        $jenis_staf = $_POST["jenis_staf"];
        $kode_spesifik = $_POST["kode_spesifik"] ?? null;

        $query = "INSERT INTO staf (id_staf, nama, jabatan, nomor_telepon, ruang, jenis_staf, kode_spesifik) 
            VALUES ('$id_staf', '$nama', '$jabatan', '$nomor_telepon', '$ruang', '$jenis_staf', '$kode_spesifik')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $id_staf = $_POST["id_staf"];
        $nama = $_POST["nama"];
        $jabatan = $_POST["jabatan"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $ruang = $_POST["ruang"];
        $jenis_staf = $_POST["jenis_staf"];
        $kode_spesifik = $_POST["kode_spesifik"] ?? null;

        $query = "UPDATE staf SET nama='$nama', jabatan='$jabatan', nomor_telepon='$nomor_telepon', ruang='$ruang', jenis_staf='$jenis_staf', kode_spesifik='$kode_spesifik' WHERE id_staf='$id_staf'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $id_staf = $_POST["id_staf"];
        $query = "DELETE FROM staf WHERE id_staf='$id_staf'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all staff
$query = 'SELECT * FROM staf;'; 
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
    .form-group input[type="text"], .form-group input[type="tel"] { 
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

<section class="main-content">
    <header>
        <h1>📋 Data Staf</h1>
    </header>
    <button class="add-btn" onclick="openModal()">➕ Tambah Data Staf</button>

    <table>
        <thead>
            <tr>
                <th>ID Staf</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Ruang</th>
                <th>Nomor Telepon</th>
                <th>Jenis Staf</th>
                <th>Kode Spesifik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="staffTableBody">
            <?php while ($staf = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $staf->id_staf ?></td>
                    <td><?= $staf->nama ?></td>
                    <td><?= $staf->jabatan ?></td>
                    <td><?= $staf->ruang ?></td>
                    <td><?= $staf->nomor_telepon ?></td>
                    <td><?= $staf->jenis_staf ?></td>
                    <td><?= $staf->kode_spesifik ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $staf->id_staf ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $staf->id_staf ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<!-- Modal for adding/editing staff data -->
<div id="staffModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Staf</h2>
        <form id="staffForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="id_staf" id="staffIdInput" value="">
            
            <div class="form-group">
                <label for="nama">Nama Staf</label>
                <input type="text" name="nama" id="nama" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" required>
            </div>
            <div class="form-group">
                <label for="ruang">Ruang</label>
                <input type="text" name="ruang" id="ruang" required>
            </div>
            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="tel" name="nomor_telepon" id="telepon" required>
            </div>
            <div class="form-group">
                <label for="jenis_staf">Jenis Staf</label>
                <select id="jenisStaf" name="jenis_staf" required>
                    <option value="">Pilih Jenis Staf...</option>
                    <option value="Administrasi">Administrasi</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
            <div class="form-group">
                <label for="kode_spesifik">Kode Spesifik</label>
                <input type="text" name="kode_spesifik" id="kodeSpesifik">
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
        <p>Masukkan ID Staf untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="id_staf_delete">ID Staf</label>
                <input type="text" name="id_staf" id="id_staf_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(stafData = null) {
        document.getElementById('staffForm').reset();
        document.getElementById('staffIdInput').value = '';

        if (stafData) {
            document.getElementById('action').value = 'edit';
            document.getElementById('staffIdInput').value = stafData.id_staf;
            document.getElementById('nama').value = stafData.nama;
            document.getElementById('jabatan').value = stafData.jabatan;
            document.getElementById('ruang').value = stafData.ruang;
            document.getElementById('telepon').value = stafData.nomor_telepon;
            document.getElementById('jenisStaf').value = stafData.jenis_staf;
            document.getElementById('kodeSpesifik').value = stafData.kode_spesifik;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('staffModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('staffModal').style.display = 'none';
    }

    function openDeleteModal(id_staf) {
        document.getElementById('id_staf_delete').value = id_staf; // Set the id_staf to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id_staf) {
        // Fetch the data for the selected staff and open the formulir
        openModal({ id_staf: id_staf, nama: 'Dummy', jabatan: 'Dummy', nomor_telepon: 'Dummy', ruang: 'Dummy', jenis_staf: 'Dummy', kode_spesifik: 'Dummy' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
