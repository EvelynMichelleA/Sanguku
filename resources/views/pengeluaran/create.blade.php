<form action="{{ route('pengeluaran.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ auth()->user()->id }}"> <!-- ID user -->
    <div class="form-group">
        <label for="nama_pengeluaran">Nama Pengeluaran</label>
        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="total_pengeluaran">Total Pengeluaran</label>
        <input type="number" name="total_pengeluaran" id="total_pengeluaran" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="tanggal_pengeluaran">Tanggal Pengeluaran</label>
        <input type="date" name="tanggal_pengeluaran" id="tanggal_pengeluaran" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="keterangan_pengeluaran">Keterangan</label>
        <textarea name="keterangan_pengeluaran" id="keterangan_pengeluaran" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
