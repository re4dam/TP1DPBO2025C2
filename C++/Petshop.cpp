#include <bits/stdc++.h>

using namespace std;

class Petshop {
  private:
    string ID;
    string nama;
    string kategori;
    int harga;

  public:
    Petshop() {}

    Petshop(string input_ID, string input_nama, string input_kategori, int input_harga) {
        this->ID = input_ID;
        this->nama = input_nama;
        this->kategori = input_kategori;
        this->harga = input_harga;
    }

    void set_ID(string input_ID) {
        this->ID = input_ID;
    }

    string get_ID() {
        return this->ID;
    }

    void set_nama(string input_nama) {
        this->nama = input_nama;
    }

    string get_nama() {
        return this->nama;
    }

    void set_kategori(string input_kategori) {
        this->kategori = input_kategori;
    }

    string get_kategori() {
        return this->kategori;
    }

    void set_harga(int input_harga) {
        this->harga = input_harga;
    }

    int get_harga() {
        return this->harga;
    }

    ~Petshop() {}
};
