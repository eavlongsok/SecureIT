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
	<main class="flex-1 py-6 px-4 md:px-6 bg-gray-100">
		<div class="max-w-6xl mx-auto grid gap-10 md:grid-cols-1">
			<div class="rounded-lg border bg-card text-card-foreground shadow-xl" data-v0-t="card">
				<div class="flex flex-col space-y-1.5 p-6">
					<h3 class="font-semibold tracking-tight text-xl">Encryption Services</h3>
					<p class="text-sm text-muted-foreground">
						Our encryption services allow you to secure your data in various formats. Choose the type of
						data you
						wish to encrypt from the options below.
					</p>
				</div>
				<div class="p-6">
					<div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path d="M17 6.1H3"></path>
								<path d="M21 12.1H3"></path>
								<path d="M15.1 18H3"></path>
							</svg>
							<span>Text Encryption: Secure your written documents and messages.</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path
									d="M17.5 22h.5c.5 0 1-.2 1.4-.6.4-.4.6-.9.6-1.4V7.5L14.5 2H6c-.5 0-1 .2-1.4.6C4.2 3 4 3.5 4 4v3"></path>
								<polyline points="14 2 14 8 20 8"></polyline>
								<path d="M10 20v-1a2 2 0 1 1 4 0v1a2 2 0 1 1-4 0Z"></path>
								<path d="M6 20v-1a2 2 0 1 0-4 0v1a2 2 0 1 0 4 0Z"></path>
								<path d="M2 19v-3a6 6 0 0 1 12 0v3"></path>
							</svg>
							<span>Audio Encryption: Protect your audio files and conversations.</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="/audio/encrypt"
						>
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
								<circle cx="9" cy="9" r="2"></circle>
								<path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
							</svg>
							<span>Image Encryption: Safeguard your images and visual data.</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path d="m22 8-6 4 6 4V8Z"></path>
								<rect width="14" height="12" x="2" y="6" rx="2" ry="2"></rect>
							</svg>
							<span>Video Encryption: Secure your video file and footage.</span>
						</a>
					</div>
				</div>
			</div>
			<div class="rounded-lg border bg-card text-card-foreground shadow-xl" data-v0-t="card">
				<div class="flex flex-col space-y-1.5 p-6">
					<h3 class="font-semibold tracking-tight text-xl">Decryption Services</h3>
					<p class="text-sm text-muted-foreground">Our decryption services allow you to access your encrypted
						data securely. Choose one of the type of data you wish to decrypt from the options below.</p>
				</div>
				<div class="p-6">
					<div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path d="M17 6.1H3"></path>
								<path d="M21 12.1H3"></path>
								<path d="M15.1 18H3"></path>
							</svg>
							<span>Text Decryption: Access your encrypted written documents and messages.</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path
									d="M17.5 22h.5c.5 0 1-.2 1.4-.6.4-.4.6-.9.6-1.4V7.5L14.5 2H6c-.5 0-1 .2-1.4.6C4.2 3 4 3.5 4 4v3"></path>
								<polyline points="14 2 14 8 20 8"></polyline>
								<path d="M10 20v-1a2 2 0 1 1 4 0v1a2 2 0 1 1-4 0Z"></path>
								<path d="M6 20v-1a2 2 0 1 0-4 0v1a2 2 0 1 0 4 0Z"></path>
								<path d="M2 19v-3a6 6 0 0 1 12 0v3"></path>
							</svg>
							<span>Audio Decryption: Access your encrypted audio files and conversations.</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<circle cx="9" cy="9" r="2"></circle>
								<path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
							</svg>
							<span>Image Decryption: Access your encrypted images and visual data</span>
						</a>
						<a
							class="flex items-center gap-2 hover:bg-gray-200 p-2 rounded transition-colors duration-200"
							href="#"
						>
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
								<path d="m22 8-6 4 6 4V8Z"></path>
								<rect width="14" height="12" x="2" y="6" rx="2" ry="2"></rect>
							</svg>
							<span>Video Decryption: Access your encrypted video files and footage. </span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>

</body>
</html>
