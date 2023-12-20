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
            <div class="d-flex justify-content-center h-100">
                <div class="user_card">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <a href="index.php"><img src="assets/images/logo1.gif" class="brand_logo" alt="Logo"></a>
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
                            Don't have an account? <a href="club.php" class="ml-2 text-white">Register
                                Club</a>
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="#" class="text-white">Forgot your password?</a>
                        </div>
                    </div>


                    <?php

        } else {
            ?>
                    <nav class="navbar sticky-top navbar-light" style="background-color: #1f07b9;">
                        <a class="navbar-brand text-white" href="#">
                            <img src="assets/images/logo1.gif" width="30" height="30" class="d-inline-block align-top"
                                alt="">
                            Online Voting System
                        </a>
                        <button class="navbar-toggler bg-white" type="button" data-toggle="collapse"
                            data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-light text-white" href="club.php">Join</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-light text-white" href="?club-registration=1">Login</a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <!-- Homepage Content -->
                    <div class="container h-100">
                        <!-- Display Club Information Cards -->
                        <br>
                        <br>
                        <h3 id="club-info" class="text-white text-center">Welcome to UIU Clubs</h3>
                        <hr class="bg-white">
                        <br>
                        <div class="card-deck">
                            <div class="card">
                                <img class="card-img-top" src="assets/images/club1.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">English Club</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to additional content. This content is a little bit longer.</p>
                                        <h4>For more details to visit:<a href=https://www.facebook.com/UIUELF> here</a> </h4>
                                </div>

                            </div>
                            <div class="card">
                                <img class="card-img-top" src="assets/images/club2.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Computer Club</h5>
                                    <p class="card-text">This card has supporting text below as a natural lead-in to
                                        additional content.</p>
                                       <h4>For more details to visit:<a href="https://www.facebook.com/uiuccl"> here</a> </h4>
                                </div>

                            </div>
                            <div class="card">
                                <img class="card-img-top" src="assets/images/club3.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Cultural Club</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to additional content. This card has even longer content than the first to
                                        show that equal height action.</p>
                                        <h4>For more details to visit:<a href=https://www.facebook.com/UIU.Cultural.club.uiucc> here</a> </h4>
                                </div>
                            </div>
                            <div class="card">
                                <img class="card-img-top" src="assets/images/club4.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Debate Club</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to additional content. This card has even longer content than the first to
                                        show that equal height action.</p>
                                        <h4>For more details to visit:<a href=https://www.facebook.com/UIU.Debate.Club> here</a> </h4>
                                </div>
                            </div>
                        </div>
                    
                        <?php
        }

        ?>

                    <?php
                    if (isset($_GET['not_registered'])) {
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
        if ($studentID == $data['student_ID'] and $password == $data['password']) {
            session_start();
            $_SESSION['user_role'] = $data['user_role'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['club_name']=$data['club_name'];

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
                <script> location.assign("index.php?club-registration=1&invalid_access=1"); </script>
            <?php
        }
    } else {
        ?>
            <script> location.assign("index.php?club-registration=1&not_registered=1"); </script>
        <?php

    }
}

?>