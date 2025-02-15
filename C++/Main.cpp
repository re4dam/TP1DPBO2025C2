#include "Petshop.cpp"

int main() {
    list<Petshop> produk;      // buat List untuk produk produk petshop
    bool exit = false;         // bool value untuk status perulangan tak hingga
    int option;                // opsi menu yang diputuskan
    string ID, nama, kategori; // temporary variabel khusus string
    int harga;                 // temporary variabel khusus integer

    // Tampilkan pilihan yang bisa diambil user
    cout << "Opsi Menu" << endl;
    cout << "1. Add product" << endl;
    cout << "2. Show products" << endl;
    cout << "3. Update product" << endl;
    cout << "4. Delete product" << endl;
    cout << "5. Find product by name" << endl;
    cout << "6. Exit" << endl;

    while (exit == false) {
        cin >> option; // berikan user kesempatan untuk memilih tindakan

        list<Petshop>::iterator it = produk.begin();  // Iterator dari List Produk
        if (option == 1) {                            // Menambahkan data produk
            cin >> ID >> nama >> kategori >> harga;   // Menginput atribut-atribut produk
            Petshop input(ID, nama, kategori, harga); // Menginstansiasi ke dalam objek

            produk.push_back(input); // Memasukkan objek ke dalam List produk
        } else if (option == 2) {    // Menampilkan produk-produk
            while (it != produk.end()) {
                cout << it->get_ID() << " " << it->get_nama() << " " << it->get_kategori() << " " << it->get_harga() << endl; // Menampilkan data

                it++; // Melanjutkan iterasi dari List
            }
        } else if (option == 3) {                   // Memperbarui data dari produk
            cin >> ID >> nama >> kategori >> harga; // Memasukkan ID produk yang ingin diubah, beserta hasil perubahannya
            bool loop = true;
            while (it != produk.end() && loop == true) {
                if (it->get_ID() == ID) {       // ketika ID ditemukan
                    it->set_nama(nama);         // Mengatur nama produk
                    it->set_kategori(kategori); // Mengatur kategori produk
                    it->set_harga(harga);       // Mengatur harga produk
                    loop = false;               // mengeluarkan dari perulangan
                } else {
                    it++; // Mengiterasikan list
                }
            }
        } else if (option == 4) { // Menghapus sebuah data dari List produk
            cin >> ID;            // Memasukkan ID produk yang ingin dihapus
            bool loop = true;
            while (it != produk.end() && loop == true) {
                if (it->get_ID() == ID) {  // ketika ID ditemukan
                    it = produk.erase(it); // Menghapus data produk
                    loop = false;          // mengeluarkan dari perulangan
                } else {
                    it++; // Mengiterasikan list
                }
            }
        } else if (option == 5) { // Mencari data sesuai nama produk
            cin >> nama;          // memasukkan nama produk yang ingin dicari
            bool loop = true;
            while (it != produk.end() && loop == true) {
                if (it->get_nama() == ID) {                                                                                       // ketika nama produk ditemukan
                    cout << it->get_ID() << " " << it->get_nama() << " " << it->get_kategori() << " " << it->get_harga() << endl; // tampilkan produk tersebut
                    loop = false;                                                                                                 // mengeluarkan dari perulangan
                } else {
                    it++; // Mengiterasikan list
                }
            }
        } else if (option == 6) { // Exit dari program
            exit = true;          // merubah state dari false menjadi true
        }
    }

    return 0;
}
