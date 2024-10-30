<?php
// Start the session
session_start();
include('includes/dbconnection.php');

// Handle the Sign In Form Submission
if (isset($_POST['login'])) {
    $emailormobnum = trim($_POST['emailormobnum']); // Trim whitespace from input
    $password = $_POST['password']; // Plain password input

    // Fetch user based on Email or Mobile Number
    $sql = "SELECT ID, Email, MobileNumber, Password, Role FROM tbluser WHERE (Email = :emailormobnum OR MobileNumber = :emailormobnum)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':emailormobnum', $emailormobnum, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        // Verify the provided password against the stored hashed password
        if (password_verify($password, $result->Password)) {
            // Password matches, store necessary details in session
            $_SESSION['ocasuid'] = $result->ID; // Set user ID in session
            $_SESSION['login'] = $emailormobnum; // Store email or mobile number in session
            $_SESSION['role'] = $result->Role;   // Store user role in session
            
            // Redirect based on the user's role
            if ($result->Role === 'admin') {
                header("Location: ../admin/admin_dashboard.php");
            } elseif ($result->Role === 'teacher') {
                header("Location: ../teacher/teacher_dashboard.php");
            } else {
                header("Location: ../user/dashboard.php"); // Redirect to user (student) dashboard
            }
            exit(); // Stop further script execution after redirect
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Invalid Email or Mobile Number');</script>";
    }
}

// Handle the Forgot Password Form Submission
if (isset($_POST['reset-password'])) {
    $email = trim($_POST['email']);
    $sql = "SELECT Email FROM tbluser WHERE Email = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        // TODO: Send a reset password link via email (functionality to be implemented)
        echo "<script>alert('A password reset link has been sent to your email');</script>";
    } else {
        echo "<script>alert('No account found with this email');</script>";
    }
}

// Handle the Sign Up Form Submission
if (isset($_POST['submit'])) {
    // Collecting form data
    $fname = trim($_POST['fname']);
    $mobno = trim($_POST['mobno']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash the password
    $role = $_POST['role'];  // Get the selected role (admin, teacher, or user)

    // Check if email or mobile number already exists
    $ret = "SELECT Email, MobileNumber FROM tbluser WHERE Email = :email OR MobileNumber = :mobno";
    $query = $dbh->prepare($ret);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobno', $mobno, PDO::PARAM_STR); // Use PARAM_STR for mobile as it can be a string
    $query->execute();
    
    if ($query->rowCount() == 0) {
        // Insert the new user into tbluser, with hashed password and role
        $sql = "INSERT INTO tbluser (FullName, MobileNumber, Email, Password, Role) VALUES (:fname, :mobno, :email, :password, :role)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_STR); // Use PARAM_STR for mobile
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        
        // Execute the query and check if the insert was successful
        if ($query->execute()) {
            echo "<script>alert('You have successfully registered');</script>";
            echo "<script>window.location.href ='auth.php'</script>"; // Redirect to auth page
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('Email or Mobile Number already exists');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/auth.css">
    <title>Sign in & Sign up Form</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                
                <!-- Sign In Form -->
                <form class="sign-in-form" action="" method="post">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Email or Mobile Number" name="emailormobnum" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <input type="submit" value="Login" class="btn solid" name="login" />
                    <p class="forgot-password-link">
                        <a href="#" id="forgot-password-link">Forgot Password?</a>
                    </p>
                </form>

                <!-- Sign Up Form -->
                <form class="sign-up-form" action="" method="post">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" name="fname" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input type="text" placeholder="Mobile Number" name="mobno" required pattern="[0-9]{10}" maxlength="10" />
                    </div>
                    <div class="role-selection">
                        <label>
                            <input type="radio" name="role" value="admin" required />
                            Admin
                        </label>
                        <label>
                            <input type="radio" name="role" value="teacher" required />
                            Teacher
                        </label>
                        <label>
                            <input type="radio" name="role" value="user" required />
                            User
                        </label>
                    </div>
                    <input type="submit" class="btn" value="Sign up" name="submit" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Create an account to access exclusive features and start your journey with us. Sign up now!</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <p>Welcome back! Please sign in to continue your journey. Your account holds all your progress and settings.</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reset Password</h2>
            <form action="" method="post">
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Enter your email" name="email" required />
                </div>
                <input type="submit" value="Reset Password" class="btn solid" name="reset-password" />
            </form>
        </div>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>
