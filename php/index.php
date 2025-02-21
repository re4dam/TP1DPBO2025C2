<?php
include "Petshop.php";
$file = 'data.json';

$data = [];
if (file_exists($file)) {
    $json = file_get_contents($file);
    $decodedData = json_decode($json, true) ?: [];

    // Convert associative arrays to Petshop objects
    foreach ($decodedData as $item) {
        $data[] = new Petshop($item['id'], $item['nama'], $item['kategori'], $item['harga'], $item['gambar']);
    }
}

// Melakukan request dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? ''; // Mengambil action yang didapatkan dari POST

    switch ($action) {
            // Membuat data baru
        case 'create':
            $gambarPath = '';
            if (!empty($_FILES['gambar']['name'])) { // Corrected key: 'name'
                $targetDir = "uploads/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']); // Corrected key: 'name'
                move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath); // Corrected key: 'tmp_name'
            }

            // Menginstansiasi Object Petshop
            $newItem = new Petshop(
                uniqid(), // membuat ID unik
                htmlspecialchars($_POST['name']), // memasukkan namanya
                htmlspecialchars($_POST['kategori']), // memasukkan kategori
                htmlspecialchars($_POST['harga']), // memasukkan harga
                $gambarPath // memasukkan gambar beserta path lokasinya
            );

            // Object dimasukkan ke dalam arrray
            $data[] = $newItem;
            break;

            // Mengupdate data yang sudah ada
        case 'update':
            // Update existing entry
            $id = $_POST['id'];
            foreach ($data as &$item) {
                if ($item->get_ID() === $id) {
                    $item->set_Nama(htmlspecialchars($_POST['name']));
                    $item->set_Kategori(htmlspecialchars($_POST['kategori']));
                    $item->set_Harga(htmlspecialchars($_POST['harga']));

                    if (!empty($_FILES['gambar']['name'])) { // Corrected key: 'name'
                        $targetDir = "uploads/";
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }
                        $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']); // Corrected key: 'name'
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath); // Corrected key: 'tmp_name'
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
                    // Delete the image file
                    if ($item->get_Gambar() && file_exists($item->get_Gambar())) {
                        unlink($item->get_Gambar());
                    }
                    unset($data[$key]);
                }
            }
            break;
    }

    // Convert objects to arrays before saving
    $dataToSave = array_map(fn($item) => $item->ToArray(), $data);
    file_put_contents($file, json_encode(array_values($dataToSave), JSON_PRETTY_PRINT), LOCK_EX);
    header('Location: index.php');
    exit;
}

// Get entry to edit (if any)
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
    <!-- CSS styling for table dan form -->
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

    <!-- Create/Update Form -->
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <!-- id tersembunyi untuk id produk -->
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editItem->get_ID()) ?>">
            <?php endif; ?>

            <!-- input untuk nama produk -->
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($editItem ? $editItem->get_Nama() : '') ?>" required>
        </div>

        <div class="form-group">
            <!-- input untuk kategori produk -->
            <label>Kategori:</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($editItem ? $editItem->get_Kategori() : '') ?>" required>
        </div>

        <div class="form-group">
            <!-- input untuk harga produk -->
            <label>Harga:</label>
            <input type="number" name="harga" value="<?= htmlspecialchars($editItem ? $editItem->get_Harga() : '') ?>" required>
        </div>

        <div class="form-group">
            <!-- input untuk memasukkan gambar produk -->
            <label>Upload Image:</label>
            <input type="file" name="gambar" accept="image/*">
            <!-- kondisi ketika mengedit/ingin mereplace gambar baru -->
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

    <!-- Data Table -->
    <?php if (!empty($data)): ?>
        <table>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
            <?php $iterasi = 1; // Initialize the counter
            foreach ($data as $item): ?>
                <tr>
                    <td><?php echo $iterasi; ?></td>
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
            <?php $iterasi++; // Increment the counter
            endforeach; ?>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</body>

</html>
