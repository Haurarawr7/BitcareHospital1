<?php 
include("koneksi.php"); 

$query = 'SELECT * FROM pasien;'; 
$result = mysqli_query($koneksi, $query); 

include 'layouts/header.php'; 
?>

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
                <th scope="col">Tanggal Lahir</th>
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
                    <td><?= $pasien-> no_antrian?></td>
                    
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
    $query = "INSERT INTO pasien (nama, umur, alamat) VALUES ('$nama', '$umur', '$alamat')";
    return mysqli_query($koneksi, $query);
}

function updatePasien($koneksi, $id, $nama, $umur, $alamat) {
    $query = "UPDATE pasien SET nama='$nama', umur='$umur', alamat='$alamat' WHERE id=$id";
    return mysqli_query($koneksi, $query);
}

function deletePasien($koneksi, $id) {
    $query = "DELETE FROM pasien WHERE id=$id";
    return mysqli_query($koneksi, $query);
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
