<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Sistem Perpustakaan</title>

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
            padding: 20px;
        }

        .forgot-card {
            background: var(--secondary-color);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: none;
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .card-header-custom {
            padding: 40px 30px 10px;
            text-align: center;
        }

        .title {
            font-family: 'Merriweather', serif;
            color: var(--primary-color);
            font-weight: 700;
        }

        .form-container {
            padding: 10px 35px 40px;
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

        .btn-reset {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin-top: 15px;
        }

        .btn-reset:hover {
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

        .info-box {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 15px;
            font-size: 0.8rem;
            color: #555;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="card forgot-card">
            
            <div class="card-header-custom">
                <h2 class="title"><i class="fas fa-key me-2"></i>Lupa Password</h2>
                <p class="text-muted small">Pulihkan akses akun Anda</p>
            </div>

            <div class="form-container">
                <div class="info-box">
                    <i class="fas fa-info-circle me-1"></i> Masukkan username Anda. Sistem akan memvalidasi akun untuk proses reset manual oleh admin utama.
                </div>

                <form action="proses_lupa_password.php" method="POST" autocomplete="off">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Username akun Anda" required>
                        </div>
                    </div>

                    <button type="submit" name="submit_lupa" class="btn btn-reset w-100 mb-4">
                        PROSES RESET
                    </button>

                    <div class="text-center">
                        <a href="login.php" class="small-link">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>