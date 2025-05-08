<?php

class UploadHandler
{
    private $file;
    private $baseDir;
    private $destination;
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    public function __construct($file, $destination)
    {
        $this->file = $file;

        $this->baseDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $this->destination = $this->baseDir . basename($destination);

        if (!is_dir($this->baseDir)) {
            if (!mkdir($this->baseDir, 0755, true)) {
                throw new Exception("Não foi possível criar o diretório base de uploads.");
            }
        }

        if (!is_writable($this->baseDir)) {
            throw new Exception("Sem permissão de escrita para o diretório de uploads.");
        }

        if (!is_dir($this->destination)) {
            if (!mkdir($this->destination, 0755, true)) {
                throw new Exception("Não foi possível criar o diretório de destino.");
            }
        }
    }

    public function process()
    {
        if (!is_writable($this->destination)) {
            throw new Exception("Diretório de destino não tem permissão de escrita.");
        }

        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro no upload.");
        }

        $tmpZip = $this->file['tmp_name'];
        $zip = new ZipArchive;

        if ($zip->open($tmpZip) !== TRUE) {
            throw new Exception("Erro ao abrir o arquivo ZIP.");
        }

        $imageCount = 1;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);
            $info = pathinfo($entry);
            if (!isset($info['extension'])) continue;

            $ext = strtolower($info['extension']);
            if (in_array($ext, $this->allowedExtensions)) {
                $content = $zip->getFromIndex($i);
                $newName = "Page{$imageCount}." . $ext;
                file_put_contents($this->destination . '/' . $newName, $content);
                $imageCount++;
            }
        }

        $zip->close();

        if ($imageCount === 1) {
            throw new Exception("Nenhuma imagem válida foi encontrada no ZIP.");
        }
    }
}
