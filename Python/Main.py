from Petshop import Petshop

state = True
products = []

while state:
    print("Select Options")
    print("1. Add product")
    print("2. Show products")
    print("3. Update product")
    print("4. Delete product")
    print("5. Find product by name")
    print("6. Exit")
    print()

    option = int(input())

    if option == 1:
        input_id = input("Masukkan ID: ")
        input_nama = input("Masukkan nama: ")
        input_kategori = input("Masukkan kategori: ")
        try:
            input_harga = int(input("Masukkan harga: "))
        except ValueError:
            print("Harga haruslah sebuah angka. Input ulang")
            continue

        id_exists = any(product.get_ID() == input_id for product in products)
        if id_exists:
            print("ID sudah digunakan. Gunakan ID lain")
        else:
            new_product = Petshop(input_id, input_nama, input_kategori, input_harga)
            products.append(new_product)
            print("Product berhasil ditambahkan")
    elif option == 2:
        if not products:
            print("Tidak ada produk")
        else:
            print("Produk-Produk")
            for product in products:
                print(
                    product.get_ID()
                    + product.get_nama()
                    + product.get_kategori()
                    + product.get_harga()
                )
            print()
    elif option == 3:
        input_id = input("Masukkan ID untuk diupdate: ")
        found = False
        index = 0
        while not found and index < len(products):
            if products[index].get_ID() == input_id:
                new_nama = input("Masukkan Nama baru: ")
                new_kategori = input("Masukkan Kategori baru: ")
                try:
                    new_harga = int(input("Masukkan Harga baru: "))
                except ValueError:
                    print("Harga harus berupa angka. Silakan coba lagi.")
                    continue

                products[index].set_nama(new_nama)
                products[index].set_kategori(new_kategori)
                products[index].set_harga(new_harga)
                print("Produk berhasil diupdate.")
                found = True
            else:
                index += 1

        if not found:
            print("ID tidak ditemukan. Silakan coba lagi.")
    elif option == 4:
        input_id = input("Masukkan ID untuk dihapus: ")
        found = False
        index = 0
        while not found and index < len(products):
            if products[index].get_ID() == input_id:
                products.pop(index)
                found = True
            else:
                index += 1
    elif option == 5:
        input_nama = input("Masukkan nama untuk dicari: ")
        found = False
        index = 0
        for product in products:
            if product.get_nama() == input_nama:
                print(
                    product.get_ID()
                    + product.get_nama()
                    + product.get_kategori()
                    + product.get_harga()
                )
                found = True
            print()
        if not found:
            print("Produk dengan nama tersebut tidak ditemukan")
    elif option == 6:
        state = False
    else:
        print("Permintaan tidak dikenal, ulangi kembali")
