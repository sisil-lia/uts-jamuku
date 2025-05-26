<?php
// Koneksi ke database SQLite
$db = new SQLite3('jamuku.db');

// Ambil data bahan dari tabel bahan
$result = $db->query('SELECT * FROM bahan ORDER BY jenis, nama');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jamuku - Racik Jamu Sesukamu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Jamuku</h1>
    <h2>Pilih Bahan Jamu</h2>

    <form method="post" action="cart.php">
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) : ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="bahan_id[]" value="<?= $row['id'] ?>">
                        </td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['jenis']) ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= number_format($row['harga']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <p>
            <label for="porsi">Jumlah Porsi:</label>
            <input type="number" name="porsi" id="porsi" value="1" min="1" required>
        </p>

        <button type="submit">Masukkan Keranjang</button>
    </form>
</body>
</html>
