import argparse
import numpy as np
from numba import njit
import wave

@njit
def f(x: float) -> float:
    return ((x + 1) % 2) - 1


@njit
def normalize(x: float | int | np.uint8) -> float:
    return (x - 128) / 128


@njit
def denormalize(x: float | int | np.uint8) -> float:
    return (x * 128) + 128


def file(path: str):
    from os.path import exists
    if not exists(path):
        raise ValueError("Path doesn't exist")
    return path


def key_type(key: str):
    if len(key) != 16:
        print("length")
        raise ValueError("Key must be 16 character long")
    if not key.isascii():
        print("ascii")
        raise ValueError("Key must be valid ASCII characters")
    return key


def parse_arguments() -> tuple[str, str, str, str]:
    parser = argparse.ArgumentParser(prog="SecureIT", description="Secure your data with our service")

    parser.add_argument("-t", "--type", required=True, help="type of service. Available types = [encrypt, decrypt]",
                        type=str.lower, choices=["encrypt", "decrypt"])
    parser.add_argument("-f", "--format", required=True, help="file format. Available types = [text, audio, image, video]",
                        type=str.lower, choices=["text", "audio", "image", "video"])
    parser.add_argument("-k", "--key", required=True,
                        help="key for encryption and decryption process. Must be 16 ASCII characters", type=key_type)
    parser.add_argument("-p", "--path", required=True, help="path of the file for encryption or decryption process",
                        type=str)

    args: argparse.Namespace = parser.parse_args()

    service_type: str = args.type
    file_format: str = args.format
    key: str = args.key
    file_path: str = args.path

    return service_type, file_format, key, file_path

def convert_array_to_audio(original_audio: wave.Wave_read, audio_array, output_wav_path):
    audio_array_16bit = np.zeros(len(audio_array) // 2, dtype=np.int16)
    for i in range(0, len(audio_array), 2):
        first_8bit = audio_array[i]
        last_8bit = audio_array[i + 1]
        audio_array_16bit[i // 2] = (first_8bit << 8) | last_8bit

    with wave.open(output_wav_path, "w") as audio:
        audio.setnchannels(1)
        audio.setsampwidth(original_audio.getsampwidth())
        audio.setframerate(original_audio.getframerate())
        audio.writeframes(audio_array_16bit.tobytes())

def convert_audio_to_np_array(audio_obj: wave.Wave_read):
    if audio_obj is None:
        raise Exception("audio_obj is None")

    if audio_obj.getnchannels() > 1:
        raise Exception("Audio must be mono")
    else:
        # Read audio data
        audio_data = audio_obj.readframes(audio_obj.getnframes())
        # Convert audio data to numpy array
        audio_array = np.frombuffer(audio_data, dtype=np.int16)

    audio_array_8bit = []
    for sample in audio_array:
        first_half = (sample >> 8) & 0xFF  # Get first 8 bits
        last_half = sample & 0xFF  # Get last 8 bits
        audio_array_8bit.append(first_half)
        audio_array_8bit.append(last_half)

    int_values = [int(byte) for byte in audio_array_8bit]

    return np.array(int_values, dtype=np.uint8)


# Function to merge audio channels into one
def merge_channels(audio):
    num_frames = audio.getnframes()
    num_channels = audio.getnchannels()
    audio_data = audio.readframes(num_frames)
    audio_array = np.frombuffer(audio_data, dtype=np.int16)
    return np.mean(audio_array.reshape(-1, num_channels), axis=1).astype(np.int16)

