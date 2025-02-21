<?php
include "Petshop.php";

// Array untuk menyimpan data Petshop (penyimpanan dalam memori)
$data = [];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? ''; // Mengambil action yang didapatkan dari POST

    switch ($action) {
            // Membuat data baru
        case 'create':
            $id = htmlspecialchars($_POST['id']); // Mengambil ID yang dimasukkan pengguna
            $name = htmlspecialchars($_POST['name']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $gambarPath = '';

            // Memeriksa apakah ID sudah ada
            $idExists = false;
            foreach ($data as $item) {
                if ($item->get_ID() === $id) {
                    $idExists = true;
                    break;
                }
            }

            if ($idExists) {
                echo "<script>alert('ID sudah ada. Silakan gunakan ID yang lain.');</script>";
            } else {
                // Handle file upload
                if (!empty($_FILES['gambar']['name'])) {
                    $targetDir = "uploads/";
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
                    $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']);
                    move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath);
                }

                // Membuat objek Petshop baru
                $newItem = new Petshop($id, $name, $kategori, $harga, $gambarPath);
                $data[] = $newItem; // Menambahkan objek ke dalam array
            }
            break;

            // Mengupdate data yang sudah ada
        case 'update':
            $id = $_POST['id'];
            foreach ($data as &$item) {
                if ($item->get_ID() === $id) {
                    $item->set_Nama(htmlspecialchars($_POST['name']));
                    $item->set_Kategori(htmlspecialchars($_POST['kategori']));
                    $item->set_Harga(htmlspecialchars($_POST['harga']));

                    if (!empty($_FILES['gambar']['name'])) {
                        $targetDir = "uploads/";
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }
                        $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']);
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath);
                        $item->set_Gambar($gambarPath);
                    }
                    break;
                }
            }
            break;

            // Menghapus data
        case 'delete':
            $id = $_POST['id'];
            foreach ($data as $key => $item) {
                if ($item->get_ID() === $id) {
                    // Menghapus file gambar
                    if ($item->get_Gambar() && file_exists($item->get_Gambar())) {
                        unlink($item->get_Gambar());
                    }
                    unset($data[$key]); // Menghapus data dari array
                }
            }
            break;
    }

    // Redirect untuk menghindari form resubmission
    header('Location: index.php');
    exit;
}

// Mengambil data untuk diedit (jika ada)
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    foreach ($data as $item) {
        if ($item->get_ID() === $editId) {
            $editItem = $item;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD without Database</title>
    <!-- CSS styling untuk tabel dan form -->
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        form {
            margin: 20px 0;
        }

        .form-group {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Petshop Manager</h1>

    <!-- Form Create/Update -->
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editItem->get_ID()) ?>">
            <?php else: ?>
                <!-- Input untuk ID produk yang dimasukkan pengguna -->
                <label>ID:</label>
                <input type="text" name="id" value="<?= htmlspecialchars($editItem ? $editItem->get_ID() : '') ?>" required>
            <?php endif; ?>

            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($editItem ? $editItem->get_Nama() : '') ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori:</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($editItem ? $editItem->get_Kategori() : '') ?>" required>
        </div>

        <div class="form-group">
            <label>Harga:</label>
            <input type="number" name="harga" value="<?= htmlspecialchars($editItem ? $editItem->get_Harga() : '') ?>" required>
        </div>

        <div class="form-group">
            <label>Upload Image:</label>
            <input type="file" name="gambar" accept="image/*">
            <?php if ($editItem && $editItem->get_Gambar()): ?>
                <p>Current Image:</p>
                <img src="<?= htmlspecialchars($editItem->get_Gambar()) ?>" width="100">
            <?php endif; ?>
        </div>

        <button type="submit"><?= $editItem ? 'Update' : 'Add' ?></button>
        <?php if ($editItem): ?>
            <a href="index.php">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data -->
    <?php if (!empty($data)): ?>
        <table>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
            <?php $iterasi = 1; // Inisialisasi counter
            foreach ($data as $item): ?>
                <tr>
                    <td><?php echo $iterasi; ?></td>
                    <td><?= htmlspecialchars($item->get_ID()) ?></td>
                    <td>
                        <?php if ($item->get_Gambar()): ?>
                            <img src="<?= htmlspecialchars($item->get_Gambar()) ?>" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item->get_Nama()) ?></td>
                    <td><?= htmlspecialchars($item->get_Kategori()) ?></td>
                    <td><?= htmlspecialchars($item->get_Harga()) ?></td>
                    <td>
                        <a href="index.php?edit=<?= htmlspecialchars($item->get_ID()) ?>">Edit</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($item->get_ID()) ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php $iterasi++; // Increment counter
            endforeach; ?>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</body>

</html>
