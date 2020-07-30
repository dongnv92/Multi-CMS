<!DOCTYPE html>
<html>
<head>
    <title>Upload your files</title>
</head>
<body>
<form enctype="multipart/form-data" action="" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
</form>
</body>
</html>
<?PHP
if(!empty($_FILES['uploaded_file']))
{
    print_r($_FILES['uploaded_file']);
}
?>