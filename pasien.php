<?php
include "koneksi.php"; // Include database connection

// FUNGSI
function insertPasien($koneksi, $nama, $umur, $alamat) {
    $stmt = $koneksi->prepare("INSERT INTO pasien (nama, umur, alamat) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $umur, $alamat);
    return $stmt->execute();
}

function updatePasien($koneksi, $id, $nama, $umur, $alamat) {
    $stmt = $koneksi->prepare("UPDATE pasien SET nama=?, umur=?, alamat=? WHERE id=?");
    $stmt->bind_param("sisi", $nama, $umur, $alamat, $id);
    return $stmt->execute();
}

function deletePasien($koneksi, $id) {
    $stmt = $koneksi->prepare("DELETE FROM pasien WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <style>
        /* CSS Dasar */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .actions button {
            margin-right: 5px;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .actions .edit-btn {
            background-color: #ffc107; /* Kuning */
            color: white;
        }

        .actions .delete-btn {
            background-color: #f44336; /* Merah */
            color: white;
        }

        .add-btn {
            background-color: #4CAF50; /* Hijau */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Styling untuk Modal/Form */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
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

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="tel"],
        .form-group select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .loading-message, .empty-message {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>

<h1>Data Pasien 🏥</h1>

<button class="add-btn" onclick="openModal()">➕ Tambah Data Pasien</button>

<table>
    <thead>
        <tr>
            <th>ID Pasien</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Golongan Darah</th>
            <th>Nomor Antrian</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>ID Wali</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="patientTableBody">
    </tbody>
</table>

<div id="patientModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Data Pasien</h2>
        <form id="patientForm">
            <input type="hidden" id="patientId" name="patientId">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon:</label>
                <input type="tel" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <label for="golDarah">Golongan Darah:</label>
                <select id="golDarah" name="golDarah">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="form-group">
                <label for="noAntrian">Nomor Antrian:</label>
                <input type="text" id="noAntrian" name="noAntrian" required>
            </div>
            <div class="form-group">
                <label for="tglLahir">Tanggal Lahir:</label>
                <input type="date" id="tglLahir" name="tglLahir" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="idWali">ID Wali:</label>
                <input type="text" id="idWali" name="idWali">
            </div>
            <div class="form-group">
                <button type="submit" id="submitButton">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const patientTableBody = document.getElementById('patientTableBody');
    const patientModal = document.getElementById('patientModal');
    const modalTitle = document.getElementById('modalTitle');
    const patientForm = document.getElementById('patientForm');
    const patientIdInput = document.getElementById('patientId');
    const submitButton = document.getElementById('submitButton');

    // GANTI DENGAN URL API BACKEND ANDA YANG TERHUBUNG KE MYSQL
    const API_URL = 'api/pasien.php'; // Contoh: endpoint untuk operasi CRUD pasien

    // --- FUNGSI UNTUK MENAMPILKAN DATA (FETCH DARI SERVER) ---
    async function fetchPatients() {
        patientTableBody.innerHTML = '<tr><td colspan="9" class="loading-message">Memuat data pasien...</td></tr>';
        try {
            const response = await fetch(API_URL); // Method GET secara default
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}, ${await response.text()}`);
            }
            const patients = await response.json(); // Asumsi backend mengembalikan array JSON

            patientTableBody.innerHTML = ''; // Kosongkan tabel sebelum diisi

            if (patients && patients.length > 0) {
                patients.forEach(patient => {
                    const row = patientTableBody.insertRow();
                    row.innerHTML = `
                        <td>${patient.id_pasien || 'N/A'}</td>
                        <td>${patient.nama || 'N/A'}</td>
                        <td>${patient.nomor_telepon || 'N/A'}</td>
                        <td>${patient.golongan_darah || 'N/A'}</td>
                        <td>${patient.nomor_antrian || 'N/A'}</td>
                        <td>${patient.tanggal_lahir || 'N/A'}</td>
                        <td>${patient.alamat || 'N/A'}</td>
                        <td>${patient.id_wali || '-'}</td>
                        <td class="actions">
                            <button class="edit-btn" onclick="editPatient('${patient.id_pasien}', event)">✏ Edit</button>
                            <button class="delete-btn" onclick="deletePatient('${patient.id_pasien}')">🗑 Hapus</button>
                        </td>
                    `;
                });
            } else {
                patientTableBody.innerHTML = '<tr><td colspan="9" class="empty-message">Tidak ada data pasien yang ditemukan.</td></tr>';
            }

        } catch (error) {
            console.error('Error fetching patients:', error);
            patientTableBody.innerHTML = `<tr><td colspan="9" class="empty-message">Gagal memuat data: ${error.message}. Pastikan backend berjalan dan API_URL benar.</td></tr>`;
        }
    }

    // --- FUNGSI UNTUK MODAL ---
    function openModal(patientData = null) {
        patientForm.reset();
        patientIdInput.value = '';

        if (patientData) {
            modalTitle.textContent = '✏ Edit Data Pasien';
            submitButton.textContent = 'Update';
            patientIdInput.value = patientData.id_pasien; // Kunci untuk update

            document.getElementById('nama').value = patientData.nama || '';
            document.getElementById('telepon').value = patientData.nomor_telepon || '';
            document.getElementById('golDarah').value = patientData.golongan_darah || 'A';
            document.getElementById('noAntrian').value = patientData.nomor_antrian || '';
            document.getElementById('tglLahir').value = patientData.tanggal_lahir || '';
            document.getElementById('alamat').value = patientData.alamat || '';
            document.getElementById('idWali').value = patientData.id_wali || '';
        } else {
            modalTitle.textContent = '➕ Tambah Data Pasien';
            submitButton.textContent = 'Simpan';
        }
        patientModal.style.display = 'block';
    }

    function closeModal() {
        patientModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == patientModal) {
            closeModal();
        }
    }

    // --- FUNGSI CRUD (Create, Read, Update, Delete) ---
    patientForm.addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(patientForm);
        const data = Object.fromEntries(formData.entries());
        const currentPatientId = patientIdInput.value; // Ambil ID dari input hidden

        let url = API_URL;
        let method = 'POST';

        if (currentPatientId) { // Jika ada patientId, ini adalah operasi UPDATE
            method = 'PUT'; // Atau tetap POST jika backend Anda menghandle update via POST dengan ID di body
            data.id_pasien_lama = currentPatientId; // Kirim ID lama jika diperlukan untuk query UPDATE WHERE
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: response.statusText }));
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }

            closeModal();
            fetchPatients(); // Muat ulang data setelah berhasil
            alert(currentPatientId ? 'Data pasien berhasil diupdate!' : 'Data pasien berhasil ditambahkan!');

        } catch (error) {
            console.error('Error submitting form:', error);
            alert(`Gagal menyimpan data: ${error.message}`);
        }
    });

    async function editPatient(id, event) {
        event.stopPropagation();
        console.log('Requesting data for patient ID:', id);
        try {
            const response = await fetch(`${API_URL}?id=${id}`); // Contoh: api/pasien.php?id=P001
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: response.statusText }));
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }
            const patientData = await response.json();

            if (patientData) {
                openModal(Array.isArray(patientData) ? patientData[0] : patientData);
            } else {
                alert('Data pasien tidak ditemukan!');
            }

        } catch (error) {
            console.error('Error fetching patient data for edit:', error);
            alert(`Gagal mengambil data pasien untuk diedit: ${error.message}`);
        }
    }

    async function deletePatient(id) {
        console.log('Attempting to delete patient with ID:', id);
        if (confirm(`Apakah Anda yakin ingin menghapus pasien dengan ID ${id}?`)) {
            try {
                const response = await fetch(API_URL, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_pasien: id }), // Kirim ID dalam body
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: response.statusText }));
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                alert(`Pasien dengan ID ${id} berhasil dihapus.`);
                fetchPatients(); // Muat ulang data

            } catch (error) {
                console.error('Error deleting patient:', error);
                alert(`Gagal menghapus data: ${error.message}`);
            }
        }
    }

    // Panggil fungsi untuk memuat data pasien saat halaman dimuat
    document.addEventListener('DOMContentLoaded', fetchPatients);
</script>
</body>
</html>
