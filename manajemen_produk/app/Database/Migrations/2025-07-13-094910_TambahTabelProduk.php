<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahTabelProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'harga' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'null'           => false,
            ],
            'stok' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
                'default'        => 0,
            ],
            'deskripsi' => [
                'type'           => 'TEXT',
                'null'           => false, // <-- Diubah: deskripsi sekarang TIDAK BOLEH KOSONG di DB
            ],
            'gambar' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false, // <-- Diubah: gambar sekarang TIDAK BOLEH KOSONG di DB
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true, // Tetap true, akan diisi otomatis oleh CodeIgniter
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true, // Tetap true, akan diisi otomatis oleh CodeIgniter
            ],
        ]);
        $this->forge->addKey('id', true); // Menambahkan primary key
        $this->forge->createTable('produk'); // Membuat tabel dengan nama 'produk'
    }

    public function down()
    {
        $this->forge->dropTable('produk'); // Menghapus tabel jika migrasi di-rollback
    }
}