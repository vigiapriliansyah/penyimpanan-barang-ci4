<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Kategori</h1>

        <form action="/kategori/update/<?= $kategori['id_kategori']; ?>" method="post">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= $kategori['nama_kategori']; ?>" required>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="/kategori" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>

