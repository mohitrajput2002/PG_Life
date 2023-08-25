<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
    die();
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "Something went wrong!";
    return;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newFullName = $_POST["full_name"];
    $newEmail = $_POST["email"];
    $newPhone = $_POST["phone"];
    $newCollegeName = $_POST["college_name"];

    // Handle image upload
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = 'img/'; // Define your upload directory
        $newFileName = uniqid() . "_" . $_FILES["profile_picture"]["name"];
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadPath)) {
            $updateImageSql = "UPDATE users SET profile_picture = '$uploadPath' WHERE id = $user_id";
            $updateImageResult = mysqli_query($conn, $updateImageSql);

            if (!$updateImageResult) {
                $errorMessage = "Image update failed. Please try again.";
            }
        } else {
            $errorMessage = "Image upload failed. Please try again.";
        }
    }

    $updateSql = "UPDATE users SET full_name = '$newFullName', email = '$newEmail', phone = '$newPhone', college_name = '$newCollegeName' WHERE id = $user_id";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        header("location: dashboard.php");
        die();
    } else {
        $errorMessage = "Update failed. Please try again.";
    }
}
?>

<!-- HTML form for editing profile -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile | PG Life</title>
    <!-- Font Awesome 4.5 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/common.css">

    <style>
        /* Style for the edit profile form container */
        .edit-profile-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        /* Style for form labels */
        .edit-profile-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Style for form input fields */
        .edit-profile-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Style for the submit button */
        .edit-profile-form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Style for the submit button on hover */
        .edit-profile-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/head_links.php"; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Profile
            </li>
        </ol>
    </nav>
    <div class="edit-profile-form">
        <h1>Edit Profile</h1>
        <?php if (isset($errorMessage)) {
            echo "<p>$errorMessage</p>";
        } ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?= $user['full_name'] ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
            <label for="college_name">College Name:</label>
            <input type="text" id="college_name" name="college_name" value="<?= $user['college_name'] ?>" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture">
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>