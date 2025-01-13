<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use TCPDF;

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
  
  public function searchBarang()
  {
    $keyword = $this->request->getGet('keyword');

    $modelBarang = new BarangModel();
    $modelKategori = new KategoriModel();

    // Jika keyword tidak kosong, cari barang berdasarkan keyword
    if (!empty($keyword)) {
        $data['barang'] = $modelBarang->like('nama_barang', $keyword)->findAll();
    } else {
        // Jika kosong, tampilkan semua barang
        $data['barang'] = $modelBarang->findAll();
    }

    $data['kategori'] = $modelKategori->findAll();

    return view('barang/index', $data);
  }

  public function barangMasuk($id)
  {
    $barangModel = new BarangModel();

    // Ambil data barang berdasarkan ID
    $barang = $barangModel->find($id);
    
    // Ambil jumlah barang yang masuk dari form
    $stokMasuk = $this->request->getPost('stok_masuk');

    if ($stokMasuk > 0) {
        // Tambahkan stok barang
        $newStok = $barang['stok'] + $stokMasuk;

        // Update stok barang
        $barangModel->update($id, ['stok' => $newStok]);

        // Redirect kembali ke halaman barang
        return redirect()->to('/barang');
    }

    // Jika stok masuk tidak valid, kembali ke halaman sebelumnya
    return redirect()->back()->with('error', 'Jumlah stok masuk tidak valid');
  }

  public function barangKeluar($id)
  {
    $barangModel = new BarangModel();

    // Ambil data barang berdasarkan ID
    $barang = $barangModel->find($id);
    
    // Ambil jumlah barang yang keluar dari form
    $stokKeluar = $this->request->getPost('stok_keluar');

    if ($stokKeluar > 0 && $barang['stok'] >= $stokKeluar) {
        // Kurangi stok barang
        $newStok = $barang['stok'] - $stokKeluar;

        // Update stok barang
        $barangModel->update($id, ['stok' => $newStok]);

        // Redirect kembali ke halaman barang
        return redirect()->to('/barang');
    }

    // Jika stok keluar tidak valid atau stok barang kurang, kembali ke halaman sebelumnya
    return redirect()->back()->with('error', 'Jumlah stok keluar tidak valid atau stok tidak cukup');
  }

  
  public function laporanStok() 
  {
        $barangModel = new BarangModel();
        
        // Ambil semua barang beserta stoknya
        $data['barang'] = $barangModel->findAll();
        
        return view('barang/laporan_stok', $data);
  }

    // Fungsi untuk mengunduh laporan stok sebagai PDF
  public function unduhLaporanStokPDF() 
  {
      $barangModel = new BarangModel();
      
      // Ambil semua barang beserta stoknya
      $barang = $barangModel->findAll();

      // Inisialisasi TCPDF
      $pdf = new TCPDF();
      $pdf->AddPage();
      $pdf->SetFont('helvetica', '', 12);

      // Judul laporan
      $pdf->Cell(0, 10, 'Laporan Stok Barang', 0, 1, 'C');

      // Tabel header
      $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
      $pdf->Cell(40, 10, 'Stok', 1, 0, 'C');
      $pdf->Cell(40, 10, 'Harga', 1, 1, 'C');

      // Tabel isi
      foreach ($barang as $b) {
          $pdf->Cell(60, 10, $b['nama_barang'], 1, 0, 'C');
          $pdf->Cell(40, 10, $b['stok'], 1, 0, 'C');
          $pdf->Cell(40, 10, 'Rp. ' . number_format($b['harga'], 2, ',', '.'), 1, 1, 'C');
      }

      // Output PDF ke browser
      $pdf->Output('laporan_stok.pdf', 'I');  // 'I' untuk menampilkan di browser

      // Pastikan tidak ada output lain setelah ini (tidak ada echo, var_dump, atau HTML)
      exit;
  }
}

