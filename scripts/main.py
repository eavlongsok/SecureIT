from dotenv import load_dotenv
import os
from pathlib import Path

from helper import parse_arguments
from key import key_system
from encrypt import *
from decrypt import *

dotenv_path = Path("../.env")
load_dotenv(dotenv_path=dotenv_path)

KEY_SYSTEM_C1 = os.getenv("C1")
KEY_SYSTEM_C2 = os.getenv("C2")
KEY_SYSTEM_Y_MINUS_1 = os.getenv("KEY_Y_MINUS_1")
KEY_SYSTEM_Y_MINUS_2 = os.getenv("KEY_Y_MINUS_2")
MAIN_ALGO_Y_MINUS_1 = os.getenv("KEY_Y_MINUS_1")
MAIN_ALGO_Y_MINUS_2 = os.getenv("KEY_Y_MINUS_2")

if KEY_SYSTEM_C1 is None or KEY_SYSTEM_C2 is None or KEY_SYSTEM_Y_MINUS_1 is None or KEY_SYSTEM_Y_MINUS_2 is None:
    raise Exception("Failed to load necessary variables")

if MAIN_ALGO_Y_MINUS_1 is None or MAIN_ALGO_Y_MINUS_2 is None:
    MAIN_ALGO_Y_MINUS_1 = KEY_SYSTEM_Y_MINUS_1
    MAIN_ALGO_Y_MINUS_2 = KEY_SYSTEM_Y_MINUS_2

KEY_SYSTEM_C1 = float(KEY_SYSTEM_C1)
KEY_SYSTEM_C2 = float(KEY_SYSTEM_C2)
KEY_SYSTEM_Y_MINUS_1 = float(KEY_SYSTEM_Y_MINUS_1)
KEY_SYSTEM_Y_MINUS_2 = float(KEY_SYSTEM_Y_MINUS_2)
MAIN_ALGO_Y_MINUS_1 = float(MAIN_ALGO_Y_MINUS_1)
MAIN_ALGO_Y_MINUS_2 = float(MAIN_ALGO_Y_MINUS_2)

'''
define the arguments of the script here
should look something like this when running the script

    python main.py --type encrypt --format text --key 1234567890123456 --path "C://...../storage/image.jpg"
    or
    python main.py -t encrypt -f text -k 1234567890123456 -p "C://...../storage/image.jpg"

probably will use argument parser library
'''

service_type, file_format, key, file_path = parse_arguments()

# this program assumes that the file_path has the right file extension

MAIN_ALGO_C1, MAIN_ALGO_C2 = key_system(key, KEY_SYSTEM_C1, KEY_SYSTEM_C2, KEY_SYSTEM_Y_MINUS_1,
                                        KEY_SYSTEM_Y_MINUS_2)

if service_type == "encrypt":
    match file_format:
        case "text":
            encrypt_text(file_path, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)
        case "audio":
            ...
        case "image":
            ...
        case "video":
            ...
        case _:
            raise ValueError("file format not supported")

elif service_type == "decrypt":
    match file_format:
        case "text":
            decrypt_text(file_path, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)
        case "audio":
            ...
        case "image":
            ...
        case "video":
            ...
        case _:
            raise ValueError("file format not supported")

