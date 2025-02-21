import java.util.ArrayList;
import java.util.Iterator;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        ArrayList<Petshop> produk = new ArrayList<>(); // Array List untuk produk petshop
        boolean exit = false; // Status perulangan
        Scanner scanner = new Scanner(System.in); // Scanner untuk input user
        String ID, nama, kategori; // String temporary untuk input
        int harga; // integer temporary untuk input

        while (!exit) { // while exit is not false
            // Tampilkan pilihan menu
            System.out.println("Opsi Menu");
            System.out.println("1. Add product");
            System.out.println("2. Show products");
            System.out.println("3. Update product");
            System.out.println("4. Delete product");
            System.out.println("5. Find product by name");
            System.out.println("6. Exit");
            System.out.println();

            int option = scanner.nextInt(); // Input opsi menu
            scanner.nextLine(); // Membersihkan newline setelah nextInt()
            Iterator<Petshop> iterator = produk.iterator(); // Iterator untuk perulangan Array

            if (option == 1) { // Menambahkan produk
                System.out.print("Masukkan ID: ");
                ID = scanner.nextLine(); // masukkan ID produk
                System.out.print("Masukkan Nama: ");
                nama = scanner.nextLine(); // masukkan nama produk
                System.out.print("Masukkan Kategori: ");
                kategori = scanner.nextLine(); // masukkan kategori produk
                System.out.print("Masukkan Harga: ");
                harga = scanner.nextInt(); // masukkan harga produk
                scanner.nextLine(); // Membersihkan newline setelah nextInt()

                boolean idExists = false;
                // perulangan hingga ditemukan ID yang sama
                for (Petshop p : produk) {
                    if (p.get_ID().equals(ID)) {
                        idExists = true;
                    }
                }

                if (!idExists) { // jika ID tidak ditemukan
                    Petshop input = new Petshop(ID, nama, kategori, harga); // instansiasi objek
                    produk.add(input); // masukkan objek ke dalam ArrayList
                    System.out.println("ADD product successful");
                } else { // jika ID ditemukan
                    System.out.println("ID product already exists, please use a new ID");
                }
            } else if (option == 2) { // Menampilkan semua produk
                // For each untuk menampilkan semua produk yang ada
                for (Petshop p : produk) {
                    System.out.println(p.get_ID() + " " + p.get_Nama() + " " + p.get_Kategori() + " "
                            + p.get_Harga());
                }

                System.out.println(); // print new line
            } else if (option == 3) { // Memperbarui produk
                System.out.print("Masukkan ID produk yang ingin diupdate: ");
                ID = scanner.nextLine(); // masukkan ID untuk diupdate
                System.out.print("Masukkan Nama baru: ");
                nama = scanner.nextLine(); // masukkan nama baru
                System.out.print("Masukkan Kategori baru: ");
                kategori = scanner.nextLine(); // masukkan kategori baru
                System.out.print("Masukkan Harga baru: ");
                harga = scanner.nextInt(); // masukkan harga baru
                scanner.nextLine(); // Membersihkan newline setelah nextInt()

                boolean found = false;
                // perulangan hingga ID ditemukan
                while (iterator.hasNext() && found == false) {
                    Petshop p = iterator.next(); // mengakses objek dari ArrayList
                    if (p.get_ID().equals(ID)) { // ketika ID ditemukan
                        // mengatur/mengupdate atribut objek dengan data yang baru
                        p.set_Nama(nama);
                        p.set_Kategori(kategori);
                        p.set_Harga(harga);
                        found = true; // keluar dari perulangan
                    }
                }

                if (found) { // ketika ditemukan, keluarkan pesan berhasil
                    System.out.println("Data updated successfully");
                } else { // ketika tidak, keluarkan pesan gagal
                    System.out.println("No matching ID was found");
                }
            } else if (option == 4) { // Menghapus produk
                System.out.print("Masukkan ID produk yang ingin dihapus: ");
                ID = scanner.nextLine(); // masukkan produk untuk dihapus

                boolean found = false;
                // perulangan hingga ID ditemukan
                while (iterator.hasNext() && found == false) {
                    Petshop p = iterator.next(); // mengakses objek dari ArrayList
                    if (p.get_ID().equals(ID)) { // ketika ID ditemukan
                        iterator.remove(); // menghapus objek yang ditunjuk oleh iterator
                        found = true; // keluar dari perulangan
                    }
                }

                if (found) { // ketika ditemukan, keluarkan pesan berhasil
                    System.out.println("Data erased successfully");
                } else { // ketika tidak ditemukan, keluarkan pesan gagal
                    System.out.println("No matching ID was found");
                }
            } else if (option == 5) { // Mencari produk berdasarkan nama
                System.out.print("Masukkan nama produk yang ingin dicari: ");
                nama = scanner.nextLine(); // Masukkan nama produk untuk dicari

                boolean found = false;
                // bikin perulangan untuk mencari dengan nama yang diminta
                for (Petshop p : produk) {
                    if (p.get_Nama().equals(nama)) {
                        System.out.println(
                                p.get_ID() + " " + p.get_Nama() + " " + p.get_Kategori() + " " + p.get_Harga());
                        found = true;
                    }
                }

                if (!found) { // selama perulangan tidak ditemukan data satupun
                    System.out.println("No matching name was found");
                } else { // selama perulangan setidaknya satu ditemukan maka berhasil
                    System.out.println("Data found");
                }
            } else if (option == 6) { // Keluar dari program
                exit = true;
                System.out.println("Exiting program...");
            } else { // ketika perintah selain dari menu
                System.out.println("Invalid option, please try again.");
            }
        }

        scanner.close();
    }
}
