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
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm px-10 py-4 mx-auto mt-12" data-v0-t="card">
            <div class="flex flex-col space-y-1.5 p-6 text-center">
                <h3 class="text-2xl font-semibold whitespace-nowrap leading-none tracking-tight"> Download {{session("type") == "encryption" ? "Encrypted" : "Decrypted"}}
                    Video </h3>
                <p class="text-sm text-muted-foreground"> Download the {{session("type") == "encryption" ? "encrypted" : "decrypted"}} video and view the key .</p>
            </div>
            <div class="p-6 flex items-center justify-center">
                <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
                    <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-12 w-12">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg>
                        <span class="text-lg mr-28"> {{session("type") == "encryption" ? "Download Encrypted Video" : "Download Decrypted Video"}} </span>
                        <form method="POST" action={{route("download")}}>
                            @csrf
                            <input type="text" name="path" hidden value="{{session("video_path")}}" />
                            <button class="ml-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                Download
                            </button>
                        </form>
                    </div>
                    <div class="flex items-center gap-2 p-2 rounded transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-12 w-12">
                            <circle cx="7.5" cy="15.5" r="5.5"></circle>
                            <path d="m21 2-9.6 9.6"></path>
                            <path d="m15.5 7.5 3 3L22 7l-3-3"></path>
                        </svg>
                        <span class="text-lg mr-28">
                            Key Used:
                            <span class="font-semibold"> {{session("key")}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center p-2 text-center justify-evenly">
                <a href="/">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gray-300 hover:bg-gray-400 text-gray-800 h-10 px-4 py-2">
                        Home Page
                    </button>
                </a>
                <a href="encrypt">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gray-300 hover:bg-gray-400 text-gray-800 h-10 px-4 py-2">
                        Video Encryption Page
                    </button>
                </a>
                <a href="decrypt">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gray-300 hover:bg-gray-400 text-gray-800 h-10 px-4 py-2">
                        Video Decryption Page
                    </button>
                </a>
            </div>
        </div>
    </div>
