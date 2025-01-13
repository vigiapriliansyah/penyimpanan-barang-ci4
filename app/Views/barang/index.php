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

        <div class="row mb-3">
            <!-- Form Filter Kategori -->
            <div class="col-md-6">
                <form action="/barang/filterByKategori" method="get">
                    <div class="input-group">
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

            <!-- Form Pencarian -->
            <div class="col-md-6">
                <form action="/barang/searchBarang" method="get">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari barang...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <!-- Tombol Aksi -->
            <div class="col-md-12 text-right">
                <a href="/barang/create" class="btn btn-success">Tambah Barang</a>
                <a href="/kategori/" class="btn btn-primary">Kategori</a>
                <a href="/barang/laporanStok" class="btn btn-info">Lihat Laporan Stok Barang</a>
            </div>
        </div>

        <!-- Tabel Data Barang -->
        <!-- Tabel Data Barang -->
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
                        <?php 
                // Menampilkan kategori barang
                $kategoriBarang = array_filter($kategori, function($k) use ($b) {
                    return $k['id_kategori'] == $b['kategori_id'];
                });
                echo !empty($kategoriBarang) 
                    ? reset($kategoriBarang)['nama_kategori'] 
                    : '<span class="text-danger">Tidak Diketahui</span>';
                ?>
                    </td>
                    <td><?= $b['stok']; ?></td>
                    <td>Rp. <?= number_format($b['harga'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="/barang/edit/<?= $b['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/barang/delete/<?= $b['id_barang']; ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus?')">Delete</a>

                        <!-- Tombol Barang Masuk (Stok Bertambah) -->
                        <a href="#" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#barangMasukModal<?= $b['id_barang']; ?>">Barang Masuk</a>

                        <!-- Modal Barang Masuk -->
                        <div class="modal fade" id="barangMasukModal<?= $b['id_barang']; ?>" tabindex="-1"
                            aria-labelledby="barangMasukModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="barangMasukModalLabel">Tambah Stok Barang</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/barang/barangMasuk/<?= $b['id_barang']; ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="stok_masuk">Jumlah Barang Masuk</label>
                                                <input type="number" name="stok_masuk" id="stok_masuk"
                                                    class="form-control" required min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Tambah Stok</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Barang Keluar (Stok Berkurang) -->
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#barangKeluarModal<?= $b['id_barang']; ?>">Barang Keluar</a>

                        <!-- Modal Barang Keluar -->
                        <div class="modal fade" id="barangKeluarModal<?= $b['id_barang']; ?>" tabindex="-1"
                            aria-labelledby="barangKeluarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="barangKeluarModalLabel">Kurangi Stok Barang</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/barang/barangKeluar/<?= $b['id_barang']; ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="stok_keluar">Jumlah Barang Keluar</label>
                                                <input type="number" name="stok_keluar" id="stok_keluar"
                                                    class="form-control" required min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger">Kurangi Stok</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>