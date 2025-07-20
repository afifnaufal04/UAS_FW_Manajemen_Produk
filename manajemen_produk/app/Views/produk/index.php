<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light background */
            color: #343a40;
        }
        .container {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
            font-size: 2.5em;
        }
        .message, .error {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .product-image {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 4px; /* Slightly rounded corners for images */
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .no-products {
            text-align: center;
            font-size: 1.2em;
            color: #777;
            padding: 50px 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        /* Custom adjustments for table actions */
        .table .actions {
            white-space: nowrap; /* Prevent buttons from wrapping */
        }
        .table .actions .btn {
            margin-right: 5px; /* Spacing between buttons */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Produk</h1>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-end mb-4">
            <a href="/produk/create" class="btn btn-success shadow-sm">Tambah Produk Baru</a>
        </div>

        <?php if (!empty($produk) && is_array($produk)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $item): ?>
                            <tr>
                                <td><?= esc($item['id']) ?></td>
                                <td><?= esc($item['nama_produk']) ?></td>
                                <td>Rp<?= number_format(esc($item['harga']), 0, ',', '.') ?></td>
                                <td><?= esc($item['stok']) ?></td>
                                <td><?= esc(word_limiter($item['deskripsi'], 10)) ?></td>
                                <td class="text-center">
                                    <?php if ($item['gambar']): ?>
                                        <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama_produk']) ?>" class="product-image">
                                    <?php else: ?>
                                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #adb5bd;">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    <?php endif; ?>
                                </td>
                                <td class="actions text-center">
                                    <a href="/produk/edit/<?= esc($item['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/produk/delete/<?= esc($item['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-products alert alert-info">
                Tidak ada produk ditemukan.
                <p class="mt-3"><a href="/produk/create" class="btn btn-success">Tambah Produk Baru</a></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS (Popper.js and Bootstrap.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN77zV/r+6sJ" crossorigin="anonymous"></script>
</body>
</html>
