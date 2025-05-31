<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id_staff = $_POST["id_staff"];
        $nama_staf = $_POST["nama_staf"];
        $jabatan = $_POST["jabatan"];
        $no_telepon = $_POST["no_telepon"];
        $no_ruang = $_POST["no_ruang"];

        $query = "INSERT INTO staff (id_staff, nama_staf, jabatan, no_telepon, no_ruang, , ) 
            VALUES ('$id_staff', '$nama_staf', '$jabatan', '$no_telepon', '$no_ruang', '$', '$')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $id_staff = $_POST["id_staff"];
        $nama_staf = $_POST["nama_staf"];
        $jabatan = $_POST["jabatan"];
        $no_telepon = $_POST["no_telepon"];
        $no_ruang = $_POST["no_ruang"];

        $query = "UPDATE staff SET nama_staf='$nama_staf', jabatan='$jabatan', no_telepon='$no_telepon', no_ruang='$no_ruang', ='$', ='$' WHERE id_staff='$id_staff'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $id_staff = $_POST["id_staff"];
        $query = "DELETE FROM staff WHERE id_staff='$id_staff'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all staff
$query = 'SELECT * FROM staff;'; 
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
        <h1>📋 Data staff</h1>
    </header>
    <button class="add-btn" onclick="openModal()">➕ Tambah Data Staff</button>

    <table>
        <thead>
            <tr>
                <th>ID staff</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Ruang</th>
                <th>Nomor Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="staffTableBody">
            <?php while ($staff = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $staff->id_staff ?></td>
                    <td><?= $staff->nama_staf ?></td>
                    <td><?= $staff->jabatan ?></td>
                    <td><?= $staff->no_ruang ?></td>
                    <td><?= $staff->no_telepon ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $staff->id_staff ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $staff->id_staff ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<!-- Modal for adding/editing staff data -->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data staff</h2>
        <form id="staffForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="id_staff" id="staffIdInput" value="">
            
            <div class="form-group">
                <label for="nama_staf">Nama staff</label>
                <input type="text" name="nama_staf" id="nama_staf" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" required>
            </div>
            <div class="form-group">
                <label for="no_ruang">Ruang</label>
                <input type="text" name="no_ruang" id="no_ruang" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>
                <input type="tel" name="no_telepon" id="telepon" required>
            </div>
            <div class="form-group">
                <label for="">Jenis staff</label>
                <select id="jenisStaf" name="" required>
                    <option value="">Pilih Jenis staff...</option>
                    <option value="Administrasi">Administrasi</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Kode Spesifik</label>
                <input type="text" name="" id="kodeSpesifik">
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan ID staff untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="id_staf_delete">ID Staff</label>
                <input type="text" name="id_staff" id="id_staf_delete" required>
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
            document.getElementById('staffIdInput').value = stafData.id_staff;
            document.getElementById('nama_staf').value = stafData.nama_staf;
            document.getElementById('jabatan').value = stafData.jabatan;
            document.getElementById('no_ruang').value = stafData.no_ruang;
            document.getElementById('telepon').value = stafData.no_telepon;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('staffModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('staffModal').style.display = 'none';
    }

    function openDeleteModal(id_staff) {
        document.getElementById('id_staf_delete').value = id_staff; // Set the id_staff to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id_staff) {
        // Fetch the data for the selected staff and open the modal
        openModal({ id_staff: id_staff, nama_staf: 'Dummy', jabatan: 'Dummy', no_telepon: 'Dummy', no_ruang: 'Dummy'});
    }
</script>

<?php include 'layouts/footer.php'; ?>
