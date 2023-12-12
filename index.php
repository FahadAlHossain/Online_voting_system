<?php
require_once("admin/inc/config.php");

$fetchingElections = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($db));
while ($data = mysqli_fetch_assoc($fetchingElections)) {
    $stating_date = $data['starting_date'];
    $ending_date = $data['ending_date'];
    $curr_date = date("Y-m-d");
    $election_id = $data['id'];
    $status = $data['status'];

    // Active = Expire = Ending Date
    // InActive = Active = Starting Date

    //  nothing ....

    if ($status == "Active") {
        $date1 = date_create($curr_date);
        $date2 = date_create($ending_date);
        $diff = date_diff($date1, $date2);

        if ((int) $diff->format("%R%a") < 0) {
            // Update! 
            mysqli_query($db, "UPDATE elections SET status = 'Expired' WHERE id = '" . $election_id . "'") or die(mysqli_error($db));
        }
    } else if ($status == "InActive") {
        $date1 = date_create($curr_date);
        $date2 = date_create($stating_date);
        $diff = date_diff($date1, $date2);


        if ((int) $diff->format("%R%a") <= 0) {
            // Update! 
            mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id = '" . $election_id . "'") or die(mysqli_error($db));
        }
    }


}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login - Online Voting System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container h-100">
        <?php
        if (isset($_GET['club-registration'])) {
            
            ?>
            <br>
            <br>
            <h3 class="text-white text-center">Choose Clubs</h3>
            <hr class="bg-white">
            <br>
            <br>
            <div class="card-deck d-flex justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="card text-center border-primary bg-info" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Club-1</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="club.php" name="reg_btn" class="btn login_btn">Register</a>
                        </div>
                    </div>
                    <div class="card text-center border-primary bg-info" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Club-1</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="club.php" name="reg_btn" class="btn login_btn">Register</a>
                        </div>
                    </div>
                    <div class="card text-center border-primary bg-info" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Club-1</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="club.php" name="reg_btn" class="btn login_btn">Register</a>
                        </div>
                    </div>
                    <div class="card text-center border-primary bg-info" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Club-1</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="club.php" name="reg_btn" class="btn login_btn">Register</a>
                        </div>
                    </div>
                </div>
            </div>


            <?php

        } else {
            ?>
            <div class="d-flex justify-content-center h-100">
                <div class="user_card">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="assets/images/logo1.gif" class="brand_logo" alt="Logo">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center form_container">
                        <form method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="student_ID" class="form-control input_user"
                                    placeholder="Student ID" required />
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control input_pass"
                                    placeholder="Password" required />
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-center links text-white">
                            Don't have an account? <a href="?club-registration=1" class="ml-2 text-white">Register
                                Club</a>
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="#" class="text-white">Forgot your password?</a>
                        </div>
                    </div>
                    <?php
        }

        ?>

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
                } else if (isset($_GET['not_registered'])) {
                    ?>
                                <span class="bg-white text-warning text-center my-3"> Sorry, you are not registered! </span>
                    <?php
                } else if (isset($_GET['invalid_access'])) {
                    ?>
                                    <span class="bg-white text-danger text-center my-3"> Invalid username or password! </span>
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

if (isset($_POST['sign_up_btn'])) {
    // Form is submitted

    $su_username = mysqli_real_escape_string($db, $_POST['su_username']);
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
            mysqli_query($db, "INSERT INTO users(username, student_ID, password, user_role) 
                VALUES('" . $su_username . "','" . $su_studentID . "','" . $su_password . "','" . $user_role . "')")
                or die(mysqli_error($db));
            ?>

            <script> location.assign("index.php?sign-up=1&registered=1"); </script>

            <?php
        } else {
            ?>
            <script> location.assign("index.php?sign-up=1&invalid=1"); </script>
            <?php
        }
    } else {
        ?>
        <script> location.assign("index.php?sign-up=1&duplicate=1"); </script>
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
        if ($studentID == $data['student_ID'] AND $password == $data['password']) {
            session_start();
            $_SESSION['user_role'] = $data['user_role'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];

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