<?php
session_start();
session_unset();
session_destroy();

echo "<script>
        alert('Anda Berhasil kaluar!');
        window.location='admin/login.php'; 
      </script>";
exit();
?>