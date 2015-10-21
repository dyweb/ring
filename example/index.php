<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午7:23
 */
// show a upload form
?>
<html>
<head>
    <title>Ring example</title>
</head>
<body>
<form action="/upload.php" method="post" enctype="multipart/form-data">
    <label for="test">Test</label>
    <input type="text" name="test" id="test" value="test-value">
    <hr>
    <input type="file" name="data">
    <input type="submit" value="submit">
</form>
</body>
</html>
