<?php 
include("koneksi.php"); 
$query = 'SELECT * FROM pasien;'; 
$result = mysqli_query($koneksi, $query); 
?>

<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>Admin Dashboard</title> 
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
            from { opacity: 0; transform: translateY(-20px); } 
            to { opacity: 1; transform: translateY(0); } 
        } 
        .content { 
            flex: 1; 
            padding: 2rem; 
            color: #fff; 
            text-align: center; 
        } 
        .table-container { 
            background-color: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 1200px; 
            margin: 0 auto; 
        } 
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            background-color: #fff; 
            color: #333; 
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
            background-color: #ffc107; 
            color: white; 
        } 
        .actions .delete-btn { 
            background-color: #f44336; 
            color: white; 
        } 
        .add-btn { 
            background-color: #4CAF50; 
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
        .close-btn:hover, .close-btn:focus { 
            color: black; 
            text-decoration: none; 
            cursor: pointer; 
        } 
        .form-group { 
            margin-bottom: 15px; 
        } 
        .form-group label { 
            color: black;
            display: block; 
            margin-bottom: 5px; 
        } 
        .form-group input[type="text"], 
        .form-group input[type="date"], 
        .form-group input[type="tel"], 
        .form-group select { 
            color: black; 
            width: calc(100% - 22px); 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        } 
        .form-group button { 
            background-color: rgb(87, 84, 255); 
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

    <div class="main-content"> 
        <h1>Data Pasien 🏥</h1> 
        <button class="add-btn" onclick="openModal()">➕ Tambah Data Pasien</button> 
        <div class="table-container"> 
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
        </div> 

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
    </div> 

    <script> 
        const patientTableBody = document.getElementById('patientTableBody'); 
        const patientModal = document.getElementById('patientModal'); 
        const modalTitle = document.getElementById('modalTitle'); 
        const patientForm = document.getElementById('patientForm'); 
        const patientIdInput = document.getElementById('patientId'); 
        const submitButton = document.getElementById('submitButton'); 
        const API_URL = 'api/pasien.php'; 

        async function fetchPatients() { 
            patientTableBody.innerHTML = '<tr><td colspan="9" class="loading-message">Memuat data pasien...</td></tr>'; 
            try { 
                const response = await fetch(API_URL); 
                if (!response.ok) { 
                    throw new Error(`HTTP error! status: ${response.status}, ${await response.text()}`); 
                } 
                const patients = await response.json(); 
                patientTableBody.innerHTML = ''; 
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

        function openModal(patientData = null) { 
            patientForm.reset(); 
            patientIdInput.value = ''; 
            if (patientData) { 
                modalTitle.textContent = '✏ Edit Data Pasien'; 
                submitButton.textContent = 'Update'; 
                patientIdInput.value = patientData.id_pasien; 
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

        patientForm.addEventListener('submit', async function(event) { 
            event.preventDefault(); 
            const formData = new FormData(patientForm); 
            const data = Object.fromEntries(formData.entries()); 
            const currentPatientId = patientIdInput.value; 
            let url = API_URL; 
            let method = 'POST'; 
            if (currentPatientId) { 
                method = 'PUT'; 
                data.id_pasien_lama = currentPatientId; 
            } 
            try { 
                const response = await fetch(url, { 
                    method: method, 
                    headers: { 'Content-Type': 'application/json', }, 
                    body: JSON.stringify(data), 
                }); 
                if (!response.ok) { 
                    const errorData = await response.json().catch(() => ({ message: response.statusText })); 
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`); 
                } 
                closeModal(); 
                fetchPatients(); 
                alert(currentPatientId ? 'Data pasien berhasil diupdate!' : 'Data pasien berhasil ditambahkan!'); 
            } catch (error) { 
                console.error('Error submitting form:', error); 
                alert(`Gagal menyimpan data: ${error.message}`); 
            } 
        }); 

        async function editPatient(id, event) { 
            event.stopPropagation(); 
            try { 
                const response = await fetch(`${API_URL}?id=${id}`); 
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
            if (confirm(`Apakah Anda yakin ingin menghapus pasien dengan ID ${id}?`)) { 
                try { 
                    const response = await fetch(API_URL, { 
                        method: 'DELETE', 
                        headers: { 'Content-Type': 'application/json', }, 
                        body: JSON.stringify({ id_pasien: id }), 
                    }); 
                    if (!response.ok) { 
                        const errorData = await response.json().catch(() => ({ message: response.statusText })); 
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`); 
                    } 
                    alert(`Pasien dengan ID ${id} berhasil dihapus.`); 
                    fetchPatients(); 
                } catch (error) { 
                    console.error('Error deleting patient:', error); 
                    alert(`Gagal menghapus data: ${error.message}`); 
                } 
            } 
        } 
        document.addEventListener('DOMContentLoaded', fetchPatients);
    </script>
</body>
</html>
