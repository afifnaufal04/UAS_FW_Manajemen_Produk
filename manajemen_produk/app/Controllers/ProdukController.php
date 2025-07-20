<?php namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;

class ProdukController extends Controller
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        // Memuat helper form, url, dan text
        helper(['form', 'url', 'text']);
    }

    public function index()
    {
        $data['produk'] = $this->produkModel->findAll();
        echo view('produk/index', $data);
    }

    public function create()
    {
        echo view('produk/create');
    }

    public function store()
    {
        $validationRules = [
            'nama_produk' => 'required|min_length[3]|max_length[255]',
            'harga'       => 'required|numeric|greater_than[0]',
            'stok'        => 'required|integer|greater_than_equal_to[0]',
            'deskripsi'   => 'required',
            'gambar'      => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]'
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($gambar->isValid() && ! $gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $namaGambar);
        }

        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'gambar'      => $namaGambar,
        ];

        $this->produkModel->insert($data);

        // Redirect ke URL root '/' yang sekarang ditangani oleh ProdukController::index
        return redirect()->to('/')->with('message', 'Produk berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $data['produk'] = $this->produkModel->find($id);
        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan: ' . $id);
        }
        echo view('produk/edit', $data);
    }

    public function update($id = null)
    {
        $validationRules = [
            'nama_produk' => 'required|min_length[3]|max_length[255]',
            'harga'       => 'required|numeric|greater_than[0]',
            'stok'        => 'required|integer|greater_than_equal_to[0]',
            'deskripsi'   => 'required',
            'gambar'      => 'mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]'
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $produk = $this->produkModel->find($id);
        $namaGambar = $produk['gambar']; // Ambil nama gambar lama

        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && ! $gambar->hasMoved()) {
            // Hapus gambar lama jika ada
            if ($namaGambar && file_exists(ROOTPATH . 'public/uploads/' . $namaGambar)) {
                unlink(ROOTPATH . 'public/uploads/' . $namaGambar);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $namaGambar);
        }

        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'gambar'      => $namaGambar,
        ];

        $this->produkModel->update($id, $data);

        // Redirect ke URL root '/' yang sekarang ditangani oleh ProdukController::index
        return redirect()->to('/')->with('message', 'Produk berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $produk = $this->produkModel->find($id);

        if ($produk) {
            // Hapus gambar dari folder uploads
            if ($produk['gambar'] && file_exists(ROOTPATH . 'public/uploads/' . $produk['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/' . $produk['gambar']);
            }
            $this->produkModel->delete($id);
            // Redirect ke URL root '/' yang sekarang ditangani oleh ProdukController::index
            return redirect()->to('/')->with('message', 'Produk berhasil dihapus.');
        } else {
            // Redirect ke URL root '/' yang sekarang ditangani oleh ProdukController::index
            return redirect()->to('/')->with('error', 'Produk tidak ditemukan.');
        }
    }
}
?>