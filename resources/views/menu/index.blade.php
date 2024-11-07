@extends('layouts.app');
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
            background-color: #3b82f6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        /* Search Form */
        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .search-form input[type="text"] {
            padding: 12px;
            width: 100%;
            max-width: 1200px;
            border: 2px solid #000000;
            border-radius: 25px;
            padding-left: 45px;
            font-size: 16px;
            background-image: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/svgs/solid/search.svg');
            background-size: 20px;
            background-position: 15px center;
            background-repeat: no-repeat;
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
    </style>
</head>

<body>
    <!-- Content -->
    <div class="content">
        <h1>Menu</h1>
        <a href="{{ route('menu.create') }}" class="add-button">TAMBAH</a>

        <!-- Search Form -->
        <form action="{{ url('/menu') }}" method="GET" class="search-form" id="searchForm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ..." id="searchInput">
        </form>

        <!-- Menu Table -->
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
                            <img src="{{ asset('img/' . $item->gambar_menu) }}" alt="Gambar Menu" width="100">

                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td>{{ $item->jenis_menu }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="action-icons">
                            <a href="{{ route('menu.edit', $item->id_menu) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('menu.show', $item->id_menu) }}">
                                <i class="fas fa-eye"></i> <!-- Font Awesome eye icon -->
                            </a>
                            <form action="{{ route('menu.destroy', $item->id_menu) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-0" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')" style=" font-size: 20px; color: #1e3a8a; border:none; background:none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada menu yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        // Debounce function to limit the rate at which a function can fire
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
        }, 500)); // Adjust the delay time (500 milliseconds) as needed
    </script>
</body>

</html>
