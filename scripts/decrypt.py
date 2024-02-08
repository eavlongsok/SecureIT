from numba import njit

from helper import f, normalize, denormalize
from typing import Union
import cv2 as cv
import numpy as np

def decrypt_text(cipher_text: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float, test=False) -> Union[str, tuple[str, float, float]]:
    if len(cipher_text) == 0:
        raise Exception("Cipher text length must be greater than 0")

    plain_text = ""
    last = y_minus_1
    second_last = y_minus_2

    # real_plain_text_len = 10
    for i in range(len(cipher_text)):
        # if not test:
        #     print("last:", last)
        c = cipher_text[i]
        # if test:
        #     print(i, last, second_last)
        normalized = normalize(ord(c))

        decrypted = f(normalized - c1 * last - c2 * second_last)

        plain_text += chr(int(denormalize(decrypted)))
        second_last = last
        last = normalized

    if test:
        return plain_text, last, second_last

    return plain_text


def decrypt_audio():
    ...


def decrypt_image():
    ...


def decrypt_video():
    ...


@njit
def test_decrypt(byte: int, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> tuple[int, float, float]:
    last = y_minus_1
    second_last = y_minus_2

    normalized = normalize(byte)

    decrypted = f(normalized - c1 * last - c2 * second_last)

    second_last = last
    last = normalized

    return int(denormalize(decrypted)), last, second_last


@njit
def _decrypt_image(cipher_image: cv.typing.MatLike, plain_image: np.ndarray[np.uint8], c1: float, c2: float, y_minus_1: float, y_minus_2: float, returnVal=False) -> tuple[np.ndarray[np.uint8], float, float]:
    last = y_minus_1
    second_last = y_minus_2

    for row in range(cipher_image.shape[0]):
        for col in range(cipher_image.shape[1]):
            for channel in range(cipher_image.shape[2]):
                cipher_pixel = cipher_image[row, col, channel]
                normalized = normalize(cipher_pixel)  # type: ignore

                decrypted = f(normalized - c1 * last - c2 * second_last)

                plain_image[row, col, channel] = int(denormalize(decrypted))
                second_last = last
                last = normalized

    # if returnVal:
    return plain_image, last, second_last  # type: ignore
    # return plain_image  # type: ignore


def decrypt_byte(byte: int, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> tuple[int, float, float]:
    last = y_minus_1
    second_last = y_minus_2

    normalized = normalize(byte)
    decrypted = f(normalized - c1 * last - c2 * second_last)

    second_last = last
    last = normalized

    return int(denormalize(decrypted)), last, second_last


def decrypt(src: str, dest: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float):
    with open(src, "rb") as cipher:
        with open(dest, "wb") as decipher:
            while byte := cipher.read(1):
                result, y1, y2 = decrypt_byte(int.from_bytes(byte, "big"), c1, c2, y_minus_1, y_minus_2)
                decipher.write(result.to_bytes(1, "big"))