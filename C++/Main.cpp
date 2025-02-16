#include "Petshop.cpp"
#include <cstring>

int main() {
    list<Petshop> produk;      // buat List untuk produk produk petshop
    bool exit = false;         // bool value untuk status perulangan tak hingga
    int option;                // opsi menu yang diputuskan
    string ID, nama, kategori; // temporary variabel khusus string
    int harga;                 // temporary variabel khusus integer

    while (exit == false) {
        // Tampilkan pilihan yang bisa diambil user
        cout << "Opsi Menu" << endl;
        cout << "1. Add product" << endl;
        cout << "2. Show products" << endl;
        cout << "3. Update product" << endl;
        cout << "4. Delete product" << endl;
        cout << "5. Find product by name" << endl;
        cout << "6. Exit" << endl;
        cout << endl;

        cin >> option; // berikan user kesempatan untuk memilih tindakan
        bool loop = true;

        list<Petshop>::iterator it = produk.begin(); // Iterator dari List Produk
        if (option == 1) {                           // Menambahkan data produk
            cin >> ID >> nama >> kategori >> harga;  // Menginput atribut-atribut produk
            while (it != produk.end() && loop == true) {
                if (it->get_ID() == ID) {
                    loop = false;
                } else {
                    it++;
                }
            }
            if (loop == true) {
                Petshop input(ID, nama, kategori, harga); // Menginstansiasi ke dalam objek
                produk.push_back(input);                  // Memasukkan objek ke dalam List produk
                cout << "ADD product successful" << endl;
            } else {
                cout << "ID product already exist, please use a new ID" << endl;
            }
        } else if (option == 2) { // Menampilkan produk-produk

            // Print table header
            cout << "---------------------------------------------------------" << endl;
            cout << "ID\t| Nama\t\t| Kategori\t| Harga\t\t|" << endl;
            cout << "---------------------------------------------------------" << endl;

            while (it != produk.end()) {
                cout << it->get_ID() << "\t| " << it->get_nama() << "\t| " << it->get_kategori() << "\t| " << it->get_harga() << "\t\t|" << endl; // Menampilkan data

                it++; // Melanjutkan iterasi dari List
            }

            // Print table footer
            cout << "---------------------------------------------------------" << endl;
            cout << endl;
        } else if (option == 3) {                   // Memperbarui data dari produk
            cin >> ID >> nama >> kategori >> harga; // Memasukkan ID produk yang ingin diubah, beserta hasil perubahannya
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

            if (loop == true) {
                cout << "No matching ID was found" << endl;
            } else {
                cout << "Data updated successfully" << endl;
            }
        } else if (option == 4) { // Menghapus sebuah data dari List produk
            cin >> ID;            // Memasukkan ID produk yang ingin dihapus
            while (it != produk.end() && loop == true) {
                if (it->get_ID() == ID) {  // ketika ID ditemukan
                    it = produk.erase(it); // Menghapus data produk
                    loop = false;          // mengeluarkan dari perulangan
                } else {
                    it++; // Mengiterasikan list
                }
            }

            if (loop == true) {
                cout << "No matching ID was found" << endl;
            } else {
                cout << "Data erased successfully" << endl;
            }
        } else if (option == 5) { // Mencari data sesuai nama produk
            cin >> nama;          // memasukkan nama produk yang ingin dicari
            while (it != produk.end() && loop == true) {
                if (it->get_nama() == nama) {                                                                                     // ketika nama produk ditemukan
                    cout << it->get_ID() << " " << it->get_nama() << " " << it->get_kategori() << " " << it->get_harga() << endl; // tampilkan produk tersebut
                    loop = false;                                                                                                 // mengeluarkan dari perulangan
                } else {
                    it++; // Mengiterasikan list
                }
            }

            if (loop == true) {
                cout << "No matching name was found" << endl;
            } else {
                cout << "Data found" << endl;
            }
        } else if (option == 6) { // Exit dari program
            exit = true;          // merubah state dari false menjadi true
        }
    }

    return 0;
}
