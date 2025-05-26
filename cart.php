<?php
session_start();

// Koneksi ke database SQLite
$db = new SQLite3('jamuku.db');

// Inisialisasi keranjang di session jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tangkap data dari form index.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bahan_ids = $_POST['bahan_id'] ?? [];
    $porsi = max(1, (int)($_POST['porsi'] ?? 1));

    // Tambahkan bahan ke keranjang session
    foreach ($bahan_ids as $id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $porsi; // tambah porsi ke bahan yang sudah ada
        } else {
            $_SESSION['cart'][$id] = $porsi;  // set porsi baru
        }
    }
}

// Handle hapus bahan
if (isset($_GET['hapus'])) {
    $hapus_id = $_GET['hapus'];
    unset($_SESSION['cart'][$hapus_id]);
    header('Location: cart.php');
    exit;
}

// Handle tambah jumlah bahan
if (isset($_GET['tambah'])) {
    $tambah_id = $_GET['tambah'];
    if (isset($_SESSION['cart'][$tambah_id])) {
        $_SESSION['cart'][$tambah_id]++;
    }
    header('Location: cart.php');
    exit;
}

// Handle tombol bayar
if (isset($_POST['bayar'])) {
    // Proses bayar bisa dibuat lebih kompleks, untuk sementara hanya reset keranjang
    $_SESSION['cart'] = [];
    $message = "Pembayaran berhasil. Terima kasih telah membeli Jamuku!";
}

// Ambil data bahan yang ada di keranjang
$cart_items = [];
$total_harga = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $result = $db->query("SELECT * FROM bahan WHERE id IN ($ids)");

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $id = $row['id'];
        $jumlah = $_SESSION['cart'][$id];
        $subtotal = $row['harga'] * $jumlah;
        $total_harga += $subtotal;

        $cart_items[] = [
            'id' => $id,
            'nama' => $row['nama'],
            'harga' => $row['harga'],
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja - Jamuku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Keranjang Belanja</h1>

    <?php if (isset($message)) : ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (empty($cart_items)) : ?>
        <p>Keranjang kosong.</p>
        <p><a href="index.php">Pilih bahan jamu</a></p>
    <?php else : ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Harga (Rp)</th>
                    <th>Jumlah Porsi</th>
                    <th>Subtotal (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item) : ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td>
                    <td><?= number_format($item['harga']) ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td><?= number_format($item['subtotal']) ?></td>
                    <td>
                        <a href="cart.php?hapus=<?= $item['id'] ?>">Hapus</a> |
                        <a href="cart.php?tambah=<?= $item['id'] ?>">Tambah</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total Harga: Rp <?= number_format($total_harga) ?></h3>

        <form method="post" action="cart.php">
            <button type="submit" name="bayar">Bayar</button>
        </form>
    <?php endif; ?>
</body>
</html>

