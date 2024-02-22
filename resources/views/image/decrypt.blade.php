<!DOCTYPE html>
<html lang="en">
@include("head")

<body>
    <div class="flex flex-col min-h-screen">
        @include("header")
        <form method="post" action="/image/decrypt" enctype="multipart/form-data" id="form">
            @csrf
            <main class="flex-1 py-12 px-4 md:px-6 bg-gray-100">
                <div class="max-w-6xl mx-auto grid gap-10 md:grid-cols-1">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap tracking-tight text-2xl font-semibold">Image Decryption</h3>
                            <p class="text-sm text-muted-foreground">Choose to upload an image or capture a new one for decryption.</p>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-key-round">
                                        <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
                                        <circle cx="16.5" cy="7.5" r=".5" />
                                    </svg>
                                    <span class="text-lg">Input a 16-character key for decryption</span>
                                    <input type="text" name="key" maxlength="16" id="key" class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip" placeholder="Enter key here" required onkeyup="checkKeyLength()" />
                                    <!-- <span class="cursor-pointer hover:underline select-none"
                                        onclick="generateKey()">Generate</span> -->
                                </div>

                                <!-- Image Input Section -->
                                <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-12 w-12">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="11 3 11 11 14 8 17 11 17 3"></polyline>
                                    </svg>
                                    <label class="text-lg">Select a video file from your device.</label>

                                    <input accept="image/png image/jpg " type="file" name="image" id="image" required onchange="submitForm()" class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 overflow-clip " />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="font-bold text-2xl text-center mt-6 hidden" id="submitting">Submitting...
            </main>
        </form>
    </div>

    <script>
        const player = document.getElementById('player');
        const submitting = document.getElementById('submitting');
        const form = document.getElementById('form');
        const imageInput = document.getElementById('image');
        const recordingSubmitBtn = document.getElementById('recording-submit-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const keyInput = document.getElementById('key');
        const recordBtn = document.getElementById('recordBtn');
        let recording = false;
        const recorderContainer = document.getElementById('recorder-container'); // Define recorderContainer


        async function submitForm() {
            if (keyInput.value.length !== 16) {
                alert("Key must be 16 characters long.");
                return;
            }
            showSubmitting();

            form.submit();
        }


        function checkKeyLength() {
            videoInput.disabled = keyInput.value.length !== 16;
            recordBtn.disabled = keyInput.value.length !== 16;
        }

        function showSubmitting() {
            submitting.classList.remove('hidden');
            submitting.classList.add('block');
        }

        function showTakeImage() {
            recorderContainer.classList.remove('hidden');
            recorderContainer.classList.add('flex');
        }

        function showSubmitting() {
            submitting.classList.remove('hidden');
            submitting.classList.add('block')
        }

    </script>
</body>

</html>
