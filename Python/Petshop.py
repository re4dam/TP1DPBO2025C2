class Petshop:
    # private attribute for Petshop
    __ID = ""
    __nama = ""
    __kategori = ""
    __harga = 0

    def __init__(self, input_id="", input_nama="", input_kategori="", input_harga=0):
        self.__ID = input_id  # Private attribute
        self.__nama = input_nama  # Private attribute
        self.__kategori = input_kategori  # Private attribute
        self.__harga = input_harga  # Private attribute

    # Metode untuk mengambil/mengatur ID
    def get_ID(self):
        return self.__ID

    def set_ID(self, input_id):
        self.__ID = input_id

    # Metode untuk mengambil/mengatur nama
    def get_nama(self):
        return self.__nama

    def set_nama(self, input_nama):
        self.__nama = input_nama

    # Metode untuk mengambil/mengatur kategori
    def get_kategori(self):
        return self.__kategori

    def set_kategori(self, input_kategori):
        self.__kategori = input_kategori

    # Metode untuk mengambil/mengatur harga
    def get_harga(self):
        return self.__harga

    def set_harga(self, input_harga):
        if (
            isinstance(input_harga, int) and input_harga >= 0
        ):  # input_harga diperiksa apakah integer dan lebih dari sama dengan 0
            self.__harga = input_harga
        else:  # jika tidak maka output error
            raise ValueError("Harga must be a non-negative integer.")
