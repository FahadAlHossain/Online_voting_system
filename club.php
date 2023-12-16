<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Registration</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <a href="index.php"><img src="assets/images/logo1.gif" class="brand_logo" alt="Logo"></a>
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST">
                    <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-club"></i></span>
                            </div>
                            <!-- Add a dropdown for selecting the club name -->
                            <select name="su_club_name" class="form-control" required>
                                <option value="" disabled selected>Select Club</option>
                                <option value="English Club">English Club</option>
                                <option value="Computer Club">Computer Club</option>
                                <option value="Cultural Club">Cultural Club</option>
                                <option value="Debate Club">Debate Club</option>

                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="su_username" class="form-control input_user" placeholder="Username"
                                required />
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="su_studentID" class="form-control input_user"
                                placeholder="Student ID" required />
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="password" name="su_password" class="form-control input_user"
                                placeholder="Password" required />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="password" name="su_retypepassword" class="form-control input_user"
                                placeholder="Retype Password" required />
                        </div>

                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="club_registration_btn" class="btn login_btn">Register
                                Club</button>
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links text-white">
                        Already Registered? <a href="index.php?club-registration=1" class="ml-2 text-white">Sign In</a>
                    </div>
                </div>
                <?php
                    if (isset($_GET['registered'])) {
                        ?>
                        <span class="bg-white text-success text-center my-3"> Your account has been created successfully!
                        </span>
                        <?php
                    } else if (isset($_GET['invalid'])) {
                        ?>
                            <span class="bg-white text-danger text-center my-3"> Passwords mismatched, please try again! </span>
                        <?php
                    } else if (isset($_GET['duplicate'])) {
                        ?>
                                <span class="bg-white text-danger text-center my-1">Already registered!</span>
                        <?php
                    } 
                    ?>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>


</body>

</html>

<?php
require_once("admin/inc/config.php");

if (isset($_POST['club_registration_btn'])) {  // Change 'sign_up_btn' to 'club_registration_btn'
    // Form is submitted

    $su_username = mysqli_real_escape_string($db, $_POST['su_username']);
    $su_club_name = mysqli_real_escape_string($db, $_POST['su_club_name']);

    $su_studentID = mysqli_real_escape_string($db, $_POST['su_studentID']);
    $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
    $su_retypepassword = mysqli_real_escape_string($db, sha1($_POST['su_retypepassword']));
    $user_role = 'Voter';

    // Check if the username or student ID already exists
    $check_query = mysqli_query($db, "SELECT * FROM users WHERE username = '$su_username' OR student_ID = '$su_studentID'");
    $check_result = mysqli_fetch_assoc($check_query);

    if (!$check_result) {
        // No duplicate data found, proceed with registration
        if ($su_password == $su_retypepassword) {
            // Insert query
            mysqli_query($db, "INSERT INTO users(username,club_name, student_ID, password, user_role) 
                VALUES('" . $su_username . "','" . $su_club_name . "','" . $su_studentID . "','" . $su_password . "','" . $user_role . "')")
                or die(mysqli_error($db));
            ?>

            <script> location.assign("club.php?sign-up=1&registered=1"); </script>

            <?php
        } else {
            ?>
            <script> location.assign("club.php?sign-up=1&invalid=1"); </script>
            <?php
        }
    } else {
        ?>
        <script> location.assign("club.php?sign-up=1&duplicate=1"); </script>
        <?php
    }
} else if (isset($_POST["loginBtn"])) {

    $studentID = mysqli_real_escape_string($db, $_POST['student_ID']);
    $password = mysqli_real_escape_string($db, sha1($_POST['password']));

    //Query fetch/SELECT

    $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE student_ID = '" . $studentID . "'")
        or die(mysqli_error($db));
    if (mysqli_num_rows($fetchingData) > 0) {
        $data = mysqli_fetch_assoc($fetchingData);
        if ($studentID == $data['student_ID'] and $password == $data['password']) {
            session_start();
            $_SESSION['user_role'] = $data['user_role'];
            $_SESSION['username'] = $data['username'];
            if ($data['user_role'] == "Admin") {
                $_SESSION["key"] = "AdminKey";
                ?>
                    <script>location.assign("admin/index.php")</script>
                <?php
            } else {
                $_SESSION["key"] = "VotersKey";
                ?>
                    <script>location.assign("voters/index.php")</script>
                <?php
            }
        } else {
            ?>
                <script> location.assign("index.php?invalid_access=1"); </script>
            <?php
        }
    } else {
        ?>
            <script> location.assign("index.php?sign-up=1&not_registered=1"); </script>
        <?php
    }
}
?>
