<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun | LibSpace</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #8176af 0%, #a094e4 100%);
            --bg-gradient: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            --accent-purple: #8176af;
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .register-container {
            background: #fff;
            padding: 50px 40px;
            border-radius: 40px; /* Rounded besar sesuai gambar */
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 550px;
        }

        .header-logo {
            background: var(--primary-gradient);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 15px;
            box-shadow: 0 10px 20px rgba(129, 118, 175, 0.3);
        }

        .brand-name {
            font-weight: 600;
            font-size: 2rem;
            color: #333;
            margin-bottom: 5px;
        }

        .tagline {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 400;
            font-size: 0.85rem;
            color: #666;
            margin-left: 5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #f0f4f9; /* Warna input abu kebiruan lembut */
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #e8eef7;
            box-shadow: 0 0 0 3px rgba(129, 118, 175, 0.1);
            outline: none;
        }

        /* Styling placeholder */
        .form-control::placeholder {
            color: #aaa;
        }

        .btn-register {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 15px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 15px rgba(129, 118, 175, 0.2);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(129, 118, 175, 0.3);
            color: white;
        }

        .login-footer {
            margin-top: 25px;
            font-size: 0.85rem;
            color: #888;
        }

        .login-link {
            text-decoration: none;
            color: #5c7cfa;
            font-weight: 600;
        }

        /* Responsif untuk mobile */
        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="register-container text-center">
    <div class="header-logo">
        <i class="fas fa-book-open"></i>
    </div>
    
    <h2 class="brand-name">LibSpace</h2>
    <p class="tagline">Akses literasi digital dalam genggaman</p>

    <form action="proses_daftar.php" method="POST" autocomplete="off">
        
        <div class="text-start mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="row text-start">
            <div class="col-md-6 mb-3">
                <label class="form-label">ID Siswa / NISN</label>
                <input type="text" name="username" class="form-control" placeholder="ID Anda" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII RPL 1" required>
            </div>
        </div>

        <div class="text-start mb-4">
            <label class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" name="daftar" class="btn btn-register">
            Daftar Sekarang
        </button>

        <div class="login-footer">
            Belum memiliki akun? <a href="login_siswa.php" class="login-link">Daftar Akun</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>