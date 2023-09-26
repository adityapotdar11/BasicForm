<?php
$profileDir = "files/profiles/";
$resumeDir = "files/resume/";
$uploadOk = 1;
$mysqli = new mysqli("localhost", "root", "", "xeniLearningFirst");

// Check connection
$photoPath = "";
$resumePath = "";
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
if (count($_FILES) > 0) {
    if (!empty($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $imageFileType = (pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        $targetFile = $profileDir . time() . "." . $imageFileType;
        try {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);
            $photoPath = $targetFile;
        } catch (Exception $th) {
            echo "File upload error";
            exit();
        }
        
    }
    if (!empty($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
        $imageFileType = (pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION));
        $targetFile = $resumeDir . time() . "." . $imageFileType;
        try {
            move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile);
            $resumePath = $targetFile;
        } catch (Exception $th) {
            echo "File upload error";
            exit();
        }
    }
}
if (isset($_POST)) {
    if (count($_POST)) {
        $sql = "INSERT INTO users (fullName, email, password, dob, gender, photo, resume, securityQuestion, securityAnswer, createdAt) VALUES ('" . $_POST["fullName"] . "', '" . $_POST["email"] . "', '" . $_POST["password"] . "', '" . $_POST["dob"] . "', '" . $_POST["gender"] . "', '" . $photoPath . "', '" . $resumePath . "', '" . $_POST["securityQuestion"] . "', '" . $_POST["securityAnswer"] . "', '" . date("Y-m-d H:i:s") . "')";
        if (mysqli_query($mysqli, $sql) === TRUE) {
            echo "New user created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}