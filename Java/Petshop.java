public class Petshop {
    private String ID; // ID dari produk
    private String nama; // nama dari produk
    private String kategori; // kategori dari produk
    private int harga; // harga dari produk

    // Constructor tanpa parameter
    public Petshop() {
    }

    // Constructor yang mengisi atribut dari objek
    public Petshop(String input_ID, String input_nama, String input_kategori, int input_harga) {
        this.ID = input_ID;
        this.nama = input_nama;
        this.kategori = input_kategori;
        this.harga = input_harga;
    }

    public void set_ID(String input_ID) {
        this.ID = input_ID; // Mengatur atribut ID
    }

    public String get_ID() {
        return this.ID; // Mengambil atribut ID
    }

    public void set_Nama(String input_nama) {
        this.nama = input_nama; // Mengatur atribut nama
    }

    public String get_Nama() {
        return this.nama; // Mengambil atribut nama
    }

    public void set_Kategori(String input_kategori) {
        this.kategori = input_kategori; // Mengatur atribut kategori
    }

    public String get_Kategori() {
        return this.kategori; // Mengambil atribut kategori
    }

    public void set_Harga(int input_harga) {
        this.harga = input_harga; // Mengatur atribut harga
    }

    public int get_Harga() {
        return this.harga; // Mengambil atribut harga
    }

    // Destructor tidak diperlukan dalam Java karena Java memiliki garbage
    // collection
}
