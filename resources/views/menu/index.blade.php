@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling Content */
        .content {
            margin-left: 270px;
            margin-top: 20px;
            padding: 20px;
            position: relative;
            background-color: #DEEFFE;
        }

        .content h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            display: inline-block;
        }

        .add-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #1e3a8a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .add-button:hover {
            background-color: #3b82f6;
        }

        /* Search Form */
        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            position: relative;
        }

        .search-form input[type="text"] {
            padding: 10px 40px;
            width: 100%;
            max-width: 1200px;
            border: 2px solid #ccc;
            border-radius: 25px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-form input[type="text"]:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            font-size: 18px;
            color: #666;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
            border: 5px solid #3b82f6;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #1e3a8a;
            color: #fff;
            text-align: center;
        }

        td {
            text-align: center;
        }

        .action-icons a {
            color: #1e3a8a;
            margin: 0 5px;
            font-size: 18px;
            text-decoration: none;
        }

        .action-icons a:hover {
            color: #3b82f6;
        }

        .empty-message {
            text-align: center;
            font-size: 16px;
            color: #1e3a8a;
            font-weight: bold;
        }

        /* Styling untuk gambar di tabel */
        .menu-image {
            display: block;
            /* Untuk memastikan gambar diposisikan sebagai block element */
            margin: 0 auto;
            /* Membuat gambar center */
            max-width: 120px;
            /* Ukuran maksimal gambar (ubah sesuai kebutuhan) */
            height: auto;
            /* Agar rasio gambar tetap terjaga */
            border-radius: 5px;
            /* Opsional, memberikan border melengkung */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Opsional, menambahkan bayangan */
        }
    </style>
</head>

<body>
    <!-- Content -->
    <div class="content">
        <h1>Menu</h1>
        <a href="{{ route('menu.create') }}" class="add-button">TAMBAH</a>

        <!-- Search Form -->
        <form action="{{ url('/menu') }}" method="GET" class="search-form" id="searchForm">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ..." id="searchInput"
                aria-label="Search">
        </form>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Gambar</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menu as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_menu }}</td>
                        <td>
                            @if ($item->gambar_menu)
                            <img src="{{ asset('img/' . $item->gambar_menu) }}" alt="Gambar Menu" class="menu-image">
                                 
                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td>{{ $item->jenis_menu }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="action-icons">
                            <a href="{{ route('menu.edit', $item->id_menu) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('menu.show', $item->id_menu) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('menu.destroy', $item->id_menu) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-0"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')"
                                    style="font-size: 20px; color: #1e3a8a; border:none; background:none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-message">Tidak ada menu yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }

        // JavaScript for real-time search with debounce
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        searchInput.addEventListener('keyup', debounce(function() {
            searchForm.submit();
        }, 500));
    </script>
</body>

</html>
