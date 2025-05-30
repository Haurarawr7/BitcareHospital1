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
      <div class="menu-item"><a href="data_pasien.php" style="color: inherit; text-decoration: none;">Data Pasien</a></div>
      <div class="card" role="listitem" tabindex="0">Perawat</div>
      <div class="card" role="listitem" tabindex="0">Dokter</div>
    </main>
  </div>
</body>
</html>
