<?php include '../koneksi.php'; ?>

<h1>👥 Manajemen Anggota</h1>
<a href="../index.php">🏠 Kembali ke Dashboard</a>
<hr>

<?php
// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO members (name, address) VALUES (?, ?)");
        $stmt->bind_param("ss", $_POST['name'], $_POST['address']);
        $stmt->execute();
        echo "<p style='color:green'>✅ Anggota berhasil ditambahkan!</p>";
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE members SET name=?, address=? WHERE id=?");
        $stmt->bind_param("ssi", $_POST['name'], $_POST['address'], $_POST['id']);
        $stmt->execute();
        echo "<p style='color:blue'>✅ Anggota berhasil diupdate!</p>";
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM members WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<p style='color:red'>✅ Anggota berhasil dihapus!</p>";
}

// GET DATA UNTUK EDIT
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM members WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}
?>

<h2><?= $edit ? "Edit Anggota" : "Tambah Anggota Baru" ?></h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit ? $editData['id'] : '' ?>">
    Nama: <input type="text" name="name" required value="<?= $edit ? $editData['name'] : '' ?>"><br>
    Alamat: <input type="text" name="address" required value="<?= $edit ? $editData['address'] : '' ?>"><br>
    <button type="submit" name="<?= $edit ? 'update' : 'create' ?>">
        <?= $edit ? 'Update' : 'Simpan' ?>
    </button>
    <?php if ($edit): ?>
        <a href="members.php">Cancel</a>
    <?php endif; ?>
</form>

<hr>

<h2>Daftar Anggota</h2>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Aksi</th></tr>
<?php
$stmt = $conn->prepare("SELECT * FROM members");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['address']}</td>
    <td>
        <a href='index.php?edit={$row['id']}'>Edit</a> | 
        <a href='index.php?delete={$row['id']}' onclick=\"return confirm('Yakin mau hapus?')\">Hapus</a>
    </td>
    </tr>";
}
?>
</table>
