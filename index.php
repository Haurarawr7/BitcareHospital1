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
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <div class="menu-item" onclick="window.location.href='pelayanan.php'">Administrasi</div>
    <div class="menu-item" onclick="window.location.href='tindakanmedis.php'">Tindakan medis</div>
    <div class="menu-item" onclick="window.location.href='rekammedis.php'">Rekam medis</div>
    <div class="menu-item" onclick="window.location.href='obat.php'">Obat</div>
    <div class="menu-item" onclick="window.location.href='transaksi.php'">Transaksi</div>
    <div class="menu-item" onclick="window.location.href='ruangan.php'">Ruangan</div>
    <div class="menu-item" onclick="window.location.href='staff.php'">Staf</div>
    <div class="menu-item" onclick="window.location.href='pasien.php'">Pasien</div>
    <div class="menu-item" onclick="window.location.href='perawat.php'">Perawat</div>
    <div class="menu-item" onclick="window.location.href='dokter.php'">Dokter</div>
  </div>
  <div class="main-content">
    <header>
      <h1>Selamat datang di Administrasi Bitcare Hospital</h1>
    </header>
    <div class="content">
      <p>Jadikan Administrasi Bitcare sebagai pusat kendali operasional Anda. Di sini, Anda akan menemukan semua yang dibutuhkan untuk mengelola data pasien, jadwal, dan operasional harian dengan akurat dan real-time. Dapatkan wawasan yang mendalam dan kendali penuh atas klinik Anda, memastikan setiap keputusan didasari informasi yang tepat.</p>
    </div>
  </div>
</body>
</html>
