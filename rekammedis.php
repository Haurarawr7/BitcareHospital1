<?php
include "koneksi.php"; // Include database connection

// FUNGSI
function insertRekamMedis($koneksi, $tanggal, $id_pasien, $riwayat, $id_dokter) {
    $stmt = $koneksi->prepare("INSERT INTO rekam_medis (tanggal_rekam_medis, id_pasien, riwayat, id_dokter) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $tanggal, $id_pasien, $riwayat, $id_dokter);
    return $stmt->execute();
}

function updateRekamMedis($koneksi, $no_rekam_medis, $tanggal, $id_pasien, $riwayat, $id_dokter) {
    $stmt = $koneksi->prepare("UPDATE rekam_medis SET tanggal_rekam_medis=?, id_pasien=?, riwayat=?, id_dokter=? WHERE no_rekam_medis=?");
    $stmt->bind_param("sssss", $tanggal, $id_pasien, $riwayat, $id_dokter, $no_rekam_medis);
    return $stmt->execute();
}

function deleteRekamMedis($koneksi, $no_rekam_medis) {
    $stmt = $koneksi->prepare("DELETE FROM rekam_medis WHERE no_rekam_medis=?");
    $stmt->bind_param("s", $no_rekam_medis);
    return $stmt->execute();
}

// Handle incoming requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'insert') {
        $tanggal = $_POST["tanggal_rekam_medis"];
        $id_pasien = $_POST["id_pasien"];
        $riwayat = $_POST["riwayat"];
        $id_dokter = $_POST["id_dokter"];
        insertRekamMedis($koneksi, $tanggal, $id_pasien, $riwayat, $id_dokter);
    } elseif ($action == 'edit') {
        $no_rekam_medis = $_POST["no_rekam_medis"];
        $tanggal = $_POST["tanggal_rekam_medis"];
        $id_pasien = $_POST["id_pasien"];
        $riwayat = $_POST["riwayat"];
        $id_dokter = $_POST["id_dokter"];
        updateRekamMedis($koneksi, $no_rekam_medis, $tanggal, $id_pasien, $riwayat, $id_dokter);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $no_rekam_medis = $_GET["id"];
        deleteRekamMedis($koneksi, $no_rekam_medis);
    }
}

