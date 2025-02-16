#include <bits/stdc++.h>

using namespace std;

class Petshop {
  private:
    string ID;       // ID dari produk
    string nama;     // nama dari produk
    string kategori; // kategori dari produk
    int harga;       // harga dari produk

  public:
    // Constructor without input
    Petshop() {}

    // Constructor yang mengisi atribut dari objek
    Petshop(string input_ID, string input_nama, string input_kategori, int input_harga) {
        this->ID = input_ID;
        this->nama = input_nama;
        this->kategori = input_kategori;
        this->harga = input_harga;
    }

    void set_ID(string input_ID) {
        this->ID = input_ID; // Mengatur atribut ID
    }

    string get_ID() {
        return this->ID; // Mengambil atribut ID
    }

    void set_nama(string input_nama) {
        this->nama = input_nama; // Mengatur atribut nama
    }

    string get_nama() {
        return this->nama; // Mengambil atribut nama
    }

    void set_kategori(string input_kategori) {
        this->kategori = input_kategori; // Mengatur atribut kategori
    }

    string get_kategori() {
        return this->kategori; // Mengambil atribut kategori
    }

    void set_harga(int input_harga) {
        this->harga = input_harga; // Mengatur atribut harga
    }

    int get_harga() {
        return this->harga; // Mengambil atribut harga
    }

    ~Petshop() {} // Destruktor class
};
