<!DOCTYPE html>
<html lang="en">
@include("head")
<body>
<!--
// v0 by Vercel.
// https://v0.dev/r/zFxb4cOXU4B
-->

<div class="flex flex-col min-h-screen">
	@include("header")
	<form method="post" action="/video/encrypt" enctype="multipart/form-data" id="form"
	>
		@csrf
		<main class="flex-1 py-12 px-4 md:px-6 bg-gray-100">

			<div class="max-w-6xl mx-auto grid gap-10 md:grid-cols-1">
				<div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
					<div class="flex flex-col space-y-1.5 p-6">
						<h3 class="whitespace-nowrap tracking-tight text-2xl font-semibold">Video Decryption</h3>
						<p class="text-sm text-muted-foreground">Choose to upload a video for
							Decryption.</p>
					</div>
					<div class="p-6">
						<div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
							<div
								class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
									 fill="none"
									 stroke="currentColor" stroke-width="2" stroke-linecap="round"
									 stroke-linejoin="round"
									 class="lucide lucide-key-round">
									<path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"/>
									<circle cx="16.5" cy="7.5" r=".5"/>
								</svg>
								<label for="key"
									   class="text-lg">Input a 16-character key you used for the encryption
									process.</label>
								<input
									type="text"
									name="key"
									maxlength="16"
									id="key"
									class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip"
									placeholder="Enter key here"
									required
									onkeyup="checkKeyLength()"
								/>
								{{--								<span class="cursor-pointer hover:underline select-none" onclick="generateKey()">Generate</span>--}}
							</div>
							<div
								class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="24"
									height="24"
									viewBox="0 0 24 24"
									fill="none"
									stroke="currentColor"
									stroke-width="2"
									stroke-linecap="round"
									stroke-linejoin="round"
									class="h-12 w-12"
								>
									<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
									<polyline points="17 8 12 3 7 8"></polyline>
									<line x1="12" x2="12" y1="3" y2="15"></line>
								</svg>
								<label class="text-lg">Select a video file from your device.</label>

								<input
									accept="video/mp4 video/webm"
									type="file"
									name="video"
									id="video"
									required
									disabled
									onchange="submitForm()"
									class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 overflow-clip"
								/>
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
    const recorderContainer = document.getElementById('recorder-container');
    const recordingSubmitBtn = document.getElementById('recording-submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const keyInput = document.getElementById('key');
    const videoInput = document.getElementById('video');
    let recording = false;

    function submitForm() {
        if (keyInput.value.length !== 16) {
            alert("Key must be 16 characters long.");
            return;
        }
        showSubmitting();
        submitting.classList.remove('hidden');
        submitting.classList.add('block');
        cancelRecordVideo();
        form.submit();
    }

    function checkKeyLength() {
        videoInput.disabled = keyInput.value.length !== 16;
    }

    function showSubmitting() {
        submitting.classList.remove('hidden');
        submitting.classList.add('block')
    }

    function cancelRecordVideo() {
        if (!recording) {
            recorderContainer.classList.remove('flex');
            recorderContainer.classList.add('hidden')
            player.srcObject = null;
            player.src = null;
            cancelBtn.classList.remove("hidden");
            recordingSubmitBtn.classList.add("hidden");
        }
    }

</script>
</body>
</html>