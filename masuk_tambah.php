<div class="card-body">
    <!-- Button Tambah Barang Masuk -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="fas fa-plus"></i> Tambah Barang Masuk
    </button>

    <!-- Modal Form Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="masuk_tambah.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Barang Masuk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_barang" class="form-label">Barang</label>
                            <select name="id_barang" id="id_barang" class="form-select" required>
                                <?php
                                $barang = $conn->query("SELECT id_barang, nama_barang FROM barang");
                                while($b = $barang->fetch_assoc()) {
                                    echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_supplier" class="form-label">Supplier</label>
                            <select name="id_supplier" id="id_supplier" class="form-select" required>
                                <?php
                                $supplier = $conn->query("SELECT id_supplier, nama_supplier FROM supplier");
                                while($s = $supplier->fetch_assoc()) {
                                    echo "<option value='{$s['id_supplier']}'>{$s['nama_supplier']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Barang Masuk -->
    <table id="datatablesSimple" class="table table-bordered">
        <thead>
            <tr>
                <th>ID Masuk</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID Masuk</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_masuk']}</td>
                            <td>{$row['nama_barang']}</td>
                            <td>{$row['nama_supplier']}</td>
                            <td>{$row['jumlah']}</td>
                            <td>{$row['tanggal']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
