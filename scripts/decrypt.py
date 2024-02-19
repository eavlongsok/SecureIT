from helper import f, normalize, denormalize
from typing import Union

def decrypt_text(cipher_text: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float, test=False) -> Union[str, tuple[str, float, float]]:
    if len(cipher_text) == 0:
        raise Exception("Cipher text length must be greater than 0")

    plain_text = ""
    last = y_minus_1
    second_last = y_minus_2

    # real_plain_text_len = 10
    for i in range(len(cipher_text)):
        # if not test:
        c = cipher_text[i]
        # if test:
        normalized = normalize(ord(c))

        decrypted = f(normalized - c1 * last - c2 * second_last)

        plain_text += chr(int(denormalize(decrypted)))
        second_last = last
        last = normalized

    if test:
        return plain_text, last, second_last
    print(plain_text)
    return plain_text


def decrypt_audio():
    ...


def decrypt_image():
    ...


def decrypt_video():
    ...
