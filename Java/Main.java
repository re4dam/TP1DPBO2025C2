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
                ID = scanner.nextLine();
                System.out.print("Masukkan Nama: ");
                nama = scanner.nextLine();
                System.out.print("Masukkan Kategori: ");
                kategori = scanner.nextLine();
                System.out.print("Masukkan Harga: ");
                harga = scanner.nextInt();
                scanner.nextLine(); // Membersihkan newline setelah nextInt()

                boolean idExists = false;
                for (Petshop p : produk) {
                    if (p.get_ID() == ID) {
                        idExists = true;
                        break;
                    }
                }
                while (iterator.hasNext() && idExists == false) {
                    Petshop p = iterator.next();
                    if (p.get_ID() == ID) {
                        idExists = true;
                    }
                }

                if (!idExists) {
                    Petshop input = new Petshop(ID, nama, kategori, harga);
                    produk.add(input);
                    System.out.println("ADD product successful");
                } else {
                    System.out.println("ID product already exists, please use a new ID");
                }
            } else if (option == 2) { // Menampilkan semua produk
                for (Petshop p : produk) {
                    System.out.println(p.get_ID() + " " + p.get_Nama() + " " + p.get_Kategori() + " "
                            + p.get_Harga());
                }

                System.out.println();
            } else if (option == 3) { // Memperbarui produk
                System.out.print("Masukkan ID produk yang ingin diupdate: ");
                ID = scanner.nextLine();
                System.out.print("Masukkan Nama baru: ");
                nama = scanner.nextLine();
                System.out.print("Masukkan Kategori baru: ");
                kategori = scanner.nextLine();
                System.out.print("Masukkan Harga baru: ");
                harga = scanner.nextInt();
                scanner.nextLine(); // Membersihkan newline setelah nextInt()

                boolean found = false;
                while (iterator.hasNext() && found == false) {
                    Petshop p = iterator.next();
                    if (p.get_ID().equals(ID)) {
                        p.set_Nama(nama);
                        p.set_Kategori(kategori);
                        p.set_Harga(harga);
                        found = true;
                    }
                }

                if (found) {
                    System.out.println("Data updated successfully");
                } else {
                    System.out.println("No matching ID was found");
                }
            } else if (option == 4) { // Menghapus produk
                System.out.print("Masukkan ID produk yang ingin dihapus: ");
                ID = scanner.nextLine();

                boolean found = false;
                while (iterator.hasNext() && found == false) {
                    Petshop p = iterator.next();
                    if (p.get_ID().equals(ID)) {
                        iterator.remove();
                        found = true;
                    }
                }

                if (found) {
                    System.out.println("Data erased successfully");
                } else {
                    System.out.println("No matching ID was found");
                }
            } else if (option == 5) { // Mencari produk berdasarkan nama
                System.out.print("Masukkan nama produk yang ingin dicari: ");
                nama = scanner.nextLine();

                boolean found = false;
                for (Petshop p : produk) {
                    if (p.get_Nama().equals(nama)) {
                        System.out.println(
                                p.get_ID() + " " + p.get_Nama() + " " + p.get_Kategori() + " " + p.get_Harga());
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    System.out.println("No matching name was found");
                } else {
                    System.out.println("Data found");
                }
            } else if (option == 6) { // Keluar dari program
                exit = true;
                System.out.println("Exiting program...");
            } else {
                System.out.println("Invalid option, please try again.");
            }
        }

        scanner.close();
    }
}
