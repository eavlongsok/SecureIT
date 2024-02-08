<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Encryption/Decryption</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Header Start -->
    <header class="flex items-center justify-center h-16 px-4 md:px-6 bg-gray-800 text-white">
        <a class="flex items-center gap-2" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span class="text-3xl font-bold tracking-tighter">SecureIT</span>
        </a>
    </header>
    <!-- Header End -->
    <div class="flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <h1 class="text-2xl font-bold mb-4">Image Cryptography</h1>
        <div class="flex flex-col space-y-4">
            <a href="{{ route('image.encrypt.form') }}" class="bg-black text-white py-2 px-4 rounded-md shadow-md text-center hover:bg-gray-800 hover:text-white transition duration-300">Encryption</a>
            <a href="{{ route('image.decrypt.form') }}" class="bg-black text-white py-2 px-4 rounded-md shadow-md text-center hover:bg-gray-800 hover:text-white transition duration-300">Decryption</a>
        </div>
    </div>
</body>
</html>
