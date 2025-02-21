# import class terlebih dahulu
from Petshop import Petshop

state = True  # kondisi perulangan
products = []  # membuat List kosong

while state:
    # Mengeluarkan opsi opsi untuk diambil
    print("Select Options")
    print("1. Add product")
    print("2. Show products")
    print("3. Update product")
    print("4. Delete product")
    print("5. Find product by name")
    print("6. Exit")
    print()

    option = int(input("Opsi apa yang ingin diambil: "))  # memilih opsi yang dijalankan
    index = 0  # index List
    found = False  # condition found or not

    if option == 1:  # opsi Add
        input_id = input("Masukkan ID: ")  # masukin ID
        input_nama = input("Masukkan nama: ")  # masukin nama
        input_kategori = input("Masukkan kategori: ")  # masukin kategori
        # masukin harga produk
        try:
            input_harga = int(input("Masukkan harga: "))  # masukin harga dulu
        except ValueError:  # kalo gak sesuai beri peringatan Error
            print("Harga haruslah sebuah angka. Input ulang")
            continue  # ulangin perintahnya

        # periksa ID digunakan tidak
        id_exists = any(product.get_ID() == input_id for product in products)
        if id_exists:  # kasus jika ID sudah ada
            print("ID sudah digunakan. Gunakan ID lain")
        else:  # kasus berhasil
            new_product = Petshop(
                input_id, input_nama, input_kategori, input_harga
            )  # instansiasi objek
            products.append(new_product)  # tambahkan ke dalam List
            print("Product berhasil ditambahkan")  # message success
            print()
    elif option == 2:  # opsi tampilkan
        if not products:  # posisi kosong
            print("Tidak ada produk")
        else:  # ada produknya
            print("Produk-Produk")
            # foreach untuk menampilkan produk produk
            for product in products:
                print(
                    product.get_ID()
                    + " "
                    + product.get_nama()
                    + " "
                    + product.get_kategori()
                    + " "
                    + str(product.get_harga())
                )
            print()
    elif option == 3:  # opsi update
        input_id = input("Masukkan ID untuk diupdate: ")  # masukkan ID ingin diupdate
        while not found and index < len(products):
            if products[index].get_ID() == input_id:
                # memasukkan data-data baru
                new_nama = input("Masukkan Nama baru: ")
                new_kategori = input("Masukkan Kategori baru: ")
                try:
                    new_harga = int(input("Masukkan Harga baru: "))
                except ValueError:
                    print("Harga harus berupa angka. Silakan coba lagi.")
                    continue

                # mengatur setiap atribut dari objek
                products[index].set_nama(new_nama)
                products[index].set_kategori(new_kategori)
                products[index].set_harga(new_harga)
                print("Produk berhasil diupdate.")
                found = True  # keluar dari while loop
            else:
                index += 1  # iterator

        if not found:  # jikalau tidak ditemukan
            print("ID tidak ditemukan. Silakan coba lagi.")
    elif option == 4:  # opsi menghapus
        input_id = input("Masukkan ID untuk dihapus: ")  # masukkan ID untuk dihapus
        while not found and index < len(products):
            if products[index].get_ID() == input_id:
                # melakukan pop/menghapus index
                products.pop(index)
                found = True  # keluar dari while loop
                print("Produk berhasil dihapus")
            else:
                index += 1  # iterator

        if not found:
            print("Produk tidak ditemukan")
    elif option == 5:  # opsi mencari dengan nama
        input_nama = input("Masukkan nama untuk dicari: ")  # masukkan nama untuk dicari
        # foreach untuk menampilkan semua dengan nama yang dicari
        for product in products:
            if product.get_nama() == input_nama:  # tampilkan nama yang sama
                print(
                    product.get_ID()
                    + " "
                    + product.get_nama()
                    + " "
                    + product.get_kategori()
                    + " "
                    + str(product.get_harga())
                )
                found = True
        print()
        if not found:
            print("Produk dengan nama tersebut tidak ditemukan")
    elif option == 6:  # keluar dari program
        state = False
    else:
        print("Permintaan tidak dikenal, ulangi kembali")
