@extends('layouts.app');

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
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
            background-color: #1e3a8a;
            /* Warna sama dengan teks "Pengguna" */
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .add-button:hover {
            background-color: #3b82f6;
            /* Warna hover lebih cerah */
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
            /* Tambahkan padding kiri untuk ikon */
            width: 100%;
            max-width: 1200px;
            border: 2px solid #ccc;
            /* Outline lebih tipis dan lebih cerah */
            border-radius: 25px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-form input[type="text"]:focus {
            outline: none;
            border-color: #3b82f6;
            /* Warna outline saat fokus */
        }

        .search-icon {
            position: absolute;
            left: 15px;
            font-size: 18px;
            color: #666;
            /* Warna ikon search */
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
    font-weight: bold;
    color: #1e3a8a;
    padding: 20px;
}

    </style>
</head>

<body>
    <!-- Content -->
    <div class="content">
        <h1>Pengguna</h1>
        <a href="{{ route('pengguna.create') }}" class="add-button">TAMBAH</a>

         <!-- Search Form -->
         <form action="{{ url('/pengguna') }}" method="GET" class="search-form" id="searchForm">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ..." id="searchInput"
                aria-label="Search">
        </form>

        <!-- User Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Pengguna</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role->nama_role ?? 'Tidak ada role' }}</td>
                        <td class="action-icons">
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('pengguna.show', $user->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-0"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                                    style="font-size: 20px; color: #1e3a8a; border:none; background:none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-message">Tidak ada pengguna yang ditemukan.</td>
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
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        searchInput.addEventListener('keyup', debounce(function() {
            searchForm.submit();
        }, 500));
    </script>
</body>

</html>
