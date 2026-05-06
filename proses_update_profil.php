<?php
session_start();
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_baru = mysqli_real_escape_string($conn, $_POST['username']);
    $password_baru = $_POST['password'];
    $old_username  = $_SESSION['username'];

    // 1. Logika Upload Foto
    $foto_sql = "";
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $target_dir = "uploads/profile/"; // Pastikan folder ini ADA dan writable
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
        $file_name = "profile_" . time() . "." . $ext;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
            $foto_sql = ", foto = '$file_name'"; // Sesuaikan nama kolom di DB kamu
        }
    }

    // 2. Logika Update Password
    $pw_sql = "";
    if (!empty($password_baru)) {
        $hashed_pw = password_hash($password_baru, PASSWORD_DEFAULT);
        $pw_sql = ", password = '$hashed_pw'";
    }

    // 3. Eksekusi Update
    $sql = "UPDATE admin SET username = '$username_baru' $pw_sql $foto_sql WHERE username = '$old_username'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $username_baru;
        header("Location: pengaturan.php?status=success");
    } else {
        header("Location: pengaturan.php?status=error&msg=" . mysqli_error($conn));
    }
}