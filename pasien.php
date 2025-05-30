<?php 
include("koneksi.php"); 

$query = 'SELECT * FROM pasien;'; 
$result = mysqli_query($koneksi, $query); 

include 'layouts/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      min-height: 100vh;
      background: linear-gradient(135deg, #333446 0%, #2575fc 100%);
      color: #fff;
    }

    .sidebar {
      width: 250px;
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

    .menu-item {
      margin: 0.5rem 0;
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
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .content {
      flex: 1;
      padding: 2rem;
      color: #fff;
      text-align: center;
    }
</style>

<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <div class="menu-item">Tindakan medis</div>
    <div class="menu-item">Rekam medis</div>
    <div class="menu-item">Obat</div>
    <div class="menu-item">Transaksi</div>
    <div class="menu-item">Ruangan</div>
    <div class="menu-item">Staff</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item">Perawat</div>
    <div class="menu-item">Dokter</div>
  </div>

  <section class="p-4 ml-5 mr-5 w-75">
    <div class="d-flex flex-row justify-content-between">
        <h2>Data Pasien</h2>
        <a href="tambah.php" class="btn btn-primary p-2">+Tambah</a>
    </div>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Golongan Darah</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Antrian</th>
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
                        <a href="edit.php?id=<?= $pasien->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="function.php?action=delete&id=<?= $pasien->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
  </section>

<?php include 'layouts/footer.php'; ?>


<?php
// FUNGSI
function insertPasien($koneksi, $nama, $umur, $alamat) {
    $query = "INSERT INTO pasien (nama, umur, alamat) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sis', $nama, $umur, $alamat);
    return mysqli_stmt_execute($stmt);
}

function updatePasien($koneksi, $id, $nama, $umur, $alamat) {
    $query = "UPDATE pasien SET nama=?, umur=?, alamat=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sisi', $nama, $umur, $alamat, $id);
    return mysqli_stmt_execute($stmt);
}

function deletePasien($koneksi, $id) {
    $query = "DELETE FROM pasien WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

// INSERT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'insert') {
    $nama = $_POST["nama"];
    $umur = $_POST["umur"];
    $alamat = $_POST["alamat"];

    if (insertPasien($koneksi, $nama, $umur, $alamat)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal disimpan";
    }
}

// EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'edit') {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $umur = $_POST["umur"];
    $alamat = $_POST["alamat"];

    if (updatePasien($koneksi, $id, $nama, $umur, $alamat)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal diubah";
    }
}

// DELETE
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'delete') {
    $id = $_GET["id"];

    if (deletePasien($koneksi, $id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal dihapus";
    }
}
?>
