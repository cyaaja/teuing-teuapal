<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_shika");

if (isset($_POST['submit_lupa'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    // Cek apakah username ada
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        // Opsi A: Reset password ke default '123456'
        $update = mysqli_query($koneksi, "UPDATE admin SET password='123456' WHERE username='$username'");
        
        if ($update) {
            echo "<script>
                    alert('Password berhasil direset ke default: 123456. Silakan login dan segera ganti password Anda!');
                    window.location='login.php';
                  </script>";
        }
    } else {
        // Jika username tidak ketemu
        echo "<script>
                alert('Username tidak ditemukan di sistem kami!');
                window.history.back();
              </script>";
    }
} else {
    header("location:lupa_password.php");
}
?>