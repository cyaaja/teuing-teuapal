<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun | Sistem Perpustakaan</title>

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
        }

        .main-wrapper {
            background-color: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .register-card {
            background: var(--secondary-color);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: none;
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .card-header-custom {
            padding: 30px 30px 10px;
            text-align: center;
        }

        .title {
            font-family: 'Merriweather', serif;
            color: var(--primary-color);
            font-weight: 700;
        }

        .form-container {
            padding: 10px 35px 35px;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
            color: var(--primary-color);
        }

        .form-control {
            border-left: none;
            padding: 10px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-register {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin-top: 10px;
        }

        .btn-register:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            color: #fff;
        }

        .small-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .small-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="card register-card">
            
            <div class="card-header-custom">
                <h2 class="title"><i class="fas fa-user-plus me-2"></i>Daftar Admin</h2>
                <p class="text-muted small">Buat akun pengelola perpustakaan baru</p>
            </div>

            <div class="form-container">
                <form action="proses_register.php" method="POST" autocomplete="off">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama asli Anda" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Untuk login" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" name="register" class="btn btn-register w-100 mb-3">
                        DAFTAR SEKARANG
                    </button>

                    <div class="text-center">
                        <p class="small mb-0 text-muted">Sudah punya akun? 
                            <a href="login.php" class="small-link">Masuk di sini</a>
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>