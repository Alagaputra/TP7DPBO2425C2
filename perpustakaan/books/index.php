<?php include '../koneksi.php'; ?>

<h1>📚 Manajemen Buku</h1>
<a href="../index.php">🏠 Kembali ke Dashboard</a>
<hr>

<?php
// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO books (title, author_id, year) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $_POST['title'], $_POST['author_id'], $_POST['year']);
        $stmt->execute();
        echo "<p style='color:green'>✅ Buku berhasil ditambahkan!</p>";
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE books SET title=?, author_id=?, year=? WHERE id=?");
        $stmt->bind_param("siii", $_POST['title'], $_POST['author_id'], $_POST['year'], $_POST['id']);
        $stmt->execute();
        echo "<p style='color:blue'>✅ Buku berhasil diupdate!</p>";
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<p style='color:red'>✅ Buku berhasil dihapus!</p>";
}

// GET DATA UNTUK EDIT
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}
?>

<h2><?= $edit ? "Edit Buku" : "Tambah Buku Baru" ?></h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit ? $editData['id'] : '' ?>">
    Judul: <input type="text" name="title" required value="<?= $edit ? $editData['title'] : '' ?>"><br>
    Tahun: <input type="number" name="year" required value="<?= $edit ? $editData['year'] : '' ?>"><br>
    Penulis:
    <select name="author_id">
        <?php
        $stmt2 = $conn->prepare("SELECT * FROM authors");
        $stmt2->execute();
        $authors = $stmt2->get_result();
        while ($row = $authors->fetch_assoc()) {
            $selected = ($edit && $row['id'] == $editData['author_id']) ? 'selected' : '';
            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
        }
        ?>
    </select><br>
    <button type="submit" name="<?= $edit ? 'update' : 'create' ?>">
        <?= $edit ? 'Update' : 'Simpan' ?>
    </button>
    <?php if ($edit): ?>
        <a href="books.php">Cancel</a>
    <?php endif; ?>
</form>

<hr>

<h2>Daftar Buku</h2>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Tahun</th><th>Aksi</th></tr>
<?php
$stmt = $conn->prepare("SELECT books.id, books.title, books.year, authors.name AS author FROM books JOIN authors ON books.author_id=authors.id");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['title']}</td>
    <td>{$row['author']}</td>
    <td>{$row['year']}</td>
    <td>
        <a href='index.php?edit={$row['id']}'>Edit</a> | 
        <a href='index.php?delete={$row['id']}' onclick=\"return confirm('Yakin mau hapus?')\">Hapus</a>
    </td>
    </tr>";
}
?>
</table>