// Fetch all records for GET requests without action
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $koneksi->query("SELECT * FROM rekam_medis");
    $rekamMedis = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rekamMedis);
    exit; // Ensure no further output is sent
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
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
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
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

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 1.5rem;
      width: 100%;
      max-width: 900px;
    }

    .card {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      cursor: pointer;
      transition: transform 0.3s ease, background 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.2rem;
      color: #fff;
      user-select: none;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      transition: transform 0.3s ease;
      transform: scale(0);
      z-index: 0;
    }

    .card:hover::before {
      transform: scale(1);
    }

    .card:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.4);
    }

    @media (max-width: 400px) {
      .card {
        padding: 1.5rem;
        font-size: 1rem;
      }
    }

    /* Styles for the medical records section */
    .records-section {
      width: 100%;
      max-width: 900px;
      margin-top: 2rem;
      background: rgba(255, 255, 255, 0.1);
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    .records-section h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <div class="menu-item">Tindakan medis</div>
    <div class="menu-item">Rekam medis</div>
    <div class="menu-item">Obat</div>
    <div class="menu-item">Transaksi</div>
    <div class="menu-item">Ruangan</div>
    <div class="menu-item">Staff</div>
    <div class="menu-item">Pasien</div>
    <div class="menu-item">Perawat</div>
    <div class="menu-item">Dokter</div>
  </div>
  <div class="main-content">
    <header>
      <h1>Admin Dashboard</h1>
    </header>
    <main class="grid" role="list" aria-label="Admin Sections">
      <div class="card" role="listitem" tabindex="0">Tindakan medis</div>
      <div class="card" role="listitem" tabindex="0">Rekam medis</div>
      <div class="card" role="listitem" tabindex="0">Obat</div>
      <div class="card" role="listitem" tabindex="0">Transaksi</div>
      <div class="card" role="listitem" tabindex="0">Ruangan</div>
      <div class="card" role="listitem" tabindex="0">Staff</div>
      <div class="card" role="listitem" tabindex="0">Pasien</div>
      <div class="card" role="listitem" tabindex="0">Perawat</div>
      <div class="card" role="listitem" tabindex="0">Dokter</div>
    </main>

    <!-- Medical Records Section -->
    <div class="records-section">
      <h2>Data Rekam Medis</h2>
      <button class="add-btn" onclick="openModal()">➕ Tambah Rekam Medis</button>
      <table>
          <thead>
              <tr>
                  <th>No. Rekam Medis</th>
                  <th>Tanggal</th>
                  <th>ID Pasien</th>
                  <th>Riwayat Penyakit/Keluhan</th>
                  <th>ID Dokter</th>
                  <th>Aksi</th>
              </tr>
          </thead>
          <tbody id="rekamMedisTableBody"></tbody>
      </table>

      <div id="rekamMedisModal" class="modal">
          <div class="modal-content">
              <span class="close-btn" onclick="closeModal()">&times;</span>
              <h2 id="modalTitle">Tambah Data Rekam Medis</h2>
              <form id="rekamMedisForm">
                  <input type="hidden" id="noRekamMedis" name="no_rekam_medis">
                  <div class="form-group">
                      <label for="tanggalRekamMedis">Tanggal Rekam Medis:</label>
                      <input type="date" id="tanggalRekamMedis" name="tanggal_rekam_medis" required>
                  </div>
                  <div class="form-group">
                      <label for="idPasienRm">ID Pasien:</label>
                      <input type="text" id="idPasienRm" name="id_pasien" required>
                  </div>
                  <div class="form-group">
                      <label for="riwayatRekamMedis">Riwayat Penyakit/Keluhan:</label>
                      <textarea id="riwayatRekamMedis" name="riwayat" rows="4" required></textarea>
                  </div>
                  <div class="form-group">
                      <label for="idDokterRm">ID Dokter:</label>
                      <input type="text" id="idDokterRm" name="id_dokter" required>
                  </div>
                  <div class="form-group">
                      <button type="submit">Simpan</button>
                  </div>
              </form>
          </div>
      </div>
    </div>
  </div>

  <script>
      const rekamMedisTableBody = document.getElementById('rekamMedisTableBody');
      const rekamMedisModal = document.getElementById('rekamMedisModal');
      const rekamMedisForm = document.getElementById('rekamMedisForm');

      const API_URL_REKAM_MEDIS = 'api/rekam_medis.php';
      let currentEditId = null;

      async function fetchRekamMedis() {
          rekamMedisTableBody.innerHTML = '<tr><td colspan="6">Memuat data...</td></tr>';
          try {
              const response = await fetch(API_URL_REKAM_MEDIS);
              const data = await response.json();
              rekamMedisTableBody.innerHTML = data.map(rm => `
                  <tr>
                      <td>${rm.no_rekam_medis}</td>
                      <td>${new Date(rm.tanggal_rekam_medis).toLocaleDateString('id-ID')}</td>
                      <td>${rm.id_pasien}</td>
                      <td>${rm.riwayat}</td>
                      <td>${rm.id_dokter}</td>
                      <td class="actions">
                          <button onclick="openEditModal('${rm.no_rekam_medis}')">Edit</button>
                          <button onclick="deleteRekamMedis('${rm.no_rekam_medis}')">Hapus</button>
                      </td>
                  </tr>
              `).join('') || '<tr><td colspan="6">Belum ada data.</td></tr>';
          } catch (error) {
              console.error('Error fetching data:', error);
              rekamMedisTableBody.innerHTML = '<tr><td colspan="6">Gagal memuat data.</td></tr>';
          }
      }

      function openModal() {
          currentEditId = null; // Reset edit ID
          rekamMedisForm.reset(); // Reset form fields
          document.getElementById('modalTitle').innerText = 'Tambah Data Rekam Medis';
          rekamMedisModal.style.display = 'flex';
      }

      function closeModal() {
          rekamMedisModal.style.display = 'none';
      }

      function openEditModal(noRm) {
          currentEditId = noRm;
          const row = [...rekamMedisTableBody.rows].find(r => r.cells[0].innerText === noRm);
          const data = {
              no_rekam_medis: row.cells[0].innerText,
              tanggal_rekam_medis: new Date(row.cells[1].innerText).toISOString().split('T')[0],
              id_pasien: row.cells[2].innerText,
              riwayat: row.cells[3].innerText,
              id_dokter: row.cells[4].innerText,
          };
          rekamMedisForm.no_rekam_medis.value = data.no_rekam_medis;
          rekamMedisForm.tanggal_rekam_medis.value = data.tanggal_rekam_medis;
          rekamMedisForm.id_pasien.value = data.id_pasien;
          rekamMedisForm.riwayat.value = data.riwayat;
          rekamMedisForm.id_dokter.value = data.id_dokter;
          document.getElementById('modalTitle').innerText = 'Edit Data Rekam Medis';
          rekamMedisModal.style.display = 'flex';
      }

      rekamMedisForm.addEventListener('submit', async (event) => {
          event.preventDefault();
          const formData = new FormData(rekamMedisForm);
          const data = Object.fromEntries(formData.entries());

          try {
              const method = currentEditId ? 'POST' : 'POST'; // Use POST for both insert and update
              const action = currentEditId ? 'edit' : 'insert'; // Determine action
              const response = await fetch(API_URL_REKAM_MEDIS, {
                  method: method,
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ action, ...data, no_rekam_medis: currentEditId }),
              });
              if (response.ok) {
                  closeModal();
                  fetchRekamMedis();
              } else {
                  alert('Gagal menyimpan data.');
              }
          } catch (error) {
              console.error('Error saving data:', error);
              alert('Gagal menyimpan data.');
          }
      });

      async function deleteRekamMedis(noRm) {
          if (confirm(`Hapus rekam medis dengan Nomor ${noRm}?`)) {
              try {
                  const response = await fetch(API_URL_REKAM_MEDIS + '?action=delete&id=' + noRm, {
                      method: 'GET',
                  });
                  if (response.ok) {
                      fetchRekamMedis();
                  } else {
                      alert('Gagal menghapus data.');
                  }
              } catch (error) {
                  console.error('Error deleting data:', error);
                  alert('Gagal menghapus data.');
              }
          }
      }

      document.addEventListener('DOMContentLoaded', fetchRekamMedis);
  </script>

</body>
</html>
