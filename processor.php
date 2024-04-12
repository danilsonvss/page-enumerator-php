<?php

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '20M');

function extractZipFiles($zipFile, $destinationDir)
{
    $zip = new ZipArchive();
    if ($zip->open($zipFile) === true) {
        if ($zip->extractTo($destinationDir)) {
            $zip->close();
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function renameImageFiles($directory)
{
    $files = scandir($directory);
    $fileCount = 1;

    foreach ($files as $file) {
        if (!in_array($file, ['.', '..']) && !is_dir($directory . '/' . $file)) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $newName = "Page" . $fileCount . "." . $extension;
                if (!rename($directory . '/' . $file, $directory . '/' . $newName)) {
                    return false;
                }
                $fileCount++;
            }
        }
    }
    return true;
}

function process()
{
    if ($_FILES["zip_file"]["error"] == UPLOAD_ERR_OK) {
        $tempName = $_FILES["zip_file"]["tmp_name"];
        $destinationDir = "files";

        if (!is_dir($destinationDir)) {
            if (!mkdir($destinationDir) && !is_dir($destinationDir)) {
                return "Falha ao criar diretório de destino.";
            }
        }

        $destinationFile = "{$destinationDir}/{$_FILES["zip_file"]["name"]}";

        if (move_uploaded_file($tempName, $destinationFile)) {
            if (extractZipFiles($destinationFile, $destinationDir)) {
                if (renameImageFiles($destinationDir)) {
                    chmod($destinationDir, 0777);
                    unlink($destinationFile);
                    return "Arquivos extraídos e renomeados com sucesso!";
                } else {
                    return "Erro ao renomear arquivos.";
                }
            } else {
                return "Erro ao extrair arquivos.";
            }
        } else {
            return "Falha ao mover o arquivo para o diretório de destino.";
        }
    } else {
        return "Ocorreu um erro ao fazer o upload do arquivo.";
    }
}

if (isset($_FILES["zip_file"])) {
    $feedback = process();
    echo $feedback;
}
