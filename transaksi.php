DATA TRANSAKSI

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 20px;
            background-color: #eef1f4; /* Warna latar belakang lebih lembut */
            color: #333;
        }

        h1 {
            color: #2c3e50; /* Biru tua */
            text-align: center;
            margin-bottom: 30px;
            font-weight: 300;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border-bottom: 1px solid #ecf0f1; /* Garis antar baris lebih halus */
            padding: 14px 18px; /* Padding lebih lega */
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #3498db; /* Biru cerah untuk header */
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e8f4fd; /* Highlight biru muda saat hover */
        }

        .actions button {
            margin-right: 6px;
            padding: 9px 13px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s ease;
        }
        .actions button:active {
            transform: translateY(1px);
        }

        .actions .edit-btn {
            background-color: #f39c12; /* Oranye */
            color: white;
        }
        .actions .edit-btn:hover {
            background-color: #e67e22;
        }

        .actions .delete-btn {
            background-color: #e74c3c; /* Merah */
            color: white;
        }
        .actions .delete-btn:hover {
            background-color: #c0392b;
        }

        .add-btn {
            background-color: #2ecc71; /* Hijau emerlad */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 25px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.2s ease;
        }
        .add-btn:hover {
            background-color: #27ae60;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1050; /* Di atas elemen lain */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.55); /* Overlay lebih gelap */
            padding-top: 40px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto 10% auto; /* Margin bawah lebih besar */
            padding: 30px 35px;
            border: none;
            width: 90%;
            max-width: 600px; /* Modal sedikit lebih lebar */
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .close-btn {
            color: #95a5a6; /* Abu-abu */
            float: right;
            font-size: 32px;
            font-weight: bold;
            line-height: 0.7;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #7f8c8d; /* Abu-abu lebih gelap */
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            padding: 12px 15px; /* Padding input lebih nyaman */
            border: 1px solid #bdc3c7; /* Border abu-abu lembut */
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db; /* Fokus biru */
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }

        .form-group button[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 14px 22px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s ease;
        }
        .form-group button[type="submit"]:hover {
            background-color: #2980b9;
        }
        .loading-message, .empty-message {
            text-align: center;
            font-style: italic;
            color: #7f8c8d;
            padding: 25px;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <h1><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16" style="vertical-align: -5px; margin-right: 10px;">
        <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
        <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1.5 2h13a.5.5 0 0 0 .447-.724l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293l-.646-.647a.5.5 0 0 0-.708 0L7 1.293l-.646-.647a.5.5 0 0 0-.708 0L5 1.293l-.646-.647a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274A.5.5 0 0 0 14.5 3h-13a.5.5 0 0 0-.405-.215l.135-.274zM0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v11A1.5 1.5 0 0 1 14.5 16h-13A1.5 1.5 0 0 1 0 14.5v-11zm1.5.5a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-.5-.5h-13z"/>
      </svg>Data Transaksi</h1>

    <button class="add-btn" onclick="openModalTransaksi()">➕ Tambah Data Transaksi</button>

    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>No Ruang</th>
                <th>ID Pasien</th>
                <th>Jenis Transaksi</th>
                <th>Total Harga (Rp)</th>
                <th>Asuransi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="transaksiTableBody">
            </tbody>
    </table>

    <div id="transaksiModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModalTransaksi()">&times;</span>
            <h2 id="modalTitleTransaksi" style="color: #2c3e50; margin-bottom: 25px; font-weight: 400;">Tambah Data Transaksi</h2>
            <form id="transaksiForm">
                <div class="form-group">
                    <label for="kodeTransaksi">Kode Transaksi:</label>
                    <input type="text" id="kodeTransaksi" name="kode_transaksi" required>
                </div>

                <div class="form-group">
                    <label for="tanggalTransaksi">Tanggal Transaksi:</label>
                    <input type="date" id="tanggalTransaksi" name="tanggal_transaksi" required>
                </div>

                <div class="form-group">
                    <label for="noRuang">Nomor Ruang (FK):</label>
                    <input type="text" id="noRuang" name="no_ruang" required>
                    <small style="font-size: 12px; color: #7f8c8d;">Idealnya dropdown dari data Ruangan.</small>
                </div>

                <div class="form-group">
                    <label for="idPasien">ID Pasien (FK):</label>
                    <input type="text" id="idPasien" name="id_pasien" required>
                    <small style="font-size: 12px; color: #7f8c8d;">Idealnya dropdown dari data Pasien.</small>
                </div>

                <div class="form-group">
                    <label for="jenisTransaksi">Jenis Transaksi:</label>
                    <input type="text" id="jenisTransaksi" name="jenis_transaksi" required>
                </div>

                <div class="form-group">
                    <label for="totalHarga">Total Harga (Rp):</label>
                    <input type="number" id="totalHarga" name="total_harga" min="0" step="1000" required placeholder="Contoh: 500000">
                </div>

                <div class="form-group">
                    <label for="asuransi">Asuransi:</label>
                    <input type="text" id="asuransi" name="asuransi" placeholder="Nama Asuransi / Tidak Ada">
                </div>

                <input type="hidden" id="originalKodeTransaksi" name="originalKodeTransaksi"> <div class="form-group">
                    <button type="submit" id="submitButtonTransaksi">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const transaksiTableBody = document.getElementById('transaksiTableBody');
        const transaksiModal = document.getElementById('transaksiModal');
        const modalTitleTransaksi = document.getElementById('modalTitleTransaksi');
        const transaksiForm = document.getElementById('transaksiForm');
        const kodeTransaksiInput = document.getElementById('kodeTransaksi');
        const originalKodeTransaksiInput = document.getElementById('originalKodeTransaksi');
        const submitButtonTransaksi = document.getElementById('submitButtonTransaksi');

        // GANTI DENGAN URL API BACKEND ANDA
        const API_URL_TRANSAKSI = 'api/transaksi.php';

        function formatRupiah(angka) {
            if (angka === null || angka === undefined || isNaN(parseFloat(angka))) {
                return 'N/A';
            }
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        async function fetchTransaksi() {
            transaksiTableBody.innerHTML = '<tr><td colspan="8" class="loading-message">Memuat data transaksi... ⏳</td></tr>';
            try {
                const response = await fetch(API_URL_TRANSAKSI);
                if (!response.ok) {
                    throw new Error(HTTP error! status: ${response.status}, ${await response.text()});
                }
                const daftarTransaksi = await response.json();

                transaksiTableBody.innerHTML = '';

                if (daftarTransaksi && daftarTransaksi.length > 0) {
                    daftarTransaksi.forEach(trx => {
                        const row = transaksiTableBody.insertRow();
                        // Sesuaikan nama properti (trx.kode_transaksi, dll.) dengan respons API Anda.
                        row.innerHTML = `
                            <td>${trx.kode_transaksi || 'N/A'}</td>
                            <td>${trx.tanggal_transaksi ? new Date(trx.tanggal_transaksi).toLocaleDateString('id-ID') : 'N/A'}</td>
                            <td>${trx.no_ruang || 'N/A'}</td>
                            <td>${trx.id_pasien || 'N/A'}</td>
                            <td>${trx.jenis_transaksi || 'N/A'}</td>
                            <td>${formatRupiah(trx.total_harga)}</td>
                            <td>${trx.asuransi || '-'}</td>
                            <td class="actions">
                                <button class="edit-btn" onclick="editTransaksi('${trx.kode_transaksi}', event)">✏ Edit</button>
                                <button class="delete-btn" onclick="deleteTransaksi('${trx.kode_transaksi}')">🗑 Hapus</button>
                            </td>
                        `;
                    });
                } else {
                    transaksiTableBody.innerHTML = '<tr><td colspan="8" class="empty-message">Belum ada data transaksi. 🤷</td></tr>';
                }

            } catch (error) {
                console.error('Error fetching transaksi:', error);
                transaksiTableBody.innerHTML = <tr><td colspan="8" class="empty-message">Gagal memuat data: ${error.message}. Pastikan backend aktif. 😥</td></tr>;
            }
        }

        function openModalTransaksi(dataTrx = null) {
            transaksiForm.reset();
            kodeTransaksiInput.readOnly = false; // Default bisa diedit untuk Kode Transaksi
            originalKodeTransaksiInput.value = '';


            if (dataTrx) {
                modalTitleTransaksi.textContent = '✏ Edit Data Transaksi';
                submitButtonTransaksi.textContent = 'Update';

                kodeTransaksiInput.value = dataTrx.kode_transaksi || '';
                // Jika Kode Transaksi (PK) tidak boleh diubah setelah dibuat, uncomment baris berikut:
                // kodeTransaksiInput.readOnly = true;
                originalKodeTransaksiInput.value = dataTrx.kode_transaksi || ''; // Simpan PK asli untuk update


                document.getElementById('tanggalTransaksi').value = dataTrx.tanggal_transaksi ? dataTrx.tanggal_transaksi.split('T')[0] : '';
                document.getElementById('noRuang').value = dataTrx.no_ruang || '';
                document.getElementById('idPasien').value = dataTrx.id_pasien || '';
                document.getElementById('jenisTransaksi').value = dataTrx.jenis_transaksi || '';
                document.getElementById('totalHarga').value = dataTrx.total_harga || '';
                document.getElementById('asuransi').value = dataTrx.asuransi || '';
            } else {
                modalTitleTransaksi.textContent = '➕ Tambah Data Transaksi';
                submitButtonTransaksi.textContent = 'Simpan';
                // Untuk 'tambah', jika Kode Transaksi auto-generated, field ini bisa di-disable/hide
                // atau biarkan user input jika memang manual.
            }
            transaksiModal.style.display = 'block';
            // Untuk dropdown FK, panggil fungsi fetch data FK di sini jika ada
        }

        function closeModalTransaksi() {
            transaksiModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == transaksiModal) {
                closeModalTransaksi();
            }
        }

        transaksiForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(transaksiForm);
            const data = Object.fromEntries(formData.entries());
            const currentOriginalKodeTrx = originalKodeTransaksiInput.value;

            let url = API_URL_TRANSAKSI;
            let method = 'POST';

            // Jika currentOriginalKodeTrx ada, berarti ini operasi UPDATE
            if (currentOriginalKodeTrx) {
                method = 'PUT';
                // Jika PK (kode_transaksi) tidak diubah, backend bisa menggunakan kode_transaksi dari body.
                // Jika PK bisa diubah, backend perlu originalKodeTransaksi untuk klausa WHERE.
                // data.original_kode_transaksi = currentOriginalKodeTrx; // kirim pk lama jika pk bisa diubah
                // URL untuk PUT bisa juga seperti: ${API_URL_TRANSAKSI}/${currentOriginalKodeTrx}
                // tergantung desain API backend Anda.
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

                closeModalTransaksi();
                fetchTransaksi();
                alert(currentOriginalKodeTrx ? 'Data transaksi berhasil diupdate! 👍' : 'Data transaksi berhasil ditambahkan! 🎉');

            } catch (error) {
                console.error('Error submitting form:', error);
                alert(Gagal menyimpan data: ${error.message} 😔);
            }
        });

        async function editTransaksi(kodeTrx, event) {
            event.stopPropagation();
            try {
                // Panggil API backend Anda untuk mendapatkan data transaksi berdasarkan Kode Transaksi
                const response = await fetch(${API_URL_TRANSAKSI}?kode_transaksi=${kodeTrx});
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: response.statusText }));
                    throw new Error(errorData.message || HTTP error! status: ${response.status});
                }
                const dataTrx = await response.json();

                if (dataTrx) {
                    // Jika API mengembalikan array (misal dari SELECT WHERE), ambil elemen pertama
                    openModalTransaksi(Array.isArray(dataTrx) ? dataTrx[0] : dataTrx);
                } else {
                    alert('Data transaksi tidak ditemukan!');
                }

            } catch (error) {
                console.error('Error fetching transaksi data for edit:', error);
                alert(Gagal mengambil data transaksi untuk diedit: ${error.message});
            }
        }

        async function deleteTransaksi(kodeTrx) {
            if (confirm(Apakah Anda yakin ingin menghapus transaksi dengan Kode ${kodeTrx}? 🚮)) {
                try {
                    const response = await fetch(API_URL_TRANSAKSI, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ kode_transaksi: kodeTrx }),
                    });

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ message: response.statusText }));
                        throw new Error(errorData.message || HTTP error! status: ${response.status});
                    }

                    alert(Transaksi dengan Kode ${kodeTrx} berhasil dihapus.);
                    fetchTransaksi();

                } catch (error) {
                    console.error('Error deleting transaksi:', error);
                    alert(Gagal menghapus data: ${error.message});
                }
            }
        }

        document.addEventListener('DOMContentLoaded', fetchTransaksi);
    </script>

</body>
</html>