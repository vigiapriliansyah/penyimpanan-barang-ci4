<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['id_barang', 'jumlah', 'tipe_transaksi', 'tanggal'];
    protected $useTimestamps = false;

    public function transaksiMasuk($id_barang, $jumlah)
    {
        // Menambahkan transaksi masuk
        $data = [
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'tipe_transaksi' => 'masuk',
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        // Simpan transaksi
        $this->save($data);

        // Update stok barang
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id_barang);
        $new_stok = $barang['stok'] + $jumlah;
        $barangModel->update($id_barang, ['stok' => $new_stok]);
    }

    public function transaksiKeluar($id_barang, $jumlah)
    {
        // Menambahkan transaksi keluar
        $data = [
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'tipe_transaksi' => 'keluar',
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        // Simpan transaksi
        $this->save($data);

        // Update stok barang
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id_barang);
        $new_stok = $barang['stok'] - $jumlah;
        $barangModel->update($id_barang, ['stok' => $new_stok]);
    }

    public function getLaporanTransaksi()
    {
        // Mengambil laporan transaksi
        $builder = $this->builder();
        $builder->select('transaksi.id_transaksi, barang.nama_barang, transaksi.jumlah, transaksi.tipe_transaksi, transaksi.tanggal')
            ->join('barang', 'barang.id_barang = transaksi.id_barang')
            ->orderBy('transaksi.tanggal', 'DESC');

        return $builder->get()->getResultArray();
    }
}

