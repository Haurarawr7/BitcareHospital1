<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $no_telepon = $_POST["no_telepon"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $gol_darah = $_POST["gol_darah"];
        $alamat = $_POST["alamat"];
        $no_antrian = $_POST["no_antrian"];
    
        $query = "INSERT INTO pasien (id, nama_pasien, tanggal_lahir, no_telepon, jenis_kelamin, gol_darah, alamat, no_antrian) 
            VALUES ('$id', '$nama', '$tanggal_lahir', '$no_telepon', '$jenis_kelamin', '$gol_darah', '$alamat', '$no_antrian')";
        mysqli_query($koneksi, $query);
        }
     elseif ($action == 'edit') {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $no_telepon = $_POST["no_telepon"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $gol_darah = $_POST["gol_darah"];
        $alamat = $_POST["alamat"];
        $no_antrian = $_POST["no_antrian"];
        $query = "UPDATE pasien SET nama_pasien='$nama', tanggal_lahir='$tanggal_lahir', no_telepon='$no_telepon', jenis_kelamin ='$jenis_kelamin', gol_darah='$gol_darah', alamat='$alamat' WHERE id=$id";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $no_antrian = $_POST["no_antrian"];
        $query = "DELETE FROM pelayanan WHERE no_antrian='$no_antrian'";
        $query = "DELETE FROM pasien WHERE no_antrian='$no_antrian'";
        mysqli_query($koneksi, $query);
    }
}
// Fetch all patients
$query = 'SELECT * FROM pasien;'; 
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
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm(<?= $pasien->id ?>)">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal(<?= $pasien->id ?>)">Hapus</button>
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
            <input type="hidden" name="id" id="patientIdInput" value="">
            <input type="hidden" name="no_antrian" id="no_antrianInput" value="">
            
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
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gol_darah">Golongan Darah</label>
                <input type="text" name="gol_darah" id="gol_darah" required>
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
        <p>Masukkan No Antrian untuk menghapus data pasien:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="no_antrian_delete">No Antrian</label>
                <input type="number" name="no_antrian" id="no_antrian_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(patientData = null) {
        document.getElementById('patientForm').reset();
        document.getElementById('patientIdInput').value = '';
        document.getElementById('no_antrianInput').value = '';

        if (patientData) {
            document.getElementById('action').value = 'edit';
            document.getElementById('patientIdInput').value = patientData.id;
            document.getElementById('nama').value = patientData.nama_pasien;
            document.getElementById('tanggal_lahir').value = patientData.tanggal_lahir;
            document.getElementById('no_telepon').value = patientData.no_telepon;
            document.getElementById('jenis_kelamin').value = patientData.jenis_kelamin;
            document.getElementById('gol_darah').value = patientData.gol_darah;
            document.getElementById('alamat').value = patientData.alamat;
            document.getElementById('no_antrian').value = patientData.no_antrian;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('patientModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('patientModal').style.display = 'none';
    }

    function openDeleteModal(no_antrian) {
        document.getElementById('no_antrian_delete').value = no_antrian; // Set the no_antrian to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id, nama, tanggal_lahir, no_telepon, jenis_kelamin, gol_darah, alamat, no_antrian) {
        openModal({ id, nama_pasien: nama, tanggal_lahir, no_telepon, jenis_kelamin, gol_darah, alamat, no_antrian });
    }
</script>

<?php include 'layouts/footer.php'; ?>
