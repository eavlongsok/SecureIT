<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Encrypt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
            <h1 class="text-xl font-bold mb-4">Text Encryption</h1>
            <form action="{{ route('encrypt.text') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="encryptionKey" class="block text-sm font-medium text-gray-700">Encryption Key:</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" id="encryptionKey" name="encryptionKey" required>
                </div>
                <div>
                    <label for="text" class="block text-sm font-medium text-gray-700">Text to encrypt:</label>
                    <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" id="text" name="text" rows="3" required></textarea>
                </div>
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Or Upload File (TXT only):</label>
                    <input type="file" class="mt-1 block w-full" id="file" name="file" accept=".txt">
                </div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">encrypt</button>
            </form>
        </div>
    </div>
</body>
</html>
