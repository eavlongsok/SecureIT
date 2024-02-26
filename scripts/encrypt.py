from typing import Union
from numba import njit
from decrypt import decrypt_text, test_decrypt, decrypt_byte
from helper import f, normalize, denormalize
import cv2 as cv
import numpy as np


def encrypt_text(plain_text: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> str:
    if len(plain_text) == 0:
        raise Exception("Plain text length must be greater than 0")
    cipher_text = ""
    last = y_minus_1
    second_last = y_minus_2

    decrypt_last = last
    decrypt_second_last = second_last

    for i in range(len(plain_text)):

        c = plain_text[i]
        encrypted = f(normalize(ord(c)) + c1 * last + c2 * second_last)

        denormalized = denormalize(encrypted)
        while True:
            tmp_cipher_text = chr(int(denormalized))
            decrypted_char, tmp_decrypt_last, tmp_decrypt_second_last = decrypt_text(tmp_cipher_text, c1, c2, decrypt_last, decrypt_second_last, True)
            denormalized = (denormalized + ord(c) - ord(decrypted_char)) % 256

            if ord(c) - ord(decrypted_char) == 0:
                break

        decrypt_last = tmp_decrypt_last
        decrypt_second_last = tmp_decrypt_second_last

        cipher_text += chr(int(denormalized))
        second_last = decrypt_second_last
        last = decrypt_last
    # print(cipher_text, end="")
    return cipher_text


@njit
def encrypt_audio(audio_array: np.ndarray, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> np.ndarray:
    encrypted_array = np.zeros(len(audio_array), dtype=np.uint8)
    last = y_minus_1
    second_last = y_minus_2

    decrypt_last = last
    decrypt_second_last = second_last

    for i in range(len(audio_array)):
        encrypted = f(normalize(audio_array[i]) + c1 * last + c2 * second_last)

        denormalized = denormalize(encrypted)

        while True:
            tmp_cipher_value = int(denormalized)
            decrypted_value, tmp_decrypt_last, tmp_decrypt_second_last = decrypt_byte(tmp_cipher_value, c1, c2, decrypt_last, decrypt_second_last)

            denormalized = (denormalized + audio_array[i] - decrypted_value) % 256

            if audio_array[i] - decrypted_value == 0:
                # print(audio_array[i], decrypted_value)
                break

        decrypt_last = tmp_decrypt_last
        decrypt_second_last = tmp_decrypt_second_last

        encrypted_array[i] = int(denormalized)
        second_last = decrypt_second_last
        last = decrypt_last

    return encrypted_array



def encrypt_image():
    ...


def encrypt_video():
    ...


@njit
def _encrypt_image(image: cv.typing.MatLike, cipher_image: np.ndarray[np.uint8], c1: float, c2: float, y_minus_1: float, y_minus_2: float,
                returnVal=False) -> [np.ndarray[np.uint8], float, float]:
    last = y_minus_1
    second_last = y_minus_2

    for row in range(image.shape[0]):
        for col in range(image.shape[1]):
            for channel in range(image.shape[2]):
                pixel = image[row, col, channel]
                encrypted = f(normalize(pixel) + c1 * last + c2 * second_last)  # type: ignore

                denormalized = denormalize(encrypted)
                while True:
                    tmp_cipher_pixel = int(denormalized)
                    decrypted_pixel, tmp_decrypt_last, tmp_decrypt_second_last = test_decrypt(tmp_cipher_pixel, c1,c2,last,second_last)
                    denormalized = (denormalized + pixel - decrypted_pixel) % 256

                    if pixel - decrypted_pixel == 0:
                        break

                last = tmp_decrypt_last
                second_last = tmp_decrypt_second_last

#                 second_last = last
#                 last = encrypted

                cipher_image[row, col, channel] = int(denormalized)

    # if returnVal:
    return cipher_image, last, second_last

    # return cipher_image  # type: ignore


def encrypt_byte(byte: int, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> tuple[int, float, float]:
    last = y_minus_1
    second_last = y_minus_2

    encrypted = f(normalize(byte) + c1 * last + c2 * second_last)

    denormalized = denormalize(encrypted)

    while True:
        tmp_cipher_byte = int(denormalized)
        decrypted_byte, tmp_decrypt_last, tmp_decrypt_second_last = test_decrypt(tmp_cipher_byte, c1, c2, last, second_last)
        denormalized = (denormalized + byte - decrypted_byte) % 256
        if byte - decrypted_byte == 0:
            break

    last = tmp_decrypt_last
    second_last = tmp_decrypt_second_last

    return int(denormalized), last, second_last


def encrypt(src: str, dest: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float):
    with open(src, "rb") as plain:
        with open(dest, "wb") as cipher:
            while byte := plain.read(1):
                result, y1, y2 = encrypt_byte(int.from_bytes(byte, "big"), c1, c2, y_minus_1, y_minus_2)
                cipher.write(result.to_bytes(1, "big"))


