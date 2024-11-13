@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan Pengeluaran</h1>
    <form method="GET" action="{{ route('laporan_pengeluaran.index') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="dd/mm/yyyy" value="{{ request()->query('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="dd/mm/yyyy" value="{{ request()->query('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>    

    <a href="{{ route('laporan_pengeluaran.exportPDF') }}" class="btn btn-dark mb-3">Export PDF</a>

    <div id="pengeluaranTable">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Nama Pengeluaran</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengeluaran as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->user->name ?? 'Tidak Ada Data' }}</td>
                    <td>{{ $item->nama_pengeluaran }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengeluaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
</div>

<script>
    function filterData() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate && endDate) {
            const filterUrl = `{{ url('/laporan-pengeluaran/filter') }}/${startDate}/${endDate}`;
            window.location.href = filterUrl;
        } else {
            alert('Mohon isi tanggal mulai dan akhir.');
        }
    }
</script>
@endsection
