<?php
require 'config.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $code = $_POST['code'];
    
    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT email, password FROM register WHERE email = ? AND code = ?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify password against hashed password in database
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email'];
            header("Location: index.php");
            exit;
        } else {
            echo "Incorrect Email or Password";
        }
    } else {
        echo "User not found or code mismatch";
    }

    $stmt->close();
}
$conn->close();
?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-vertical-blanco-connect.png" type="image/png">
    <link rel="stylesheet" href="../css/styless.css">
    <title>UFPSOConnect - Register</title>
</head>
<body>  


    <section>
        <div class="principal">
            <nav>
               <img src="../Img/logo-alone.png" alt="UFPSO Icon">
               <h1>CONNECT</h1>
               <div class="navbar-section">
                   <a href="/" class="login-button active">Login</a>
                   <a href="register.php" class="register-button">Register</a>
               </div>
            </nav>
            <style type="text/css">
                h2 {font-size: 55px;}
                
            </style>

            <div class="content">
                
                <h2>Sign in</h2>
                <p>If you don't have an account yet, enter your academic and personal information to create one.</p>
                <div class="data-content">
                    <!-- FORM CONTENT   z -->
                    <form action="login.php" method="post">

                        <div class="form">
                            
                            <input type="email" name="email" class="item5" placeholder="Institutional Email:">
                            <label for="email" class=""></label> 

                            <div class="form-group2">
                                <input type="password" name="password" class="item4" placeholder="Password:">
                                <label for="password" class=""></label> 
                            </div>
                            <div class="form-group2">
                                <input type="number" name="code" class="item3" placeholder="Code:">
                                <label for="code" class=""></label> 
                            </div>
                            
                        </div>
                        <button type="submit" value="Sign In" name="signIn"> Login to account</button>
                    </form>

                </div>
            </div>
            <!-- UFPSO image footer  -->
            <footer>
                <img src="../Img/logo-vertical-blanco-connect-new.png" alt="">
            </footer>
            
        </div>
        
    </section>
    
</body>
</html>