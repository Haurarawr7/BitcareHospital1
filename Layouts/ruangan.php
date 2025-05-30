<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruangan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f0f2f5;
            color: #333;
        }

        h1 {
            color: #1877f2; /* Biru Facebook */
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Untuk border-radius pada tabel */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #1877f2;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        tr:hover {
            background-color: #e9ebee;
        }

        .actions button {
            margin-right: 6px;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        .actions button:active {
            transform: scale(0.95);
        }

        .actions .edit-btn {
            background-color: #ffc107; /* Kuning */
            color: #212529;
        }
        .actions .edit-btn:hover {
            background-color: #e0a800;
        }

        .actions .delete-btn {
            background-color: #dc3545; /* Merah */
            color: white;
        }
        .actions .delete-btn:hover {
            background-color: #c82333;
        }

        .add-btn {
            background-color: #42b72a; /* Hijau Facebook */
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.2s ease;
        }
        .add-btn:hover {
            background-color: #36a420;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
            padding-top: 50px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 25px 30px;
            border: none;
            width: 90%;
            max-width: 550px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 30px;
            font-weight: bold;
            line-height: 0.7;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4b4f56;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccd0d5;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 15px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #1877f2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
        }

        .form-group button[type="submit"] {
            background-color: #1877f2;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.2s ease;
        }
        .form-group button[type="submit"]:hover {
            background-color: #166fe5;
        }
        .loading-message, .empty-message {
            text-align: center;
            font-style: italic;
            color: #606770;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16" style="vertical-align: -4px; margin-right: 8px;">
        <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-1 0V1H4.5A1.5 1.5 0 0 0 3 2.5V15H1.5zM11 2.5v11h1.5V2.5A1.5 1.5 0 0 0 11 2.5zM4.5 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5V15H4.5V2z"/>
        <path d="M9 15V8h1V7H7v1h1v7h1z"/>
      </svg>Data Ruangan
    </h1>

    <button class="add-btn" onclick="openModalRuangan()">➕ Tambah Data Ruangan</button>

    <table>
        <thead>
            <tr>
                <th>Nomor Ruangan</th>
                <th>Nomor Lantai</th>
                <th>Jenis Ruangan</th>
                <th>Kapasitas</th>
                <th>Alat di Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="ruanganTableBody">
            </tbody>
    </table>

    <div id="ruanganModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModalRuangan()">&times;</span>
            <h2 id="modalTitleRuangan" style="color: #1877f2; margin-bottom: 20px;">Tambah Data Ruangan</h2>
            <form id="ruanganForm">
                <input type="hidden" id="ruanganId" name="ruanganId"> <div class="form-group">
                    <label for="nomorRuangan">Nomor Ruangan:</label>
                    <input type="text" id="nomorRuangan" name="nomor_ruangan" required>
                </div>
                <div class="form-group">
                    <label for="nomorLantai">Nomor Lantai:</label>
                    <input type="number" id="nomorLantai" name="nomor_lantai" required>
                </div>
                <div class="form-group">
                    <label for="jenisRuangan">Jenis Ruangan:</label>
                    <input type="text" id="jenisRuangan" name="jenis_ruangan" required>
                </div>
                <div class="form-group">
                    <label for="kapasitas">Kapasitas (orang):</label>
                    <input type="number" id="kapasitas" name="kapasitas" min="1" required>
                </div>
                <div class="form-group">
                    <label for="alatRuangan">Alat yang Terdapat di Ruangan:</label>
                    <textarea id="alatRuangan" name="alat_ruangan" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" id="submitButtonRuangan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const ruanganTableBody = document.getElementById('ruanganTableBody');
        const ruanganModal = document.getElementById('ruanganModal');
        const modalTitleRuangan = document.getElementById('modalTitleRuangan');
        const ruanganForm = document.getElementById('ruanganForm');
        const ruanganIdInput = document.getElementById('ruanganId'); // Input hidden untuk ID
        const submitButtonRuangan = document.getElementById('submitButtonRuangan');

        // GANTI DENGAN URL API BACKEND ANDA YANG TERHUBUNG KE MYSQL
        const API_URL_RUANGAN = 'api/ruangan.php'; // Contoh endpoint untuk operasi CRUD ruangan

        // --- FUNGSI UNTUK MENAMPILKAN DATA (FETCH DARI SERVER) ---
        async function fetchRuangan() {
            ruanganTableBody.innerHTML = '<tr><td colspan="6" class="loading-message">Memuat data ruangan...</td></tr>';
            try {
                const response = await fetch(API_URL_RUANGAN); // Method GET secara default
                if (!response.ok) {
                    throw new Error(HTTP error! status: ${response.status}, ${await response.text()});
                }
                const daftarRuangan = await response.json(); // Asumsi backend mengembalikan array JSON

                ruanganTableBody.innerHTML = ''; // Kosongkan tabel sebelum diisi

                if (daftarRuangan && daftarRuangan.length > 0) {
                    daftarRuangan.forEach(ruangan => {
                        const row = ruanganTableBody.insertRow();
                        // Sesuaikan nama properti (ruangan.nomor_ruangan, dll.)
                        // dengan nama kolom yang dikembalikan oleh API backend Anda.
                        row.innerHTML = `
                            <td>${ruangan.nomor_ruangan || 'N/A'}</td>
                            <td>${ruangan.nomor_lantai || 'N/A'}</td>
                            <td>${ruangan.jenis_ruangan || 'N/A'}</td>
                            <td>${ruangan.kapasitas || 'N/A'}</td>
                            <td>${(ruangan.alat_ruangan || '-').replace(/\n/g, '<br>')}</td>
                            <td class="actions">
                                <button class="edit-btn" onclick="editRuangan('${ruangan.id_ruangan || ruangan.nomor_ruangan}', event)">✏ Edit</button>
                                <button class="delete-btn" onclick="deleteRuangan('${ruangan.id_ruangan || ruangan.nomor_ruangan}')">🗑 Hapus</button>
                            </td>
                        `;
                        // Menggunakan ruangan.id_ruangan sebagai primary key jika ada,
                        // jika tidak, fallback ke ruangan.nomor_ruangan (pastikan unik).
                    });
                } else {
                    ruanganTableBody.innerHTML = '<tr><td colspan="6" class="empty-message">Tidak ada data ruangan yang ditemukan.</td></tr>';
                }

            } catch (error) {
                console.error('Error fetching ruangan:', error);
                ruanganTableBody.innerHTML = <tr><td colspan="6" class="empty-message">Gagal memuat data: ${error.message}. Pastikan backend berjalan.</td></tr>;
            }
        }

        // --- FUNGSI UNTUK MODAL ---
        function openModalRuangan(dataRuangan = null) {
            ruanganForm.reset();
            ruanganIdInput.value = ''; // Kosongkan ID

            if (dataRuangan) {
                modalTitleRuangan.textContent = '✏ Edit Data Ruangan';
                submitButtonRuangan.textContent = 'Update';
                // Asumsi 'id_ruangan' adalah primary key dari backend. Jika tidak, sesuaikan.
                ruanganIdInput.value = dataRuangan.id_ruangan || dataRuangan.nomor_ruangan;

                document.getElementById('nomorRuangan').value = dataRuangan.nomor_ruangan || '';
                document.getElementById('nomorLantai').value = dataRuangan.nomor_lantai || '';
                document.getElementById('jenisRuangan').value = dataRuangan.jenis_ruangan || '';
                document.getElementById('kapasitas').value = dataRuangan.kapasitas || '';
                document.getElementById('alatRuangan').value = dataRuangan.alat_ruangan || '';
            } else {
                modalTitleRuangan.textContent = '➕ Tambah Data Ruangan';
                submitButtonRuangan.textContent = 'Simpan';
            }
            ruanganModal.style.display = 'block';
        }

        function closeModalRuangan() {
            ruanganModal.style.display = 'none';
        }

        // Tutup modal jika klik di luar area modal
        window.onclick = function(event) {
            if (event.target == ruanganModal) {
                closeModalRuangan();
            }
        }

        // --- FUNGSI CRUD (Create, Read, Update, Delete) ---

        ruanganForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(ruanganForm);
            const data = Object.fromEntries(formData.entries());
            const currentRuanganId = ruanganIdInput.value; // Ambil ID dari input hidden

            let url = API_URL_RUANGAN;
            let method = 'POST';

            if (currentRuanganId) { // Jika ada ID, berarti ini adalah operasi UPDATE
                // Backend Anda mungkin mengharapkan ID di URL atau sebagai bagian dari body JSON.
                // url = ${API_URL_RUANGAN}?id=${currentRuanganId}; // Contoh jika ID di URL
                method = 'PUT'; // Atau tetap POST jika backend Anda menghandle update dengan POST dan ID di body
                data.id_ruangan_lama = currentRuanganId; // Kirim ID lama jika backend memerlukannya untuk query UPDATE WHERE
                                                 // atau backend Anda mengambil ID dari 'ruanganId' (nama input)
                                                 // yang sudah ada di 'data' jika nama input 'ruanganId'
                                                 // adalah nama kolom primary key Anda.
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
                    throw new Error(errorData.message || HTTP error! status: ${response.status});
                }

                closeModalRuangan();
                fetchRuangan(); // Muat ulang data setelah berhasil
                alert(currentRuanganId ? 'Data ruangan berhasil diupdate!' : 'Data ruangan berhasil ditambahkan!');

            } catch (error) {
                console.error('Error submitting form:', error);
                alert(Gagal menyimpan data: ${error.message});
            }
        });

        async function editRuangan(id, event) {
            event.stopPropagation(); // Mencegah event lain
            try {
                // Panggil API backend Anda untuk mendapatkan data ruangan berdasarkan ID
                // Sesuaikan URL jika endpoint Anda berbeda untuk mengambil satu data
                const response = await fetch(${API_URL_RUANGAN}?id=${id}); // Contoh: api/ruangan.php?id=R001
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: response.statusText }));
                    throw new Error(errorData.message || HTTP error! status: ${response.status});
                }
                const dataRuangan = await response.json();

                if (dataRuangan) {
                    openModalRuangan(Array.isArray(dataRuangan) ? dataRuangan[0] : dataRuangan);
                } else {
                    alert('Data ruangan tidak ditemukan!');
                }

            } catch (error) {
                console.error('Error fetching ruangan data for edit:', error);
                alert(Gagal mengambil data ruangan untuk diedit: ${error.message});
            }
        }

        async function deleteRuangan(id) {
            if (confirm(Apakah Anda yakin ingin menghapus ruangan dengan ID/Nomor ${id}?)) {
                try {
                    const response = await fetch(API_URL_RUANGAN, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id_ruangan: id }), // Kirim ID dalam body
                                                                  // atau sesuaikan jika backend mengharapkannya di URL
                    });

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ message: response.statusText }));
                        throw new Error(errorData.message || HTTP error! status: ${response.status});
                    }

                    alert(Ruangan dengan ID/Nomor ${id} berhasil dihapus.);
                    fetchRuangan(); // Muat ulang data

                } catch (error) {
                    console.error('Error deleting ruangan:', error);
                    alert(Gagal menghapus data: ${error.message});
                }
            }
        }

        // Panggil fungsi untuk memuat data ruangan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchRuangan);
    </script>

</body>
</html>
