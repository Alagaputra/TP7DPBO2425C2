<?php include '../koneksi.php'; ?>

<h1>📖 Manajemen Penulis</h1>
<a href="../index.php">🏠 Kembali ke Dashboard</a>
<hr>

<?php
// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO authors (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $_POST['name'], $_POST['email']);
        $stmt->execute();
        echo "<p style='color:green'>✅ Penulis berhasil ditambahkan!</p>";
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE authors SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $_POST['name'], $_POST['email'], $_POST['id']);
        $stmt->execute();
        echo "<p style='color:blue'>✅ Penulis berhasil diupdate!</p>";
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM authors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<p style='color:red'>✅ Penulis berhasil dihapus!</p>";
}

// GET DATA UNTUK EDIT
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM authors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}
?>

<h2><?= $edit ? "Edit Penulis" : "Tambah Penulis Baru" ?></h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit ? $editData['id'] : '' ?>">
    Nama: <input type="text" name="name" required value="<?= $edit ? $editData['name'] : '' ?>"><br>
    Email: <input type="email" name="email" required value="<?= $edit ? $editData['email'] : '' ?>"><br>
    <button type="submit" name="<?= $edit ? 'update' : 'create' ?>">
        <?= $edit ? 'Update' : 'Simpan' ?>
    </button>
    <?php if ($edit): ?>
        <a href="authors.php">Cancel</a>
    <?php endif; ?>
</form>

<hr>

<h2>Daftar Penulis</h2>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Nama</th><th>Email</th><th>Aksi</th></tr>
<?php
$stmt = $conn->prepare("SELECT * FROM authors");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['email']}</td>
    <td>
        <a href='index.php?edit={$row['id']}'>Edit</a> | 
        <a href='index.php?delete={$row['id']}' onclick=\"return confirm('Yakin mau hapus?')\">Hapus</a>
    </td>
    </tr>";
}
?>
</table>
