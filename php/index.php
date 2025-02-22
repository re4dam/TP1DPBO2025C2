<?php
// Memasukkan definisi kelas Petshop
include "Petshop.php";

// Memulai session untuk menyimpan data sementara
session_start();

// Inisialisasi array $data di dalam session jika belum ada
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = [];
}

// Menggunakan data dari session
$data = &$_SESSION['data'];

// Fungsi untuk memformat harga ke dalam format Rupiah (IDR)
function formatRupiah($harga)
{
    return 'Rp ' . number_format($harga, 0, ',', '.'); // Format: Rp 1.000.000
}

// Menangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? ''; // Mengambil aksi dari form (create, update, delete)

    switch ($action) {
            // Membuat data baru
        case 'create':
            $id = htmlspecialchars($_POST['id']); // Mengambil ID dari input pengguna
            $name = htmlspecialchars($_POST['name']); // Mengambil nama dari input pengguna
            $kategori = htmlspecialchars($_POST['kategori']); // Mengambil kategori dari input pengguna
            $harga = htmlspecialchars($_POST['harga']); // Mengambil harga dari input pengguna
            $gambarPath = ''; // Inisialisasi path gambar

            // Memeriksa apakah ID sudah ada
            $idExists = false;
            $index = 0; // Inisialisasi index untuk iterasi
            $dataLength = count($data); // Hitung panjang array $data

            // Gunakan while untuk iterasi
            while ($index < $dataLength && !$idExists) {
                if ($data[$index]->get_ID() === $id) {
                    $idExists = true;
                }
                $index++; // Increment index
            }

            if ($idExists) {
                echo "<script>alert('ID sudah ada. Silakan gunakan ID yang lain.');</script>";
            } else {
                // Menangani upload gambar
                if (!empty($_FILES['gambar']['name'])) {
                    $targetDir = "uploads/"; // Direktori untuk menyimpan gambar
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true); // Buat direktori jika belum ada
                    }
                    // Generate nama unik untuk file gambar
                    $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']);
                    move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath); // Pindahkan file ke direktori
                }

                // Membuat objek Petshop baru
                $newItem = new Petshop($id, $name, $kategori, $harga, $gambarPath);
                $_SESSION['data'][] = $newItem; // Menambahkan objek baru ke dalam session data
            }
            break;

            // Mengupdate data yang sudah ada
        case 'update':
            $id = $_POST['id']; // Mengambil ID dari input pengguna
            $index = 0; // Inisialisasi index untuk iterasi
            $dataLength = count($data); // Hitung panjang array $data
            $idExists = false;

            // Gunakan while untuk iterasi
            while ($index < $dataLength && !$idExists) {
                if ($data[$index]->get_ID() === $id) {
                    // Update nama, kategori, dan harga
                    $data[$index]->set_Nama(htmlspecialchars($_POST['name']));
                    $data[$index]->set_Kategori(htmlspecialchars($_POST['kategori']));
                    $data[$index]->set_Harga(htmlspecialchars($_POST['harga']));

                    // Menangani upload gambar baru (jika ada)
                    if (!empty($_FILES['gambar']['name'])) {
                        $targetDir = "uploads/";
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true); // Buat direktori jika belum ada
                        }
                        // Generate nama unik untuk file gambar baru
                        $gambarPath = $targetDir . uniqid() . "_" . basename($_FILES['gambar']['name']);
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath); // Pindahkan file ke direktori
                        $data[$index]->set_Gambar($gambarPath); // Update path gambar
                    }
                    $idExists = true;
                }
                $index++; // Increment index
            }
            break;

            // Menghapus data
        case 'delete':
            $id = $_POST['id']; // Mengambil ID dari input pengguna
            foreach ($data as $key => $item) {
                if ($item->get_ID() === $id) {
                    // Menghapus file gambar jika ada
                    if ($item->get_Gambar() && file_exists($item->get_Gambar())) {
                        unlink($item->get_Gambar()); // Hapus file dari server
                    }
                    unset($data[$key]); // Hapus data dari array
                }
            }
            break;
    }

    // Redirect untuk menghindari pengiriman form ulang
    header('Location: index.php');
    exit;
}

// Menangani pencarian data
$searchTerm = $_GET['search'] ?? ''; // Mengambil kata kunci pencarian
$filteredData = $data;

if ($searchTerm) {
    // Filter data berdasarkan nama (case-insensitive)
    $filteredData = array_filter($data, function ($item) use ($searchTerm) {
        return stripos($item->get_Nama(), $searchTerm) !== false;
    });
}

// Mengambil data untuk diedit (jika ada)
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit']; // Mengambil ID dari parameter URL
    foreach ($data as $item) {
        if ($item->get_ID() === $editId) {
            $editItem = $item; // Set data yang akan diedit
            break;
        }
    }
}

// Menghapus session data (opsional)
if (isset($_GET['clear_session'])) {
    session_destroy(); // Hapus semua data session
    header('Location: index.php'); // Redirect ke halaman utama
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD PHP</title>
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
    <h1>Petshop</h1>

    <!-- Form Pencarian -->
    <form method="get" action="">
        <label for="search">Cari berdasarkan Nama:</label>
        <input type="text" id="search" name="search" placeholder="Masukkan nama..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Cari</button>
        <a href="index.php">Clear Search</a>
    </form>

    <!-- Form Create/Update -->
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editItem->get_ID()) ?>">
            <?php else: ?>
                <!-- Input untuk ID produk -->
                <label>ID:</label>
                <input type="text" name="id" value="<?= htmlspecialchars($editItem ? $editItem->get_ID() : '') ?>" required>
            <?php endif; ?>

            <label>Nama:</label>
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
            <label>Upload Gambar:</label>
            <input type="file" name="gambar" accept="image/*">
            <?php if ($editItem && $editItem->get_Gambar()): ?>
                <p>Gambar Saat Ini:</p>
                <img src="<?= htmlspecialchars($editItem->get_Gambar()) ?>" width="100">
            <?php endif; ?>
        </div>

        <button type="submit"><?= $editItem ? 'Update' : 'Tambah' ?></button>
        <?php if ($editItem): ?>
            <a href="index.php">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data -->
    <?php if (!empty($filteredData)): ?>
        <table>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            <?php $iterasi = 1; // Inisialisasi counter
            foreach ($filteredData as $item): ?>
                <tr>
                    <td><?php echo $iterasi; ?></td>
                    <td><?= htmlspecialchars($item->get_ID()) ?></td>
                    <td>
                        <?php if ($item->get_Gambar()): ?>
                            <img src="<?= htmlspecialchars($item->get_Gambar()) ?>" width="100">
                        <?php else: ?>
                            Tidak Ada Gambar
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item->get_Nama()) ?></td>
                    <td><?= htmlspecialchars($item->get_Kategori()) ?></td>
                    <td><?= formatRupiah(htmlspecialchars($item->get_Harga())) ?></td>
                    <td>
                        <a href="index.php?edit=<?= htmlspecialchars($item->get_ID()) ?>">Edit</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($item->get_ID()) ?>">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php $iterasi++; // Increment counter
            endforeach; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada data ditemukan.</p>
    <?php endif; ?>

    <!-- Link untuk Menghapus Session -->
    <p><a href="index.php?clear_session=1">Clear All Data</a></p>
</body>

</html>
