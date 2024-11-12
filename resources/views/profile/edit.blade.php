<x-slot name="header">
    <h2 class="font-semibold text-xl text-blue-900 leading-tight">
        {{ __('Profile') }}
    </h2>
</x-slot>

<style>
    /* Font Poppins untuk seluruh form */
    body, input, select, label, button, a {
        font-family: 'Poppins', sans-serif;
    }

    /* Halaman Form Background */
    .form-page {
        padding: 20px;
        background-color: #f8fafc; /* Latar belakang abu terang */
        min-height: 100vh;
    }

    /* Card Styling */
    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Header Form */
    .form-header {
        font-size: 20px;
        font-weight: bold;
        color: #1e3a8a;
        margin-bottom: 20px;
    }

    /* Styling Input */
    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-bottom: 15px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #3b82f6; /* Border biru saat fokus */
        outline: none;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); /* Shadow fokus */
    }

    /* Button Styling */
    .button-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .submit-button {
        padding: 10px 20px;
        background-color: #1e3a8a;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: #3b82f6; /* Warna hover */
    }

    /* Success Message Styling */
    .success-message {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Label Styling */
    label {
        font-weight: bold;
        color: #1e3a8a;
        display: block;
        margin-bottom: 5px;
    }
</style>

<div class="form-page">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Update Profile Information -->
        <div class="card">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
