<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image </title>
    <style>
        /* Adjust styling as needed */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .frame {
            background-color: #eee;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px auto;
            max-width: 600px;
        }

        .title {
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            /* Display buttons in a column */
        }

        .button {
            margin-bottom: 10px;
            /* Adjust the margin between buttons as needed */
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            width: 95%;
            /* Make buttons take up full width */
            text-align: center;
            /* Center text within buttons */
            text-decoration: none;
            /* Remove underlines from anchor tags */
        }

    </style>
</head>
<body>
    <div class="frame">
        <h1 class="title">Image </h1>
        <div class="buttons">
            <a href="{{ route('image.encrypt') }}" class="button"> Encryption</a>
            <a href="{{ route('image.decrypt') }}" class="button"> Decryption</a>
            {{-- <a href="{{ route('image.result') }}" class="button"> Result</a> --}}
            <a href="{{ url('/') }}" class="button"> Back to Menu</a>
        </div>
    </div>
</body>
</html>
