<!DOCTYPE html>
<html lang="en">
@include("head")
<body>
    <div class="flex flex-col min-h-screen">
        @include("header")
        <form method="post" action="/text/encrypt" enctype="multipart/form-data" id="form">
            @csrf
            <main class="flex-1 py-12 px-4 md:px-6 bg-gray-100">
                <div class="max-w-6xl mx-auto grid gap-10 md:grid-cols-1">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap tracking-tight text-2xl font-semibold">Text Encryption</h3>
                            <p class="text-sm text-muted-foreground">Enter text for encryption.</p>
                        </div>
                        @if ($errors->any())
                        <div class="text-red-700 font-bold px-6">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="p-6">
                            <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
                                <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                                    <span class="text-lg">Input a 16-character key for encryption and decryption.</span>
                                    <input type="text" name="key" maxlength="16" id="key" class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip" placeholder="Enter key here" required onkeyup="checkKeyLength()" />
                                    <span class="cursor-pointer hover:underline select-none" onclick="generateKey()">Generate</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                                    <span class="text-lg">Enter text to encrypt.</span>
                                    <textarea name="text" id="text" class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip" placeholder="Enter text here"></textarea>
                                </div>
                                <!-- <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                                    <span class="text-lg">Or import a text file.</span>
                                    <input type="file" name="textFile" id="textFile" accept=".txt,.csv,.doc,.docx" class="ml-auto w-[20rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip" onchange="toggleInputDisabled('file')">
                                </div> -->
                                <div class="space-y-4">
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">
                                        Encrypt
                                    </button>
                                    <a href="{{ route('text.view') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800">
                                        Back to Menu
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="font-bold text-2xl text-center mt-6 hidden" id="submitting">Submitting...</p>
            </main>
        </form>
    </div>

    <script>
        const keyInput = document.getElementById('key');
        const textArea = document.getElementById('text');
        // const textFile = document.getElementById('textFile');
        const form = document.getElementById('form');

        function generateKey() {
            let key = "";
            let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-:/?,.+=!@#$%^&*(){}[]|";
            for (let i = 0; i < 16; i++) {
                key += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            keyInput.value = key;
            navigator.clipboard.writeText(key);
            checkKeyLength();
        }

        function checkKeyLength() {
            // Adjusted to consider both inputs
            const isDisabled = keyInput.value.length !== 16;
            textArea.disabled = isDisabled;
        }

        // function toggleInputDisabled(inputType) {
        //     if (inputType === 'text' && textArea.value.length > 0) {
        //         textFile.disabled = true;
        //     } else if (inputType === 'file' && textFile.value.length > 0) {
        //         textArea.disabled = true;
        //     } else {
        //         textFile.disabled = false;
        //         textArea.disabled = false;
        //     }
        // }

    </script>
</body>
</html>
