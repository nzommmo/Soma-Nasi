<?php
require_once 'config.php'; // Include the database configuration file

// Register user
if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];

    $sql = "INSERT INTO users (firstname,lastname, hashedpassword, email) VALUES ('$firstname', '$lastname','$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Login user
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['hashedpassword'])) {
            // Initialize session
            session_start();

            // Set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id']; // Assuming you have a user ID in your users table

            // Redirect to dashboard or any other page after successful login
            header("Location: user_page.php");
            exit;
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Email not found";
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-6">
        <!-- Login Form -->
        <div class="form-container">
          <h2>Login</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="loginEmail">Email address</label>
              <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
            </div>
            <div class="form-group">
              <label for="loginPassword">Password</label>
              <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" value="">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </form>
          <h1>Not Yet Registered?</h1>
            <p>
 
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Signup
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
            <!-- Signup Form -->
            <div class="form-container">
          <h2>Sign Up</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="signupName">FirstName</label>
              <input type="text" class="form-control" id="signupName" name="firstname" placeholder="Enter First Name" value="">
            </div>   <div class="form-group">
              <label for="signupName">LastName</label>
              <input type="text" class="form-control" id="signupName" name="lastname" placeholder="Enter Last Name" value="">
            </div>
            <div class="form-group">
              <label for="signupEmail">Email address</label>
              <input type="email" class="form-control" id="signupEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
            </div>
            <div class="form-group">
              <label for="signupPassword">Password</label>
              <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" value="">
            </div>
            <button type="submit"  class="btn btn-primary" name="register">Sign Up</button>
          </form>
        </div>
  </div>
</div>
        </div>
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>