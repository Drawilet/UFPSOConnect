<?php 
require 'php/config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: php/login.php"); // Redirige al login si no hay sesión iniciada
    exit;
}


// Obtiene el nombre del usuario desde la base de datos
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT name FROM register WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
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
    <link rel="icon" href="Img/logo-vertical-blanco-connect.png" type="image/png">
    <link rel="stylesheet" href="css/styles.css">
    <title>UFPSOConnect - Register</title>
</head>
<body>
    

    <section>
        <div class="principal">
            <nav>
               <img src="Img/logo-alone.png" alt="UFPSO Icon">
               <h1>CONNECT</h1>
               
               <div class="navbar-section">
                   <a href="login.php" class="login-button">Login</a>
                   <a href="register.php" class="register-button active">Register</a>
               </div>
               <a href="php/logout.php" class="register-button active">Logout</a>
               <!-- <form action="" method="post">

                   <button type="submit" name="submit" class="register-button active">Logout</button>
                </form> -->
            </nav>

            <div class="content">
                <h2>Bienvenido, <?php echo $name; ?>!</h2>
                <p>If you already have an account, enter your email and institutional code to log in.</p>
                <div class="data-content">
                    <!-- FORM CONTENT   z -->
                    

                </div>
                <button> Create Account</button>
            </div>
            <!-- UFPSO image footer  -->
            <footer>
                <img src="Img/logo-vertical-blanco-connect-new.png" alt="">
            </footer>
            
        </div>
        
    </section>
    
</body>
</html>