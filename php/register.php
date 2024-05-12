<?php

require 'config.php';
session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $lastName = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $code = trim($_POST["code"]);

    // VALIDATE THE OBLIGATORY FIELDS
    if (empty($name) || empty($lastName) || empty($email) || empty($password) || empty($code)) {
        echo "<script>alert('All fields are required.'); window.location.href='register.php';</script>";
        exit;
    }

    // VALIDATE THE EMAIL FORMAT
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@ufpso.edu.co')) {
        echo "<script> alert('Invalid email address. Please use your university email.'); window.location.href='register.php';</script>";
        exit;
    }

    // VALIDATE IF THE CODE IS REGISTERED
    $stmt = $conn->prepare("SELECT * FROM register WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('The code is already in use. Please choose a different one.'); window.location.href='register.php';</script>";
        exit;
    }

    // VALIDATE OR VERIFICATE IF THE EMAIL IS REGISTERED
    $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!'); window.location.href='register.php';</script>";
        exit;
    }

    // VALIDATE THE PASSWORD LENGTH
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.'); window.location.href='register.php';</script>";
        exit;
    }

    
    // PASSWORD HASH
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // INSERT NEW USERS IN THE DATABASE
    $insert = $conn->prepare("INSERT INTO register (name, lastName, code, password, email) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $name, $lastName, $code, $passwordHash, $email);
    if ($insert->execute()) {
        echo "<script>alert('Registration successful.'); window.location.href='config-user.php';</script>";
    } else {
        echo "<script>alert('Error in registration.'); window.location.href='register.php';</script>";
    }

    $stmt->close();
    $insert->close();
    $conn->close();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="UFPSO, Connect, Universidad Francisco de Paula Santander, Red   Social">
    <meta name="keywords"
        content="UFPSOConnect, Red Social UFPSO, Blog, Universidad, Comunicacion, Frontend, Desarrollo web">
    <meta name="description" content="Portal para acceder a la red social de la UFPSO">
    <link rel="author" href="">
    <link rel="icon" href="img/logo-vertical-blanco-connect.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <title>UFPSOConnect - Register</title>
</head>
<body>
    

    <section>
        <div class="principal">
            <nav>
               <img src="../Img/logo-alone.png" alt="UFPSO Icon">
               <h1>CONNECT</h1>
               
               <div class="navbar-section">
                   <a href="login.php" class="login-button">Login</a>
                   <a href="register.php" class="register-button active">Register</a>
               </div>
            </nav>

            <div class="content">
                <h2>Create your account</h2>
                <p>If you already have an account, enter your email and institutional code to log in.</p>
                <div class="data-content">
                    <!-- FORM CONTENT   z -->
                    <form action="" method="post">
                        <div class="form">
                            
                            <div class="form-group">
                                <input type="text" name="name" class="item1" placeholder="First name:">
                                <label for="name" class="form-label">First Name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastName" class="item2" placeholder="Last name:">
                                <label for="lastName" class="form-label">Last Name</label>
                                
                            </div>
                            <div class="form-group2">
                                
                                <input type="number" name="code" class="item3" placeholder="Code:">
                                <label for="code" class=""></label>

                            </div>
                            <div class="form-group2">
                                <input type="password" name="password" class="item4" placeholder="Password:">
                                <label for="password" class=""></label>

                            </div>
                            <input type="email" name="email" class="item5" placeholder="Institutional Email:">
                            <label for="email" class=""></label>

                        </div>
                        <button type="submit" name="submit" class="button"> Create Account</button>

                        <div class="login-here">
                    <p class="footer-text">If you already have an account, enter your email and institutional code <a href="login.php">here to login</a> </p>
                </div>
                            
                    </form>

                </div>
            </div>
            <!-- UFPSO image footer  -->
            <footer>
                
                <img src="../img/logo-vertical-blanco-connect-new.png" alt="">
            </footer>
            
        </div>
        
    </section>
    
</body>
</html>