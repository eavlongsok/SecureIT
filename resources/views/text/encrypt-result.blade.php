<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encrypted Result</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
            <h1 class="text-xl font-bold mb-4">Encrypted Text Result</h1>
            <div class="bg-gray-100 p-4 rounded border border-gray-300">
                <h4 class="text-lg font-medium mb-2">Encrypted Text:</h4>
                <p class="text-gray-600 break-words">{{ $encryptedText }}</p>
            </div>
            <a href="{{ route('text.view') }}" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">Menu</a>
            <a href="{{ route('encrypt.form') }}" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">Back to Encrypt</a>
            <a href="{{ route('decrypt.result') }}" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">Go to Decrypt</a>
        </div>
    </div>
</body>
</html>
