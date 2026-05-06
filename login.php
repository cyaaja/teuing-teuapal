<?php
session_start();

// Jika sudah login, langsung lempar ke beranda
if (isset($_SESSION["status"]) && $_SESSION["status"] == "login") {
    header("Location: beranda.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Sistem Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #6b4f3b;
            --secondary-color: #fdf6e3;
            --accent-color: #4b3621;
        }

        body {
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-wrapper {
            background-color: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--secondary-color);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: none;
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .card-header-custom {
            padding: 40px 30px 20px;
            text-align: center;
        }

        .title {
            font-family: 'Merriweather', serif;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .form-container {
            padding: 0 35px 40px;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
            color: var(--primary-color);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-library {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-library:hover {
            background-color: var(--accent-color);
            color: #fff;
            transform: translateY(-2px);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #888;
            font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dcd0b9;
        }
        .divider span { padding: 0 10px; }

        .btn-siswa {
            background-color: #fff;
            color: var(--primary-color);
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-siswa:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .small-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .small-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="card login-card">
            
            <div class="card-header-custom">
                <h2 class="title"><i class="fas fa-book-open me-2"></i>E-Library</h2>
                <p class="text-muted small">Silakan masuk ke akun Anda</p>
            </div>

            <div class="form-container">
                <form action="proses_login.php" method="POST" autocomplete="off">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Ingat saya</label>
                        </div>
                        <a href="lupa_password.php" class="small-link">Lupa Password?</a>
                    </div>

                    <button type="submit" name="login" class="btn btn-library w-100 mb-3">
                        LOGIN
                    </button>

                    <div class="text-center mb-2">
                        <p class="small mb-0 text-muted">Belum punya akun? 
                            <a href="register.php" class="small-link fw-bold">Daftar Sekarang</a>
                        </p>
                    </div>

                    <div class="divider">
                        <span>Atau masuk sebagai</span>
                    </div>

                    <a href="../siswa/login_siswa.php" class="btn-siswa">
                        <i class="fas fa-user-graduate me-2"></i> Login Siswa
                    </a>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>