import binascii
import struct
import numpy as np


def key_system(key: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> tuple[float, float]:
    if len(key) != 16:
        raise Exception("key must be 16 characters")

    encrypted = None
    last = y_minus_1
    secondLast = y_minus_2

    for i in range(16):
        encrypted = f(ord(key[i]) + c1 * last + c2 * secondLast)
        secondLast = last
        last = encrypted

    return secondLast, last


def f(x: float) -> float:
    return ((x + 1) % 2) - 1


def encrypt_text(plain_text: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> str:
    if len(plain_text) == 0:
        raise Exception("Plain text length must be greater than 0")
    cipher_text = ""
    last = y_minus_1
    second_last = y_minus_2

    for c in plain_text:
        # print(normalizeASCII(ord(c)))
        print(round(c1), round(c2))
        encrypted = normalizeASCII(ord(c)) + round(c1) * last + round(c2) * second_last
        a = ((encrypted + 1) % 2) - 1
        encrypted = a
        print(encrypted, denormalizeASCII(encrypted))
        cipher_text += chr(int(denormalizeASCII(encrypted)))
        second_last = last
        last = encrypted

    # for c in plain_text:
    #     print(ord(c))
    #     encrypted = ord(c) + c1 * last + c2 * second_last
    #     cipher_text += chr(round(encrypted))
    #     second_last = last
    #     last = encrypted

    return cipher_text


def decrypt_text(cipher_text: str, c1: float, c2: float, y_minus_1: float, y_minus_2: float) -> str:
    if len(cipher_text) == 0:
        raise Exception("Cipher text length must be greater than 0")
    plain_text = ""
    last = y_minus_1
    second_last = y_minus_2

    for c in cipher_text:
        normalized = normalizeASCII(ord(c))

        # decrypted = denormalizeASCII(denormalizeY(normalized) - c1 * last - c2 * second_last)
        # a = ((decrypted + 1) % 2) - 1

        decrypted = normalizeASCII(ord(c)) - round(c1) * last - round(c2) * second_last
        a = ((decrypted + 1) % 2) - 1
        print(a)


        plain_text += chr(round(denormalizeASCII(a)))
        second_last = last
        last = normalized

    # for c in cipher_text:
    #     decrypted = ord(c) - c1 * last - c2 * second_last
    #     plain_text += chr(round(decrypted))
    #     second_last = last
    #     last = ord(c)

    return plain_text


def normalizeASCII(x: float) -> float:
    return (x - 127.5) / 127.5


def denormalizeASCII(x: float) -> float:
    return (x * 127.5) + 127.5


def normalizeY(y: float) -> float:
    return y / 3


def denormalizeY(y: float) -> float:
    return y * 3
