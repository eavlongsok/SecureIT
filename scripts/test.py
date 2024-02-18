from dotenv import load_dotenv
import os
from pathlib import Path
from encrypt import *
from decrypt import *
from key import key_system

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

MAIN_ALGO_C1, MAIN_ALGO_C2 = key_system("abcdefghijklmnop", KEY_SYSTEM_C1, KEY_SYSTEM_C2, KEY_SYSTEM_Y_MINUS_1, KEY_SYSTEM_Y_MINUS_2)
# MAIN_ALGO_C1, MAIN_ALGO_C2 = (1, 10)
print(MAIN_ALGO_C1, MAIN_ALGO_C2)
encrypted = encrypt_text("Hello world, my name is Eav Long, this is the final project for CS312 :)", MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)
print("encrypted:", encrypted, len(encrypted))
decrypted = decrypt_text(encrypted,  MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)

print("decrypted:", decrypted, len(decrypted))
