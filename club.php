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
                        <img src="assets/images/logo1.gif" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST">
                    <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-club"></i></span>
                            </div>
                            <!-- Add a dropdown for selecting the club name -->
                            <select name="club_name" class="form-control" required>
                                <option value="" disabled selected>Select Club</option>
                                <option value="English Club">English Club</option>
                                <option value="Computer Club">Computer Club</option>
                                <option value="Cultural Club">Cultural Club</option>
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
                        Already Registered? <a href="index.php" class="ml-2 text-white">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>


</body>

</html>