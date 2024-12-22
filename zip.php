<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files']) && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'create') {
        $format = $_POST['format'];
        $files = $_FILES['files']['tmp_name'];
        $fileNames = $_FILES['files']['name'];

        switch ($format) {
            case 'zip':
                createZipArchive($files, $fileNames);
                break;
            case 'tar':
                createTarArchive($files, $fileNames);
                break;
            default:
                echo "Invalid format selected.";
        }
    } elseif ($action == 'extract') {
        if (!empty($_FILES['files']['tmp_name'][0])) {
            $zipFileName = $_FILES['files']['tmp_name'][0];

            if (pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION) == 'zip') {
                extractZipArchive($zipFileName);
            } else {
                echo "Unsupported archive format.";
            }
        } else {
            echo "No file uploaded for extraction.";
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "No files uploaded or action not selected.";
}

function createZipArchive($files, $fileNames)
{
    $zip = new ZipArchive();
    $zipFileName = 'archive.zip';

    if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
        exit("Cannot open <$zipFileName>\n");
    }

    foreach ($files as $key => $tmp_name) {
        if (file_exists($tmp_name)) {
            $zip->addFile($tmp_name, $fileNames[$key]);
        } else {
            echo "File <{$fileNames[$key]}> does not exist.\n";
        }
    }

    $zip->close();
    echo "Archive <$zipFileName> created successfully.\n";
    echo "<a href='$zipFileName'>Download $zipFileName</a>";
}

function createTarArchive($files, $fileNames)
{
    $tarFileName = 'archive.tar';
    $phar = new PharData($tarFileName);

    foreach ($files as $key => $tmp_name) {
        if (file_exists($tmp_name)) {
            $phar->addFile($tmp_name, $fileNames[$key]);
        } else {
            echo "File <{$fileNames[$key]}> does not exist.\n";
        }
    }

    echo "Archive <$tarFileName> created successfully.\n";
    echo "<a href='$tarFileName'>Download $tarFileName</a>";
}

function extractZipArchive($zipFileName) {
    $zip = new ZipArchive();
    $extractPath = 'archive-extracted/';

    if (!is_dir($extractPath)) {
        mkdir($extractPath, 0777, true);
    }

    if ($zip->open($zipFileName) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        echo "Archive extracted successfully to <$extractPath>.\n";
        echo "<a href='$extractPath'>View Extracted Files</a>";
    } else {
        echo "Cannot open <$zipFileName>.\n";
    }
}