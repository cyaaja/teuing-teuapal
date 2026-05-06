<?php
require_once 'config/koneksi.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM buku WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) { echo "Data tidak ditemukan"; exit; }
?>

<form action="proses_edit.php" method="POST">
    <div class="modal-body">
        <input type="hidden" name="id_buku" value="<?= $data['id']; ?>">
        
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']); ?>" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($data['penulis']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($data['penerbit']); ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control" value="<?= $data['tahun_terbit']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" name="update" class="btn btn-primary" style="background-color: #6b4f3b; border: none;">Simpan Perubahan</button>
    </div>
</form>