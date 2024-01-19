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
						<h3 class="whitespace-nowrap tracking-tight text-2xl font-semibold">Video Encryption</h3>
						<p class="text-sm text-muted-foreground">Choose to upload a video or record a new one for
							encryption.</p>
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
								<span class="text-lg">Input a 16-character key for encryption and decryption.</span>
								<input
									type="text"
									name="key"
									maxlength="16"
									id="key"
									class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 px-4 border-2 focus:outline-1 focus:outline-gray-300 overflow-clip"
									placeholder="Enter key here"
									required
								/>
								<span class="cursor-pointer hover:underline select-none" onclick="generateKey()">Generate</span>
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
								<span class="text-lg">Select a video file from your device.</span>

								<input
									accept="video/mp4 video/webm"
									type="file"
									name="video"
									id="video"
									required
									onchange="submitForm()"
									class="ml-auto w-[13rem] text-gray-800 font-semibold py-2 overflow-clip"
								/>
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
									<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
									<polyline points="11 3 11 11 14 8 17 11 17 3"></polyline>
								</svg>
								<span class="text-lg">Record a new video (max 5 seconds).</span>
								<button
									class="ml-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow select-none"
									onclick="showRecordVideo()" type="button"
								>
									Record
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<p class="font-bold text-2xl text-center mt-6 hidden" id="submitting">Submitting...
			<div id="recorder-container"
				 class="fixed hidden top-0 left-0 w-full h-full bg-black bg-opacity-50 z-50 justify-center items-center cursor-pointer"
				 onclick="cancelRecordVideo()">

				<div id="recorder" class="w-5/6 h-5/6 bg-white z-[100] cursor-auto p-4"
					 onclick="preventClickThrough(event)">
					<div class="h-5/6 flex justify-center items-center">
						<video id="player" class="w-2/3 h-full" autoplay muted loop playsinline></video>
					</div>
					<div class="flex justify-center gap-x-10 mt-6">
						<button id="start" type="button"
								class="w-[10rem] py-4 px-2 bg-green-700 text-white text-lg font-semibold rounded-xl shadow select-none"
								onclick="startRecordingVideo()">
							Start
							Recording
						</button>
						<button
							type="button"
							id="stop"
							class="w-[10rem] py-4 px-2 bg-green-700 text-white text-lg font-semibold rounded-xl shadow hidden select-none">
							Stop
							Recording
						</button>
						<button
							id="recording-submit-btn"
							class="w-[10rem] py-4 px-2 bg-blue-700 text-white text-lg font-semibold rounded-xl shadow select-none hidden"
							onclick="submitForm()" type="button">Submit
						</button>
						<button id="cancel-btn"
								class="w-[10rem] py-4 px-2 bg-red-700 text-white text-lg font-semibold rounded-xl shadow select-none"
								onclick="cancelRecordVideo()"
								type="button">Cancel
						</button>
					</div>
				</div>
			</div>
		</main>
	</form>
</div>

<script>
    const player = document.getElementById('player');
    const submitting = document.getElementById('submitting');
    const form = document.getElementById('form');
    const recorderContainer = document.getElementById('recorder-container');
    const videoInput = document.getElementById('video');
    const recordingSubmitBtn = document.getElementById('recording-submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const keyInput = document.getElementById('key');
    let recording = false;

    function generateKey() {
        let key = "";
        let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-:/?,.+=!@#$%^&*(){}[]|";
        for (let i = 0; i < 16; i++) {
            key += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        keyInput.value = key;
    }

    function submitForm() {
        if (key.value.length !== 16) {
            alert("Key must be 16 characters long.");
            return;
        }
        showSubmitting();
        form.submit();
    }

    function showSubmitting() {
        submitting.classList.remove('hidden');
        submitting.classList.add('block')
    }

    function submitForm() {
        form.submit();
        submitting.classList.remove('hidden');
        submitting.classList.add('block');
        cancelRecordVideo();
    }

    function showRecordVideo() {
        recorderContainer.classList.remove('hidden');
        recorderContainer.classList.add('flex')
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

    function preventClickThrough(event) {
        event.stopPropagation();
    }

    function startRecordingVideo() {
        recording = true;
        cancelBtn.classList.add("hidden");
        recordingSubmitBtn.classList.add('hidden');
        // record video
        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        }).then(stream => {
                player.srcObject = stream;
                player.play();
                const recorder = new MediaRecorder(stream);
                const chunks = [];
                recorder.ondataavailable = e => chunks.push(e.data);
                recorder.onstop = e => {
                    const completeBlob = new Blob(chunks, {type: "video/webm"});
                    const completeVideoURL = URL.createObjectURL(completeBlob);
                    player.srcObject = null;
                    player.src = completeVideoURL;
                    player.controls = false;
                    player.muted = true;
                    player.play();
                    let time = new Date().getTime();
                    let file = new File(chunks, "video-" + time + ".webm", {
                        type: "video/webm"
                    });
                    let dataTransfer = new ClipboardEvent('').clipboardData || new DataTransfer();
                    dataTransfer.items.add(file);  // Add the file to the DT object
                    videoInput.files = dataTransfer.files;
                }
                recorder.start();
                document.getElementById('start').classList.add('hidden');
                document.getElementById('stop').classList.remove('hidden');
                const stopVideoRecording = () => {
                    recorder.stop();
                    recording = false
                    cancelBtn.classList.remove("hidden");
                    stream.getTracks().forEach(track => track.stop());
                    recordingSubmitBtn.classList.remove('hidden');
                    document.getElementById('start').classList.remove('hidden');
                    document.getElementById('stop').classList.add('hidden');
                }
                document.getElementById('stop').onclick = stopVideoRecording;

                setTimeout(stopVideoRecording, 5000);
            }
        );
    }
</script>
</body>
</html>