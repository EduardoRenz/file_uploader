<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    form {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 10px;
    }

    label {
        display: block;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="file"],
    progress {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: #fff;
    }

    input[type="file"] {
        cursor: pointer;
    }

    progress {
        height: 30px;
    }


    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        border: none;
        background-color: #2ecc71;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .btn:hover {
        background-color: #27ae60;
    }
</style>

<body>
    <?php
    include_once './s3/s3.php';
    $url = generateUploadURL();

    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Movie Upload</h1>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="movie">Movie:</label>
            <input type="file" id="movie" name="movie">
        </div>
        <div class="form-group">
            <label for="progress">Progress:</label>
            <progress id="progress" value="0" max="100"></progress>
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>
    <script>
        var form = document.querySelector('form');
        var progress = document.querySelector('#progress');
        let lastResponseLength = false;
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();


            xhr.onprogress = function(e) {
                let progressResponse;
                let response = e.currentTarget.response;

                progressResponse = lastResponseLength ?
                    response.substring(lastResponseLength) :
                    response;

                lastResponseLength = response.length;

                console.log(progressResponse);
                progress.value = progressResponse.split('.')[0]
            }
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && this.status == 200) {
                    console.log("100.");
                }
            }
            xhr.open('POST', 'upload.php', true);
            xhr.send(formData);
        });
    </script>

    <!-- <?php include_once './upload.php'; ?> -->
</body>

</html>