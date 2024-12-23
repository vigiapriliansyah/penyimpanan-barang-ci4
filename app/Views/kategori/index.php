<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Kategori</h1>
        
        <a href="/kategori/create" class="btn btn-success mb-3">Tambah Kategori</a>
        <a href="/barang/" class="btn btn-primary mb-3">Kembali ke Barang</a>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $k): ?>
                    <tr>
                        <td><?= $k['id_kategori']; ?></td>
                        <td><?= $k['nama_kategori']; ?></td>
                        <td>
                            <a href="/kategori/edit/<?= $k['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/kategori/delete/<?= $k['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

