<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['Password'])) {
        $username = $_POST['username'];
        $password = $_POST['Password'];

        // Validate and sanitize user input
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        // You can add more validation for the password if needed.

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username=?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if the username exists in the database
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['password'];
            $userRole = $row['role']; // Retrieve the user's role from the database

            // Verify the hashed password using password_verify
            if (password_verify($password, $storedPassword)) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $userRole; // Store the user's role in the session
                $_SESSION['status'] = "login";

                // Redirect the user to a secure page after successful login
                header("Location: admin_page.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo"Invalid username.";
        }
    } else {
        echo"Please enter both username and password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- CSS Saya -->
  <link rel="stylesheet" href="style.css" />
  <!-- <link rel="stylesheet" href="/login.css" /> -->

  <title>Login</title>
  <link rel="icon" type="image/png" href="" />

  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body>
  <section class="form my-5">
    <div class="container">
      <div class="row align-items-center g-0">
        <div class="col-lg-12">
        </div>
        <div class="col-lg-6 px-5 pt-5">
          <h1 style="font-size: 38px; font-family: 'Mulish', sans-serif; font-weight: 700" class="py-2">Login</h1>
         
      
          
          <form method="POST" action="">
            <div class="form-row">
              <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="text" placeholder="contoh@yahoo.com" id="email" value="" class="form-control rounded-3" name="username" />

              </div>
            </div>
            <div class="form-row">
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" placeholder="minimun 8 characters" class="form-control rounded-3" name="Password">

              </div>
            </div>
            <div class="form-row">
              <div class="mb-2">
                <input type="checkbox" name="connected" class="form-check-input" />
                <label for="connected" class="form-check-label">Remember Me</label>
              </div>
              <div class="form">
                <div class="d-grid my-4">
                  <button type="submit" class="btn btn-primary rounded-3">Login</button>
                </div>
              </div>
              <div class="form">
                <div class="row text-center">
                  <div style="color: #c2c2c2; font-size: 16px; font-family: 'Mulish', sans-serif">Or Sign in With</div>
                </div>
                <div class="form" style="margin: 24px">
                  <div class="d-grid">
                    <a class="btn btn-outline-primary rounded-3"><span class="iconify" data-inline="false" data-icon="grommet-icons:google" style="margin-right: 8px; font-size: 24px"></span> Sign in with Google</a>
                  </div>
                </div>
              </div>
            </div>
            <p>Don't have an account? <a href="register.php">Create an Account</a></p>
            <p>Forgot your password? <a href="#">Click Here</a></p>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>

</html>