

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Encrypt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("text").addEventListener("input", function() {
                if (this.value.length > 0) {
                    document.getElementById("file").disabled = true;
                } else {
                    document.getElementById("file").disabled = false;
                }
            });

            document.getElementById("file").addEventListener("change", function() {
                if (this.files.length > 0) {
                    document.getElementById("text").disabled = true;
                } else {
                    document.getElementById("text").disabled = false;
                }
            });
        });
    </script>
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
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">Encrypt</button>
                <a href="{{ route('text.view') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">Back to Menu</a>
            </form>
        </div>
    </div>
</body>
</html>
