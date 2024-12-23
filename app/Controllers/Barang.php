<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;

class Barang extends BaseController
{
    public function index()
    {
$modelBarang = new BarangModel();
$modelKategori = new KategoriModel();

$data['barang'] = $modelBarang->findAll();
$data['kategori'] = array_column($modelKategori->findAll(), null, 'id_kategori');

return view('barang/index', $data);
    }

    public function create()
    {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('barang/create', $data);
    }

    public function store()
    {
        $barangModel = new BarangModel();
        
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga')
        ];

        $barangModel->save($data);
        
        return redirect()->to('/barang');
    }

    public function edit($id)
    {
        $barangModel = new BarangModel();
        $data['barang'] = $barangModel->find($id);
        
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('barang/edit', $data);
    }

    public function update($id)
    {
        $barangModel = new BarangModel();
        
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga')
        ];

        $barangModel->update($id, $data);
        
        return redirect()->to('/barang');
    }

    public function delete($id)
    {
        $barangModel = new BarangModel();
        $barangModel->delete($id);
        
        return redirect()->to('/barang');
    }

public function filterByKategori()
{
    $kategori_id = $this->request->getGet('kategori_id');

    $modelBarang = new BarangModel();
    $modelKategori = new KategoriModel();

    // Jika kategori dipilih, filter berdasarkan kategori_id
    if (!empty($kategori_id)) {
        $data['barang'] = $modelBarang->where('kategori_id', $kategori_id)->findAll();
    } else {
        // Jika tidak, tampilkan semua barang
        $data['barang'] = $modelBarang->findAll();
    }

    $data['kategori'] = $modelKategori->findAll();

    return view('barang/index', $data);
}
}

