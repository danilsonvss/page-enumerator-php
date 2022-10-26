<?php
$dir = './files';

$namePrefix = "Page";
$startAt = 1;

if ($handle = opendir($dir)) {
    while ($entry = readdir($handle)) {
        if (substr($entry, -4) === '.jpg') {
            $oldName = $dir . DIRECTORY_SEPARATOR . $entry;
            $newName = $dir . DIRECTORY_SEPARATOR . $namePrefix . $startAt . ".jpg";
            rename($oldName, $newName);
            $startAt++;
        }
    }
    closedir($handle);
}
