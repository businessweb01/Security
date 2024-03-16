<?php
$errors = [];

// Validate and sanitize user inputs
if (isset($_POST["register"])) {
    require_once("Regsecurity.php");

    // Sanitize input data
    $fullname = test_input($_POST["fullname"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $confirmpassword = test_input($_POST["confirm_password"]);

    // Validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmpassword)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirmpassword) {
        $errors[] = "Passwords do not match.";
    }

    // Display error popup if there are errors
    if (!empty($errors)) {
        echo "<script>showPopup('" . implode("\\n", $errors) . "');</script>";
    } else {
        // Proceed with further processing (e.g., database insertion)
        // Implement database insertion here with prepared statements to prevent SQL injection
        // Example:
        /*
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $email, $hashedPassword]);
        */

        // Redirect the user to the next step or a confirmation page
        header("Location: index.php");
        exit();
    }
}

// Sanitize user input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<link rel="stylesheet" href="logReg.css">
<style>
    /* Popup container */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    /* Show the popup when activated */
    .show-popup {
        display: block;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
</head>
<body>
    <!-- Popup container -->
    <div id="errorPopup" class="popup">
        <span class="close" onclick="closePopup()">&times;</span>
        <p id="errorMessage"></p>
    </div>

    <form action="" method="post" autocomplete="off">
        <div class="modes">
            <p>Login</p>
            <input type="checkbox" id="toggle" class="toggle-input">
            <label for="toggle" class="toggle-label"></label>
            <p>Register</p>
        </div>
        <div class="regpage">
            <h2>Join <span class="Agri">Agri</span>Learn Now !</h2>
            <label for="fullname" class="label">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="juandelacruz" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="juandelacruz@gmail.com" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Register" name="register">
        </div>

        <div class="login show-page">
            <h2>Welcome To <span class="Agri">Agri</span>Learn</h2>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="juandelacruz@gmail.com" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login" name="login" class="login-btn">
        </div>
    </form>
    

    <script>
        document.body.style.backgroundImage = 'linear-gradient(180deg, #C8C1AC,#FFE794)';
        const toggleInput = document.querySelector('.toggle-input');

        toggleInput.addEventListener('change', function() {
            if (this.checked) {
                // Hide the login page
                document.querySelector('.login').classList.remove('show-page');
                // Show the registration page
                document.querySelector('.regpage').classList.add('show-page');
            } else {
                // Show the login page
                document.querySelector('.login').classList.add('show-page');
                // Hide the registration page
                document.querySelector('.regpage').classList.remove('show-page');
            }
        });

        // Function to show popup with error message
        function showPopup(message) {
            document.getElementById("errorMessage").innerText = message;
            document.getElementById("errorPopup").classList.add("show-popup");
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById("errorPopup").classList.remove("show-popup");
        }
    </script>
</body>
</html>
