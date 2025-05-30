
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f6f8; /* Latar belakang abu-abu muda */
            color: #333;
        }

        h1 {
            color: #1abc9c; /* Teal */
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border-bottom: 1px solid #e1e1e1;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #1abc9c; /* Teal */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e8f8f5; /* Light teal highlight */
        }

        .actions button {
            margin-right: 5px;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.2s ease;
        }

        .actions .edit-btn {
            background-color: #f1c40f; /* Yellow */
            color: #fff;
        }
        .actions .edit-btn:hover {
            background-color: #d4ac0d;
        }

        .actions .delete-btn {
            background-color: #e74c3c; /* Red */
            color: white;
        }
        .actions .delete-btn:hover {
            background-color: #c0392b;
        }

        .add-btn {
            background-color: #3498db; /* Blue */
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .add-btn:hover {
            background-color: #2980b9;
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
            background-color: rgba(0,0,0,0.5);
            padding-top: 50px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 25px 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #1abc9c; /* Teal focus */
            outline: none;
            box-shadow: 0 0 0 2px rgba(26, 188, 156, 0.2);
        }

        .form-group button[type="submit"] {
            background-color: #1abc9c; /* Teal */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .form-group button[type="submit"]:hover {
            background-color: #16a085;
        }
        .loading-message, .empty-message {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-capsule-pill" viewBox="0 0 16 16" style="vertical-align: -5px; margin-right: 10px;">
        <path d="M11.02 5.364a3 3 0 0 0-4.402-3.24L2.91 5.833a3.001 3.001 0 0 0 4.016 4.484L10.636 6.6A3.001 3.001 0 0 0 11.02 5.364Zm1.311-2.22-3.455 3.454a2.001 2.001 0 0 0 2.828 2.828l3.455-3.454a2.001 2.001 0 0 0-2.828-2.828Z"/>
        <path d="M1.334 13.142a2.001 2.001 0 0 0 2.828 2.828l3.455-3.454a2.001 2.001 0 0 0-2.828-2.828L1.334 13.142Z"/>
      </svg>Data Obat</h1>

    <button class="add-btn" onclick="openModalObat()">➕ Tambah Data Obat</button>

    <table>
        <thead>
            <tr>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Tanggal Produksi</th>
                <th>Stok</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="obatTableBody">
            </tbody>
    </table>

    <div id="obatModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModalObat()">&times;</span>
            <h2 id="modalTitleObat" style="color: #1abc9c; margin-bottom: 20px;">Tambah Data Obat</h2>
            <form id="obatForm">
                <div class="form-group">
                    <label for="kodeObat">Kode Obat:</label>
                    <input type="text" id="kodeObat" name="kode_obat" required>
                </div>
                <div class="form-group">
                    <label for="namaObat">Nama Obat:</label>
                    <input type="text" id="namaObat" name="nama_obat" required>
                </div>
                <div class="form-group">
                    <label for="dosisObat">Dosis:</label>
                    <input type="text" id="dosisObat" name="dosis" placeholder="Contoh: 500mg, 10ml">
                </div>
                <div class="form-group">
                    <label for="tglProduksi">Tanggal Produksi:</label>
                    <input type="date" id="tglProduksi" name="tanggal_produksi" required>
                </div>
                <div class="form-group">
                    <label for="stokObat">Stok:</label>
                    <input type="number" id="stokObat" name="stok" min="0" required>
                </div>
                <div class="form-group">
                    <label for="hargaObat">Harga (Rp):</label>
                    <input type="number" id="hargaObat" name="harga" min="0" step="100" required placeholder="Contoh: 15000">
                </div>
                <input type="hidden" id="originalKodeObat" name="originalKodeObat">

                <div class="form-group">
                    <button type="submit" id="submitButtonObat">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const obatTableBody = document.getElementById('obatTableBody');
        const obatModal = document.getElementById('obatModal');
        const modalTitleObat = document.getElementById('modalTitleObat');
        const obatForm = document.getElementById('obatForm');
        const kodeObatInput = document.getElementById('kodeObat');
        const originalKodeObatInput = document.getElementById('originalKodeObat');
        const submitButtonObat = document.getElementById('submitButtonObat');

        // GANTI DENGAN URL API BACKEND ANDA
        const API_URL_OBAT = 'api/obat.php';

        function formatRupiah(angka) {
            if (angka === null || angka === undefined || isNaN(parseFloat(angka))) {
                return 'N/A';
            }
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        async function fetchObat() {
            obatTableBody.innerHTML = '<tr><td colspan="7" class="loading-message">Memuat data obat... ⏳</td></tr>';
            try {
                const response = await fetch(API_URL_OBAT);
                if (!response.ok) {
                    throw new Error(HTTP error! status: ${response.status}, ${await response.text()});
                }
                const daftarObat = await response.json();

                obatTableBody.innerHTML = '';

                if (daftarObat && daftarObat.length > 0) {
                    daftarObat.forEach(obat => {
                        const row = obatTableBody.insertRow();
                        row.innerHTML = `
                            <td>${obat.kode_obat || 'N/A'}</td>
                            <td>${obat.nama_obat || 'N/A'}</td>
                            <td>${obat.dosis || '-'}</td>
                            <td>${obat.tanggal_produksi ? new Date(obat.tanggal_produksi).toLocaleDateString('id-ID') : 'N/A'}</td>
                            <td>${obat.stok !== undefined ? obat.stok : 'N/A'}</td>
                            <td>${formatRupiah(obat.harga)}</td>
                            <td class="actions">
                                <button class="edit-btn" onclick="editObat('${obat.kode_obat}', event)">✏ Edit</button>
                                <button class="delete-btn" onclick="deleteObat('${obat.kode_obat}')">🗑 Hapus</button>
                            </td>
                        `;
                    });
                } else {
                    obatTableBody.innerHTML = '<tr><td colspan="7" class="empty-message">Belum ada data obat. 🤷</td></tr>';
                }

            } catch (error) {
                console.error('Error fetching obat:', error);
                obatTableBody.innerHTML = <tr><td colspan="7" class="empty-message">Gagal memuat data: ${error.message}. Pastikan backend aktif. 😥</td></tr>;
            }
        }

        function openModalObat(dataObat = null) {
            obatForm.reset();
            kodeObatInput.readOnly = false;
            originalKodeObatInput.value = '';

            if (dataObat) {
                modalTitleObat.textContent = '✏ Edit Data Obat';
                submitButtonObat.textContent = 'Update';

                kodeObatInput.value = dataObat.kode_obat || '';
                // Jika Kode Obat (PK) tidak boleh diubah setelah dibuat, uncomment:
                // kodeObatInput.readOnly = true;
                originalKodeObatInput.value = dataObat.kode_obat || '';

                document.getElementById('namaObat').value = dataObat.nama_obat || '';
                document.getElementById('dosisObat').value = dataObat.dosis || '';
                document.getElementById('tglProduksi').value = dataObat.tanggal_produksi ? dataObat.tanggal_produksi.split('T')[0] : '';
                document.getElementById('stokObat').value = dataObat.stok !== undefined ? dataObat.stok : '';
                document.getElementById('hargaObat').value = dataObat.harga || '';
            } else {
                modalTitleObat.textContent = '➕ Tambah Data Obat';
                submitButtonObat.textContent = 'Simpan';
            }
            obatModal.style.display = 'block';
        }

        function closeModalObat() {
            obatModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == obatModal) {
                closeModalObat();
            }
        }

        obatForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(obatForm);
            const data = Object.fromEntries(formData.entries());
            const currentOriginalKodeObat = originalKodeObatInput.value;

            let url = API_URL_OBAT;
            let method = 'POST';

            if (currentOriginalKodeObat) {
                method = 'PUT';
                // data.original_kode_obat = currentOriginalKodeObat; // Jika PK bisa diubah
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

                closeModalObat();
                fetchObat();
                alert(currentOriginalKodeObat ? 'Data obat berhasil diupdate! 👍' : 'Data obat berhasil ditambahkan! 🎉');

            } catch (error) {
                console.error('Error submitting form:', error);
                alert(Gagal menyimpan data: ${error.message} 😔);
            }
        });

        async function editObat(kodeObat, event) {
            event.stopPropagation();
            try {
                const response = await fetch(${API_URL_OBAT}?kode_obat=${kodeObat});
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: response.statusText }));
                    throw new Error(errorData.message || HTTP error! status: ${response.status});
                }
                const dataObat = await response.json();

                if (dataObat) {
                    openModalObat(Array.isArray(dataObat) ? dataObat[0] : dataObat);
                } else {
                    alert('Data obat tidak ditemukan!');
                }

            } catch (error) {
                console.error('Error fetching obat data for edit:', error);
                alert(Gagal mengambil data obat untuk diedit: ${error.message});
            }
        }

        async function deleteObat(kodeObat) {
            if (confirm(Apakah Anda yakin ingin menghapus obat dengan Kode ${kodeObat}? 🚮)) {
                try {
                    const response = await fetch(API_URL_OBAT, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ kode_obat: kodeObat }),
                    });

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ message: response.statusText }));
                        throw new Error(errorData.message || HTTP error! status: ${response.status});
                    }

                    alert(Obat dengan Kode ${kodeObat} berhasil dihapus.);
                    fetchObat();

                } catch (error) {
                    console.error('Error deleting obat:', error);
                    alert(Gagal menghapus data: ${error.message});
                }
            }
        }

        document.addEventListener('DOMContentLoaded', fetchObat);
    </script>

</body>
</html>
