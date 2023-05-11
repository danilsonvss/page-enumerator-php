<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/" method="post" enctype="multipart/form-data">
        <label for="">Arquivo ZIP</label>
        <br>
        <br>
        <input type="file" name="zip_file" id="zip_file">
        <br>
        <br>
        <button type="submit">Processar</button>
    </form>
    <?php
    function extractZipFiles($zipFile, $destinationDir)
    {
        $zip = new ZipArchive();
        if ($zip->open($zipFile) === true) {
            $zip->extractTo($destinationDir);
            $zip->close();
        }
    }

    function renameImageFiles($directory)
    {
        $files = scandir($directory);
        $fileCount = 1;

        foreach ($files as $file) {
            if ($file != "." && $file != ".." && !is_dir($directory . '/' . $file)) {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $newName = "Page" . $fileCount . "." . $extension;
                rename($directory . '/' . $file, $directory . '/' . $newName);
                $fileCount++;
            }
        }
    }

    if (isset($_FILES['zip_file'])) {
        if ($_FILES["zip_file"]["error"] == UPLOAD_ERR_OK) {
            $tempName = $_FILES["zip_file"]["tmp_name"];
            $destinationDir = "files";

            if (!is_dir($destinationDir)) {
                mkdir($destinationDir);
            }

            move_uploaded_file($tempName, $destinationDir . "/" . $_FILES["zip_file"]["name"]);
            extractZipFiles($destinationDir . "/" . $_FILES["zip_file"]["name"], $destinationDir);
            renameImageFiles($destinationDir);

            echo "Arquivos extraídos e renomeados com sucesso!";
        } else {
            echo "Ocorreu um erro ao fazer o upload do arquivo.";
        }
    }
    ?>
</body>

</html>