<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id = $_POST["id"];
        $nama_dokter = $_POST["nama_dokter"];
        $jabatan = $_POST["jabatan"];
        $no_telepon = $_POST["no_telepon"];
        $jadwal_dokter = $_POST["jadwal_dokter"];
        $no_antrian = $_POST["no_antrian"];
        $no_ruangan = $_POST["no_ruangan"];
        $jenis_dokter = $_POST["jenis_dokter"];
        $kodekhusus = $_POST["kodekhusus"] ?? null;


        $query = "INSERT INTO dokter (id, nama_dokter, jabatan, no_telepon, jadwal_dokter, no_antrian, no_ruangan, jenis_dokter, kodekhusus, ) 
            VALUES ('$id', '$nama_dokter', '$jabatan', '$no_telepon', '$jadwal_dokter', '$no_antrian', '$no_ruangan', '$jenis_dokter', '$kodekhusus', '$')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $id = $_POST["id"];
        $nama_dokter = $_POST["nama_dokter"];
        $jabatan = $_POST["jabatan"];
        $no_telepon = $_POST["no_telepon"];
        $jadwal_dokter = $_POST["jadwal_dokter"];
        $no_antrian = $_POST["no_antrian"];
        $no_ruangan = $_POST["no_ruangan"];
        $jenis_dokter = $_POST["jenis_dokter"];
        $kodekhusus = $_POST["kodekhusus"] ?? null;


        $query = "UPDATE dokter SET nama_dokter='$nama_dokter', jabatan='$jabatan', no_telepon='$no_telepon', jadwal_dokter='$jadwal_dokter', no_antrian='$no_antrian', no_ruangan='$no_ruangan', jenis_dokter='$jenis_dokter', kodekhusus='$kodekhusus', ='$' WHERE id='$id'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $id = $_POST["id"];
        $query = "DELETE FROM dokter WHERE id='$id'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all doctors
$query = 'SELECT * FROM dokter;'; 
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
        <h2>Data Dokter</h2>
        <button onclick="openModalDokter()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">ID Dokter</th>
                <th scope="col">nama_dokter</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">jadwal_dokter</th>
                <th scope="col">No Antrian</th>
                <th scope="col">No Ruangan</th>
                <th scope="col">Jenis Dokter</th>
                <th scope="col">Kode Khusus</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="dokterTableBody">
            <?php while ($dokter = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $dokter->id ?></td>
                    <td><?= $dokter->nama_dokter ?></td>
                    <td><?= $dokter->jabatan ?></td>
                    <td><?= $dokter->no_telepon ?></td>
                    <td><?= $dokter->jadwal_dokter ?></td>
                    <td><?= $dokter->no_antrian ?></td>
                    <td><?= $dokter->no_ruangan ?></td>
                    <td><?= $dokter->jenis_dokter ?></td>
                    <td><?= $dokter->kodekhusus ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $dokter->id ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $dokter->id ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<!-- Modal for adding/editing doctor data -->
<div id="dokterModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeModalDokter()">&times;</span>
        <h2 id="modalTitleDokter">Tambah Data Dokter</h2>
        <form id="dokterForm" method="POST">
            <input type="hidden" name="action" id="action" value="insert">
            <input type="hidden" name="id" id="idDokterInput" value="">
            
            <div class="form-group">
                <label for="nama_dokter">nama_dokter Dokter</label>
                <input type="text" name="nama_dokter" id="namaDokter" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatanDokter" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>
                <input type="tel" name="no_telepon" id="teleponDokter" required>
            </div>
            <div class="form-group">
                <label for="jadwal_dokter">jadwal_dokter</label>
                <input type="text" name="jadwal_dokter" id="jadwalDokter" required>
            </div>
            <div class="form-group">
                <label for="no_antrian">No Antrian</label>
                <input type="text" name="no_antrian" id="noAntrianDokter" required>
            </div>
            <div class="form-group">
                <label for="no_ruangan">No Ruangan</label>
                <input type="text" name="no_ruangan" id="noRuanganDokter" required>
            </div>
            <div class="form-group">
                <label for="jenis_dokter">Jenis Dokter</label>
                <input type="text" name="jenis_dokter" id="jenisDokter" required>
            </div>
            <div class="form-group">
                <label for="kodekhusus">Kode Khusus</label>
                <input type="text" name="kodekhusus" id="kodeKhususDokter">
            </div>
            <div class="form-group">
                <label for="">Kode Operasi</label>
                <input type="text" name="" id="kodeOperasiDokter">
            </div>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeModalDokter()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal for confirming delete -->
<div id="deleteModal" class="formulir">
    <div class="formulir-content">
        <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Masukkan ID Dokter untuk menghapus data:</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <label for="id_dokter_delete">ID Dokter</label>
                <input type="text" name="id" id="id_dokter_delete" required>
            </div>
            <button type="submit">Hapus</button>
            <button type="button" onclick="closeDeleteModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModalDokter(dataDokter = null) {
        document.getElementById('dokterForm').reset();
        document.getElementById('idDokterInput').value = '';

        if (dataDokter) {
            document.getElementById('action').value = 'edit';
            document.getElementById('idDokterInput').value = dataDokter.id;
            document.getElementById('namaDokter').value = dataDokter.nama_dokter;
            document.getElementById('jabatanDokter').value = dataDokter.jabatan;
            document.getElementById('teleponDokter').value = dataDokter.no_telepon;
            document.getElementById('jadwalDokter').value = dataDokter.jadwal_dokter;
            document.getElementById('noAntrianDokter').value = dataDokter.no_antrian;
            document.getElementById('noRuanganDokter').value = dataDokter.no_ruangan;
            document.getElementById('jenisDokter').value = dataDokter.jenis_dokter;
            document.getElementById('kodeKhususDokter').value = dataDokter.kodekhusus;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('dokterModal').style.display = 'block';
    }

    function closeModalDokter() {
        document.getElementById('dokterModal').style.display = 'none';
    }

    function openDeleteModal(id) {
        document.getElementById('id_dokter_delete').value = id; // Set the id to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id) {
        // Fetch the data for the selected doctor and open the formulir
        // This function should be implemented to fetch data from the server
        openModalDokter({ id: id, nama_dokter: 'isi disini', jabatan: 'isi disini', no_telepon: 'isi disini', jadwal_dokter: 'isi disini', no_antrian: 'isi disini', no_ruangan: 'isi disini', jenis_dokter: 'isi disini', kodekhusus: 'isi disini'});
    }
</script>

<?php include 'layouts/footer.php'; ?>
