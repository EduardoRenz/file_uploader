<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>

<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="movie">Movie:</label>
        <input type="file" id="movie" name="movie"><br><br>
        <label for="progress">Progress:</label>
        <progress id="progress" value="0" max="100"></progress><br><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        var form = document.querySelector('form');
        var progress = document.querySelector('#progress');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percent = Math.round((e.loaded / e.total) * 100);
                    progress.value = percent;
                }
            };

            xhr.onload = function() {
                // Handle success response
            };

            xhr.onerror = function() {
                // Handle error response
            };

            xhr.open('POST', 'upload.php', true);
            xhr.send(formData);
        });
    </script>
</body>

</html>