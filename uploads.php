<?php

if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    if (file_exists($target_file)) {
        echo "<p style='color: red;'>Sorry, file already exists.</p>";
        $uploadOk = 0;
    }

    
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "<p style='color: red;'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    
    if ($imageFileType != "jpg" && $imageFileType != "png" &&
        $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<p style='color: red;'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    
    if ($uploadOk == 0) {
        echo "<p style='color: red;'>File was not uploaded.</p>";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p style='color: green;'>The file has been uploaded.</p>";
        } else {
            echo "<p style='color: red;'>Sorry, there was an error uploading your file.</p>";
        }
    }
}


$images = glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Gallery with Lightbox</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .gallery a {
            display: inline-block;
        }
        .gallery img {
            width: 200px;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Upload a Picture</h1>
    <form action="uploads.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input type="submit" value="Upload File" name="submit">
    </form>

    <h2>Gallery</h2>
    <div class="gallery">
        <?php
        if (!empty($images)) {
            foreach ($images as $image) {
                echo '<a href="' . $image . '" data-lightbox="gallery" data-title="Uploaded Image"><img src="' . $image . '" alt="Uploaded Image"></a>';
            }
        } else {
            echo "<p>No images uploaded yet.</p>";
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>
</html>
