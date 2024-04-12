<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Page Enumerator - For Page Flip</title>
    <style>
        * {
            box-sizing: border-box;
        }

        form {
            margin: 1rem;
            padding: 1rem;
            background-color: #eee;
            border-radius: 10px;
        }

        input {
            width: 100%;
            border: 1px solid;
            background-color: #fff;
            padding: 0.5rem;
        }

        .field-group {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <form action="/" method="post" enctype="multipart/form-data">
        <?php include 'processor.php'; ?>
        <div class="field-group">
            <label for="">Arquivo ZIP</label>
            <input type="file" name="zip_file" id="zip_file">
        </div>
        <button type="submit">Processar</button>
    </form>

</body>

</html>