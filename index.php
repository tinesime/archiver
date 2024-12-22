<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Zip File</title>
</head>
<body>
    <h1>Create or Extract Zip File</h1>
    <form action="zip.php" method="post" enctype="multipart/form-data">
        <label for="action">Choose an action:</label><br>
        <input type="radio" id="create" name="action" value="create" checked>
        <label for="create">Create Archive</label><br>
        <input type="radio" id="extract" name="action" value="extract">
        <label for="extract">Extract Archive</label><br><br>

        <div id="compression-options">
            <label for="format">Select format:</label>
            <select name="format" id="format">
                <option value="zip">ZIP</option>
                <option value="tar">TAR</option>
            </select><br><br>
        </div>

        <label for="files">Select files to archive or an archive file to extract:</label>
        <input type="file" name="files[]" id="files" multiple>
        <input type="submit" value="Submit">
    </form>

<script>

</script>
</body>
</html>