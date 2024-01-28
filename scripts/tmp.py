import math

c1 = -0.125
c2 = 0.234

yneg1 = 0.492
yneg2 = -0.133

yneg1prime = 0.242
yneg2prime = -0.955

y_array = []
answer_array = []
decrypt_array = []

temp = 0


def key_system(key):
    global temp
    temp = ord(key[0]) + c1 * yneg1 + c2 * yneg2
    y_array.append(math.fmod(temp, 2.0) - 1)

    temp = ord(key[1]) + c1 * y_array[0] + c2 * yneg1
    y_array.append(math.fmod(temp, 2.0) - 1)

    for i in range(2, 16):
        temp = ord(key[i]) + c1 * y_array[i - 1] + c2 * y_array[i - 2]
        y_array.append(math.fmod(temp, 2.0) - 1)
    for i in range(16):
        print(y_array[i])

    c1Prime = y_array[14]
    c2Prime = y_array[15]
    encrypt(plaintext, c1Prime, c2Prime)


def encrypt(plaintext, c1Prime, c2Prime):
    answer_array.append(ord(plaintext[0]) + c1Prime * yneg1prime + c2Prime * yneg2prime)
    answer_array.append(ord(plaintext[1]) + c1Prime * answer_array[0] + c2Prime * yneg1prime)

    for i in range(2, len(plaintext)):
        answer_array.append(ord(plaintext[i]) + c1Prime * answer_array[i - 1] + c2Prime * answer_array[i - 2])

    for i in range(len(plaintext)):
        print(chr(round(answer_array[i])), end="")

    print()

    decrypt(answer_array, c1Prime, c2Prime)


def decrypt(answer_array, c1Prime, c2Prime):
    decrypt_array.append((answer_array[0]) - c1Prime * yneg1prime - c2Prime * yneg2prime)
    decrypt_array.append((answer_array[1]) - c1Prime * answer_array[0] - c2Prime * yneg1prime)

    for i in range(2, len(plaintext)):
        decrypt_array.append((answer_array[i]) - c1Prime * answer_array[i - 1] - c2Prime * answer_array[i - 2])

    for i in range(len(decrypt_array)):
        print(chr(round(decrypt_array[i])), end="")

    print()



key = input("Enter your 16-character key: ")
plaintext = input("Enter your plain text: ")
if len(key) != 16:
    print("Key is not 16 characters long.")
else:
    key_system(key)
