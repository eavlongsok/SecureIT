def f(x: float) -> float:
    return ((x + 1) % 2) - 1


def normalize(x: float) -> float:
    return (x - 127.5) / 127.5


def denormalize(x: float) -> float:
    return (x * 127.5) + 127.5

