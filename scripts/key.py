from helper import f


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
