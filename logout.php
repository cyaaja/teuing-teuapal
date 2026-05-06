<?php
session_start();
// Hapus semua variabel session
$_SESSION = array();

// Jika ingin menghapus cookie session juga
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect ke login dengan pesan logout
header("location:login_siswa.php?pesan=logout");
exit();
?>