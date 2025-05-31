<?php 
include("koneksi.php"); 

// Handle insert, update, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'insert') {
        $id_dokter = $_POST["id_dokter"];
        $nama = $_POST["nama"];
        $jabatan = $_POST["jabatan"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $jadwal = $_POST["jadwal"];
        $no_antrian = $_POST["no_antrian"];
        $no_ruangan = $_POST["no_ruangan"];
        $jenis_dokter = $_POST["jenis_dokter"];
        $kode_khusus = $_POST["kode_khusus"] ?? null;
        $kode_operasi = $_POST["kode_operasi"] ?? null;

        $query = "INSERT INTO dokter (id_dokter, nama, jabatan, nomor_telepon, jadwal, no_antrian, no_ruangan, jenis_dokter, kode_khusus, kode_operasi) 
            VALUES ('$id_dokter', '$nama', '$jabatan', '$nomor_telepon', '$jadwal', '$no_antrian', '$no_ruangan', '$jenis_dokter', '$kode_khusus', '$kode_operasi')";
        mysqli_query($koneksi, $query);
    }
    elseif ($action == 'edit') {
        $id_dokter = $_POST["id_dokter"];
        $nama = $_POST["nama"];
        $jabatan = $_POST["jabatan"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $jadwal = $_POST["jadwal"];
        $no_antrian = $_POST["no_antrian"];
        $no_ruangan = $_POST["no_ruangan"];
        $jenis_dokter = $_POST["jenis_dokter"];
        $kode_khusus = $_POST["kode_khusus"] ?? null;
        $kode_operasi = $_POST["kode_operasi"] ?? null;

        $query = "UPDATE dokter SET nama='$nama', jabatan='$jabatan', nomor_telepon='$nomor_telepon', jadwal='$jadwal', no_antrian='$no_antrian', no_ruangan='$no_ruangan', jenis_dokter='$jenis_dokter', kode_khusus='$kode_khusus', kode_operasi='$kode_operasi' WHERE id_dokter='$id_dokter'";
        mysqli_query($koneksi, $query);
    } elseif ($action == 'delete') {
        $id_dokter = $_POST["id_dokter"];
        $query = "DELETE FROM dokter WHERE id_dokter='$id_dokter'";
        mysqli_query($koneksi, $query);
    }
}

// Fetch all doctors
$query = 'SELECT * FROM dokter;'; 
$result = mysqli_query($koneksi, $query); 

include 'layouts/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
    * { box-sizing: border-box; }
    body { 
        margin: 0; 
        font-family: 'Open Sans', sans-serif; 
        display: flex; 
        min-height: 100vh; 
        background: linear-gradient(135deg, #f0f5f9 0%, #0277bd 100%); 
        color: #37474f; 
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
        <h2>Data Dokter</h2>
        <button onclick="openModalDokter()">+Tambah</button>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">ID Dokter</th>
                <th scope="col">Nama</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Jadwal</th>
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
                    <td><?= $dokter->id_dokter ?></td>
                    <td><?= $dokter->nama ?></td>
                    <td><?= $dokter->jabatan ?></td>
                    <td><?= $dokter->nomor_telepon ?></td>
                    <td><?= $dokter->jadwal ?></td>
                    <td><?= $dokter->no_antrian ?></td>
                    <td><?= $dokter->no_ruangan ?></td>
                    <td><?= $dokter->jenis_dokter ?></td>
                    <td><?= $dokter->kode_khusus ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm('<?= $dokter->id_dokter ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDeleteModal('<?= $dokter->id_dokter ?>')">Hapus</button>
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
            <input type="hidden" name="id_dokter" id="idDokterInput" value="">
            
            <div class="form-group">
                <label for="nama">Nama Dokter</label>
                <input type="text" name="nama" id="namaDokter" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatanDokter" required>
            </div>
            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="tel" name="nomor_telepon" id="teleponDokter" required>
            </div>
            <div class="form-group">
                <label for="jadwal">Jadwal</label>
                <input type="text" name="jadwal" id="jadwalDokter" required>
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
                <label for="kode_khusus">Kode Khusus</label>
                <input type="text" name="kode_khusus" id="kodeKhususDokter">
            </div>
            <div class="form-group">
                <label for="kode_operasi">Kode Operasi</label>
                <input type="text" name="kode_operasi" id="kodeOperasiDokter">
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
                <input type="text" name="id_dokter" id="id_dokter_delete" required>
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
            document.getElementById('idDokterInput').value = dataDokter.id_dokter;
            document.getElementById('namaDokter').value = dataDokter.nama;
            document.getElementById('jabatanDokter').value = dataDokter.jabatan;
            document.getElementById('teleponDokter').value = dataDokter.nomor_telepon;
            document.getElementById('jadwalDokter').value = dataDokter.jadwal;
            document.getElementById('noAntrianDokter').value = dataDokter.no_antrian;
            document.getElementById('noRuanganDokter').value = dataDokter.no_ruangan;
            document.getElementById('jenisDokter').value = dataDokter.jenis_dokter;
            document.getElementById('kodeKhususDokter').value = dataDokter.kode_khusus;
            document.getElementById('kodeOperasiDokter').value = dataDokter.kode_operasi;
        } else {
            document.getElementById('action').value = 'insert';
        }
        document.getElementById('dokterModal').style.display = 'block';
    }

    function closeModalDokter() {
        document.getElementById('dokterModal').style.display = 'none';
    }

    function openDeleteModal(id_dokter) {
        document.getElementById('id_dokter_delete').value = id_dokter; // Set the id_dokter to the input
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function toggleEditForm(id_dokter) {
        // Fetch the data for the selected doctor and open the formulir
        // This function should be implemented to fetch data from the server
        openModalDokter({ id_dokter: id_dokter, nama: 'Dummy', jabatan: 'Dummy', nomor_telepon: 'Dummy', jadwal: 'Dummy', no_antrian: 'Dummy', no_ruangan: 'Dummy', jenis_dokter: 'Dummy', kode_khusus: 'Dummy', kode_operasi: 'Dummy' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
