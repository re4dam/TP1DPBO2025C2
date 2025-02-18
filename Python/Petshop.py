class Petshop:
    __ID = ""
    __nama = ""
    __kategori = ""
    __harga = 0

    def __init__(self, input_id="", input_nama="", input_kategori="", input_harga=0):
        self.__ID = input_id  # Private attribute
        self.__nama = input_nama  # Private attribute
        self.__kategori = input_kategori  # Private attribute
        self.__harga = input_harga  # Private attribute

    # ID methods
    def get_ID(self):
        return self.__ID

    def set_ID(self, input_id):
        self.__ID = input_id

    # nama methods
    def get_nama(self):
        return self.__nama

    def set_nama(self, input_nama):
        self.__nama = input_nama

    # kategori methods
    def get_kategori(self):
        return self.__kategori

    def set_kategori(self, input_kategori):
        self.__kategori = input_kategori

    # harga methods
    def get_harga(self):
        return self.__harga

    def set_harga(self, input_harga):
        if (
            isinstance(input_harga, int) and input_harga >= 0
        ):  # Validate harga is a non-negative integer
            self.__harga = input_harga
        else:
            raise ValueError("Harga must be a non-negative integer.")
