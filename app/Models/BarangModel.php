<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['nama_barang', 'kategori_id', 'stok', 'harga'];
    protected $useTimestamps = false;

    public function getBarangByKategori($kategori_id)
    {
        return $this->where('kategori_id', $kategori_id)->findAll();
    }
}

