<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --sidebar-width: 280px;
        --sidebar-bg: #1a1612; /* Deep Espresso */
        --accent-color: #e2c7b0; /* Soft Gold/Tan */
        --nav-hover: rgba(226, 199, 176, 0.08);
    }

    .sidebar {
        height: 100vh;
        width: var(--sidebar-width);
        position: fixed;
        top: 0;
        left: 0;
        background: var(--sidebar-bg);
        color: #fff;
        padding: 30px 20px;
        z-index: 1000;
        box-shadow: 10px 0 30px rgba(0,0,0,0.1);
    }

    .brand {
        font-size: 1.4rem;
        font-weight: 800;
        padding: 0 15px 40px;
        color: var(--accent-color);
        display: flex;
        align-items: center;
        letter-spacing: 1px;
    }

    .brand i {
        font-size: 1.8rem;
        margin-right: 12px;
        filter: drop-shadow(0 0 8px rgba(226, 199, 176, 0.3));
    }

    .nav-link {
        color: #948c84 !important;
        padding: 14px 20px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 15px;
        font-weight: 500;
        border-left: 0px solid var(--accent-color);
    }

    .nav-link i {
        margin-right: 15px;
        width: 24px;
        text-align: center;
        font-size: 1.1rem;
    }

    .nav-link:hover, .nav-link.active {
        color: #fff !important;
        background: var(--nav-hover);
        transform: translateX(5px);
    }

    .nav-link.active {
        color: var(--accent-color) !important;
        background: rgba(226, 199, 176, 0.12);
        border-left: 4px solid var(--accent-color);
    }

    .logout-section {
        position: absolute;
        bottom: 30px;
        width: calc(100% - 40px);
    }

    .nav-link.text-danger:hover {
        background: rgba(231, 76, 60, 0.1) !important;
        color: #e74c3c !important;
    }
</style>

<div class="sidebar">
    <div class="brand">
        <i class="fas fa-book-open"></i> E-LIBRARY
    </div>
    <nav class="nav flex-column">
        <?php 
            $current_page = basename($_SERVER['PHP_SELF']); 
        ?>
        <a class="nav-link <?= $current_page == 'beranda.php' ? 'active' : '' ?>" href="beranda.php">
            <i class="fas fa-grid-2"></i> Dashboard
        </a>
        <a class="nav-link <?= $current_page == 'buku.php' ? 'active' : '' ?>" href="buku.php">
            <i class="fas fa-book-bookmark"></i> Data Buku
        </a>
        <a class="nav-link <?= $current_page == 'anggota.php' ? 'active' : '' ?>" href="anggota.php">
            <i class="fas fa-user-group"></i> Anggota
        </a>
        <a class="nav-link <?= $current_page == 'peminjaman.php' ? 'active' : '' ?>" href="peminjaman.php">
            <i class="fas fa-arrow-right-arrow-left"></i> Peminjaman
        </a>
        
        <div class="logout-section">
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-power-off"></i> Keluar
            </a>
        </div>
    </nav>
</div>