<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data Barang</h1>

<div class="row">
    <div class="col-md-4">
        <form action="/barang/filterByKategori" method="get">
            <div class="input-group mb-3">
                <select name="kategori_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <a href="/barang/create" class="btn btn-success">Tambah Barang</a>
        <a href="/kategori/" class="btn btn-primary">Kategori</a>
    </div>
</div>

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
<tbody>
    <?php foreach ($barang as $b): ?>
        <tr>
            <td><?= $b['nama_barang']; ?></td>
            <td>
                <?= isset($kategori[$b['kategori_id']]) ? $kategori[$b['kategori_id']]['nama_kategori'] : 'Tidak Diketahui'; ?>
            </td>
            <td><?= $b['stok']; ?></td>
            <td>Rp. <?= number_format($b['harga'], 2, ',', '.'); ?></td>
            <td>
                <a href="/barang/edit/<?= $b['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/barang/delete/<?= $b['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

