@extends('layouts.app')

@section('content')
    <style>
        /* Font Poppins untuk seluruh form */
        body,
        input,
        select,
        label,
        button,
        a {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling Error Message */
        .text-danger {
            color: red;
            /* Warna merah untuk error */
            font-size: 12px;
            /* Ukuran teks error */
        }

        /* Submit Button */
        .submit-button {
            padding: 10px 20px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Smooth transition untuk hover */
        }

        .submit-button:hover {
            background-color: #3b82f6;
            /* Warna hover */
        }

        /* Cancel Button */
        .cancel-button {
            padding: 10px 20px;
            background-color: #d1d5db;
            color: #374151;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.3s ease;
            /* Smooth transition */
        }

        .cancel-button:hover {
            background-color: #e5e7eb;
            /* Warna hover untuk tombol batal */
        }

        /* Styling Input */
        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #3b82f6;
            /* Border biru saat fokus */
            outline: none;
        }

        /* Label Styling */
        label {
            font-weight: bold;
            color: #1e3a8a;
            display: block;
            margin-bottom: 5px;
        }

        /* Preview Container Styling */
        .preview-container {
            margin-top: 15px;
        }

        .preview-title {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .preview-image {
            max-width: 40%;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>

    <div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
        <div
            style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
            <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Menu
                &gt;&gt; Update Menu</h2>

            <form action="{{ route('menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Menu -->
                <div style="margin-bottom: 15px;">
                    <label for="nama_menu">Nama Menu</label>
                    <input type="text" id="nama_menu" name="nama_menu" placeholder="Nama Menu ..."
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;"
                        value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                    @error('nama_menu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Jenis Menu -->
                <div style="margin-bottom: 15px;">
                    <label for="jenis_menu">Jenis</label>
                    <select id="jenis_menu" name="jenis_menu" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
                        <option value="Makanan" {{ $menu->jenis_menu == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ $menu->jenis_menu == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Snack" {{ $menu->jenis_menu == 'Snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                <!-- Harga -->
                <div style="margin-bottom: 15px;">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" placeholder="Harga ..."
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;"
                        value="{{ old('harga', $menu->harga) }}" required>
                    @error('harga')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Upload Image -->
                <div style="margin-bottom: 15px;">
                    <label for="gambar_menu">Upload Image</label>
                    <input type="file" id="gambar_menu" name="gambar_menu" onchange="previewImage(event)"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
                    @error('gambar_menu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <!-- Preview Container -->
                    <div id="preview-container" class="preview-container">
                        @if ($menu->gambar_menu)
                            <p class="preview-title">Gambar Saat Ini:</p>
                            <img src="{{ asset('img/' . $menu->gambar_menu) }}" alt="Current Image" class="preview-image">
                        @endif

                        <p class="preview-title" id="uploadedImageTitle" style="display: none;">Gambar yang Diunggah:</p>
                        <img id="newImagePreview" class="preview-image" style="display: none;">
                    </div>
                </div>

                <!-- Buttons -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 10px;">
                    <a href="{{ route('menu.index') }}" class="cancel-button" style="margin-right: 10px;">Batalkan</a>
                    <button type="submit" class="submit-button">Update Menu</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const newImage = document.getElementById('newImagePreview');
            const uploadedImageTitle = document.getElementById('uploadedImageTitle');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // Tampilkan gambar yang diunggah setelah file dimuat
                reader.onload = function(e) {
                    newImage.src = e.target.result;
                    newImage.style.display = 'block'; // Tampilkan gambar
                    uploadedImageTitle.style.display = 'block'; // Tampilkan judul
                };

                reader.readAsDataURL(input.files[0]); // Membaca file
            } else {
                newImage.style.display = 'none'; // Sembunyikan gambar jika file dihapus
                uploadedImageTitle.style.display = 'none'; // Sembunyikan judul
            }
        }
    </script>
@endsection
