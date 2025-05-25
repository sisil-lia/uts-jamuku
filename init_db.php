<?php
// Membuat atau membuka file database SQLite
$db = new SQLite3('jamuku.db');

// Membuat tabel bahan jika belum ada
$db->exec("CREATE TABLE IF NOT EXISTS bahan (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT NOT NULL,
    deskripsi TEXT NOT NULL,
    harga INTEGER NOT NULL,
    jenis TEXT NOT NULL
)");

// Memasukkan data awal bahan jamu
$data = [
    ['Kunyit', 'Bahan utama', 'Antioksidan, antiradang, meningkatkan sistem imun, meredakan nyeri haid', 1500],
    ['Jahe', 'Bahan utama', 'Menghangatkan tubuh, meredakan nyeri otot, meningkatkan imun, mencegah mual', 1200],
    ['Temulawak', 'Bahan utama', 'Melindungi hati, antiinflamasi, meningkatkan nafsu makan', 2000],
    ['Kencur', 'Bahan utama', 'Meredakan nyeri, antibakteri, melancarkan pencernaan, meningkatkan nafsu makan', 1500],
    ['Serai', 'Bahan utama', 'Meredakan demam, melancarkan pencernaan, mengurangi stres', 800],
    ['Daun Pepaya', 'Bahan utama', 'Meningkatkan nafsu makan, membantu pencernaan dengan enzim papain', 600],
    ['Mengkudu', 'Bahan utama', 'Mengelola tekanan darah, pereda nyeri, memperbaiki pencernaan', 2100],
    ['Daun Beluntas', 'Bahan utama', 'Antibakteri, detoksifikasi, menghilangkan bau badan', 800],
    ['Asam Jawa', 'Bahan utama', 'Menurunkan suhu badan, menyegarkan, mendukung kesehatan hati', 1000],
    ['Cengkeh', 'Rempah tambahan', 'Mengatasi sakit kepala, antibakteri', 800],
    ['Kayu Manis', 'Rempah tambahan', 'Menurunkan gula darah, meningkatkan metabolisme', 800],
    ['Daun Pandan', 'Rempah tambahan', 'Memberi aroma harum, membantu pencernaan', 800],
    ['Kapulaga', 'Rempah tambahan', 'Melancarkan peredaran darah, meningkatkan nafsu makan', 500],
    ['Bunga Lawang', 'Rempah tambahan', 'Memberi aroma khas, membantu pencernaan', 500],
    ['Daun Sirih', 'Rempah tambahan', 'Antiseptik, kesehatan mulut dan organ kewanitaan', 500],
    ['Gula Merah', 'Pemanis', 'Menambah rasa manis alami, sumber energi', 1000],
    ['Madu', 'Pemanis', 'Meningkatkan imun, mempercepat penyembuhan, menambah rasa manis', 2000],
    ['Tebu', 'Pemanis', 'Menambah rasa manis alami, mempercepat penyembuhan', 1000],
    ['Lemon', 'Bahan tambahan', 'Menambah rasa segar, sumber vitamin C', 1200],
    ['Delima', 'Bahan tambahan', 'Antioksidan, meningkatkan stamina', 3400],
    ['Soda', 'Bahan tambahan', 'Memberi sensasi segar dan rasa modern pada jamu', 1000],
    ['Mint', 'Bahan tambahan', 'Memberi sensasi segar, antibakteri', 800],
    ['Stevia', 'Pemanis', 'Menambah rasa manis alami, sumber energi', 2000]
];

// Memasukkan data ke tabel bahan
foreach ($data as $bahan) {
    $nama = SQLite3::escapeString($bahan[0]);
    $jenis = SQLite3::escapeString($bahan[1]);
    $deskripsi = SQLite3::escapeString($bahan[2]);
    $harga = $bahan[3];

    $db->exec("INSERT INTO bahan (nama, jenis, deskripsi, harga) 
               VALUES ('$nama', '$jenis', '$deskripsi', $harga)");
}

echo "Database dan tabel bahan berhasil dibuat serta data awal telah dimasukkan.\n";
?>
