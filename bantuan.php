<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfaf8; 
            color: #2c2119;
        }
        .main-content { margin-left: 280px; padding: 40px; transition: 0.3s; }
        
        /* Tombol Kembali Estetik */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #6b4f3b;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 25px;
            padding: 8px 16px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #eee;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .btn-back:hover {
            background: #2c2119;
            color: #fff;
            transform: translateX(-5px);
            border-color: #2c2119;
        }

        .hero-section {
            background: linear-gradient(135deg, #2c2119 0%, #4d3a2b 100%);
            border-radius: 30px;
            padding: 60px 40px;
            color: white;
            margin-bottom: 40px;
            box-shadow: 0 20px 40px rgba(44, 33, 25, 0.15);
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .help-card {
            background: #fff;
            border-radius: 24px;
            border: none;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.03);
        }

        .help-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(44, 33, 25, 0.08);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #f4eee9;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #2c2119;
            font-size: 1.5rem;
        }

        .faq-item {
            background: #fff;
            border-radius: 20px;
            margin-bottom: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        }

        .accordion-button {
            border-radius: 20px !important;
            padding: 20px;
            font-weight: 600;
            color: #2c2119;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f4eee9;
            color: #2c2119;
        }

        .contact-btn {
            background: #2c2119;
            color: white;
            padding: 12px 30px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: 0.3s;
        }

        .contact-btn:hover {
            background: #e2c7b0;
            color: #2c2119;
            transform: scale(1.05);
        }

        @media (max-width: 992px) { 
            .main-content { margin-left: 0; padding: 20px; } 
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <a href="beranda.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="hero-section text-center">
        <h1 class="fw-800 mb-3">Halo, ada yang bisa kami bantu?</h1>
        <p class="opacity-75 mb-0">Cari panduan penggunaan atau hubungi tim teknis kami</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="help-card">
                <div class="icon-box">
                    <i class="fas fa-book"></i>
                </div>
                <h5 class="fw-700">Panduan Admin</h5>
                <p class="text-muted small">Pelajari cara mengelola data buku, anggota, dan transaksi peminjaman secara efektif.</p>
                <a href="#" class="text-decoration-none fw-bold" style="color: #6b4f3b;">Baca Panduan →</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-card">
                <div class="icon-box">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5 class="fw-700">Keamanan Akun</h5>
                <p class="text-muted small">Tips menjaga kerahasiaan password dan keamanan data perpustakaan digital Anda.</p>
                <a href="#" class="text-decoration-none fw-bold" style="color: #6b4f3b;">Tips Keamanan →</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-card">
                <div class="icon-box">
                    <i class="fas fa-headset"></i>
                </div>
                <h5 class="fw-700">Hubungi Kami</h5>
                <p class="text-muted small">Mengalami kendala teknis atau error sistem? Tim IT kami siap membantu Anda 24/7.</p>
                <a href="https://wa.me/6283821408359" class="contact-btn">Chat WhatsApp</a>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3 class="fw-800 mb-4">Pertanyaan Umum (FAQ)</h3>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item faq-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Bagaimana cara menambah cover buku?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Buka menu <b>Data Buku</b>, klik tombol <b>Tambah Koleksi</b>, dan pilih file gambar (JPG/PNG) pada kolom Upload Cover. Pastikan ukuran file tidak lebih dari 2MB.
                    </div>
                </div>
            </div>

            <div class="accordion-item faq-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Mengapa data yang dihapus tidak bisa kembali?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Sistem kami menggunakan penghapusan permanen untuk menjaga efisiensi database. Pastikan Anda telah memeriksa kembali sebelum mengonfirmasi penghapusan.
                    </div>
                </div>
            </div>

            <div class="accordion-item faq-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Bagaimana cara mengganti password admin?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Anda dapat menghubungi Super Admin atau mengubahnya melalui menu Pengaturan Profil (jika tersedia) untuk memperbarui kredensial login Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 pt-4 pb-5">
        <p class="text-muted">Versi Aplikasi v2.4.56-Build</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#" class="text-muted small text-decoration-none">Privacy Policy</a>
            <a href="#" class="text-muted small text-decoration-none">Terms of Service</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>