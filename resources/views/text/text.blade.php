<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Encryption/Decryption</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <h1 class="text-2xl font-bold mb-4">Text Cryptography</h1>
        <div class="flex flex-col space-y-4">
            <a href="{{ route('encrypt.form') }}" class="bg-black text-white py-2 px-4 rounded-md shadow-md text-center hover:bg-gray-800 hover:text-white transition duration-300">Encryption</a>
            <a href="{{ route('decrypt.form') }}" class="bg-black text-white py-2 px-4 rounded-md shadow-md text-center hover:bg-gray-800 hover:text-white transition duration-300">Decryption</a>
        </div>
    </div>
</body>
</html>
