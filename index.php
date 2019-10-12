<!doctype html>
<html>
  <head>
    <title>Input</title>
  </head>
  <body>
    <form action = "reading.php" method = "post" enctype = "multipart/form-data">
      Please upload a file:
      <input type="file" name = "fileToUpload" id="fileToUpload">
      <input type="text" value = "Volume No." name="vol">
      <input type="text" value = "Edition No." name="edition">
      <input type="submit" value = "Upload File" name = "submit">
    </form>
  </body>
</html>