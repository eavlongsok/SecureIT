import pathlib

from dotenv import load_dotenv
import os
from pathlib import Path

from decrypt import _decrypt_image
from encrypt import _encrypt_image
from helper import parse_arguments
from key import key_system
from encrypt import *
from decrypt import *

dirname = os.path.join(os.path.dirname(__file__), '..')
env_file_name = os.path.join(dirname, '.env')
dotenv_path = Path(env_file_name)
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
            ...
        case "audio":
            ...
        case "image":
            dest = dirname + "/storage/app/public/encrypted_image" + pathlib.Path(file_path).suffix
            encrypt(file_path, dest, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)

         #encrypt_image 

            img = cv.imread(file_path)
            height, width, _ = img.shape

            tmp_img = np.zeros(img.shape, dtype=np.uint8)

            encrypted_img = _encrypt_image(img, tmp_img, MAIN_ALGO_C1, MAIN_ALGO_C2,MAIN_ALGO_Y_MINUS_1 ,MAIN_ALGO_Y_MINUS_2 , returnVal=false)

            cv.imwrite(dirname+"/storage/app/public/encrypted.png", encrypted_img)

            print("done")
            
        case "video":
            dest = dirname + "/storage/app/public/encrypted_video" + pathlib.Path(file_path).suffix
            encrypt(file_path, dest, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)

            # or uncomment the function below

#             cap = cv.VideoCapture(file_path)
#             fps = int(cap.get(cv.CAP_PROP_FPS))
#             width = int(cap.get(cv.CAP_PROP_FRAME_WIDTH))
#             height = int(cap.get(cv.CAP_PROP_FRAME_HEIGHT))
#
#             encrypted_video = cv.VideoWriter(dirname+"/storage/app/public/encrypted.mkv", cv.VideoWriter.fourcc(*"FFV1"), fps,
#                                              (width, height), True)
#
#             last = MAIN_ALGO_Y_MINUS_1
#             second_last = MAIN_ALGO_Y_MINUS_2
#
#             count = 0
#             while cap.isOpened():
#                 ret, frame = cap.read()
#
#                 if not ret:
#                     break
#                 if count == 0:
#                     tmp_frame = np.zeros(frame.shape, dtype=np.uint8)
#
#                 encrypted_frame, last, second_last = _encrypt_image(frame, tmp_frame, MAIN_ALGO_C1, MAIN_ALGO_C2, last,
#                                                                     second_last, returnVal=True)
#                 encrypted_video.write(encrypted_frame)
#
#                 count += 1
#                 print(count)
#
#             cap.release()

            # compressing the encrypted video

#             encrypted_video.release()
#             print("done")
        case _:
            raise ValueError("file format not supported")

elif service_type == "decrypt":
    match file_format:
        case "text":
            ...
        case "audio":
            ...
        case "image":
            dest = dirname + "/storage/app/public/decrypted_image" + pathlib.Path(file_path).suffix
            decrypt(file_path, dest, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)

            #decrypt_image 

            img = cv.imread(file_path)

            last = MAIN_ALGO_Y_MINUS_1
            second_last = MAIN_ALGO_Y_MINUS_2

            tmp_img = np.zeros(img.shape, dtype=np.uint8)

            decrypted_img= _decrypt_image(img, tmp_img, MAIN_ALGO_C1, MAIN_ALGO_C2, last, second_last, returnVal=flase)

            cv.imwrite(dirname+"/storage/app/public/decrypted_image.png", decrypted_img)

            print("done")

 
        case "video":
            dest = dirname + "/storage/app/public/decrypted_video" + pathlib.Path(file_path).suffix
            decrypt(file_path, dest, MAIN_ALGO_C1, MAIN_ALGO_C2, MAIN_ALGO_Y_MINUS_1, MAIN_ALGO_Y_MINUS_2)
            # or uncomment the function below

#             cap = cv.VideoCapture(file_path)
#             fps = int(cap.get(cv.CAP_PROP_FPS))
#             width = int(cap.get(cv.CAP_PROP_FRAME_WIDTH))
#             height = int(cap.get(cv.CAP_PROP_FRAME_HEIGHT))
#
#             decrypted_video = cv.VideoWriter(dirname+"/storage/app/public/decrypted_video.mkv", cv.VideoWriter.fourcc(*"FFV1"), fps,
#                                              (width, height), True)
#
#             last = MAIN_ALGO_Y_MINUS_1
#             second_last = MAIN_ALGO_Y_MINUS_2
#
#             count = 0
#             while cap.isOpened():
#                 ret, frame = cap.read()
#
#                 if not ret:
#                     break
#
#                 if count == 0:
#                     tmp_frame = np.zeros(frame.shape, dtype=np.uint8)
#                 encrypted_frame, last, second_last = _decrypt_image(frame, tmp_frame, MAIN_ALGO_C1, MAIN_ALGO_C2, last,
#                                                                     second_last, returnVal=True)
#                 decrypted_video.write(encrypted_frame)
#
#                 count += 1
#                 print(count)
#
#             cap.release()
#             decrypted_video.release()
#             print("done")
        case _:
            raise ValueError("file format not supported")