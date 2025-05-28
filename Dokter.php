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
                <th scope="col">Umur</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pasien = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?= $pasien->id ?></td>
                    <td><?= $pasien->nama ?></td>
                    <td><?= $pasien->umur ?></td>
                    <td><?= $pasien->alamat ?></td>
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