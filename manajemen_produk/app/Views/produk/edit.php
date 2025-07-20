<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h1 { text-align: center; margin-bottom: 30px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea { resize: vertical; min-height: 80px; }
        button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="reset"] {
            background-color: #f44336;
            margin-left: 10px;
        }
        .back-button {
            background-color: #555;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 15px;
        }
        .error-message { color: red; font-size: 0.9em; margin-bottom: 10px; }
        .current-image { max-width: 150px; height: auto; margin-top: 10px; margin-bottom: 15px; display: block; border: 1px solid #eee;}
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Produk</h1>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error-message">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/produk/update/<?= esc($produk['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" value="<?= old('nama_produk', $produk['nama_produk']) ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" step="0.01" value="<?= old('harga', $produk['harga']) ?>" required>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?= old('stok', $produk['stok']) ?>" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required><?= old('deskripsi', $produk['deskripsi']) ?></textarea> <!-- Added required -->

            <label>Gambar Saat Ini:</label>
            <?php if ($produk['gambar']): ?>
                <img src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>" alt="<?= esc($produk['nama_produk']) ?>" class="current-image">
            <?php else: ?>
                <p>Tidak ada gambar saat ini.</p>
            <?php endif; ?>

            <label for="gambar">Ganti Gambar (JPG, JPEG, PNG, maks 2MB):</label> <!-- Updated max size text -->
            <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png"> <!-- No required here, as it's optional -->

            <button type="submit">Perbarui Produk</button>
            <button type="reset">Reset</button>
            <a href="/" class="back-button">Kembali</a>
        </form>
    </div>
</body>
</html>