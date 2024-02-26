import argparse
import numpy as np
from numba import njit


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
