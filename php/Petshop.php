<?php
class Petshop
{
    // private attributes for the class
    private string $ID;
    private string $nama;
    private string $kategori;
    private int $harga;
    private string $gambar;

    // constructor for class, also setting each attributes in the process
    function __construct(string $ID, string $nama, string $kategori, int $harga, string $gambar)
    {
        $this->ID = $ID;
        $this->nama = $nama;
        $this->kategori = $kategori;
        $this->harga = $harga;
        $this->gambar = $gambar;
    }

    // Method untuk mengatur atribut ID
    public function set_ID(string $input_ID): void
    {
        $this->ID = $input_ID;
    }

    // Method untuk mengambil atribut ID
    public function get_ID(): string
    {
        return $this->ID;
    }

    // Method untuk mengatur atribut nama
    public function set_Nama(string $input_nama): void
    {
        $this->nama = $input_nama;
    }

    // Method untuk mengambil atribut nama
    public function get_Nama(): string
    {
        return $this->nama;
    }

    // Method untuk mengatur atribut kategori
    public function set_Kategori(string $input_kategori): void
    {
        $this->kategori = $input_kategori;
    }

    // Method untuk mengambil atribut kategori
    public function get_Kategori(): string
    {
        return $this->kategori;
    }

    // Method untuk mengatur atribut harga
    public function set_Harga(int $input_harga): void
    {
        $this->harga = $input_harga;
    }

    // Method untuk mengambil atribut harga
    public function get_Harga(): int
    {
        return $this->harga;
    }

    // Method untuk mengatur atribut gambar
    public function set_Gambar(string $input_gambar): void
    {
        $this->gambar = $input_gambar;
    }

    // Method untuk mengambil atribut gambar
    public function get_Gambar(): string
    {
        return $this->gambar;
    }

    // Menggabungkan masing-masing atribut dan mengembalikan dalam bentuk array
    public function toArray()
    {
        return [
            'id' => $this->ID,
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
            'gambar' => $this->gambar
        ];
    }

    // Destructor
    function __destruct() {}
}
