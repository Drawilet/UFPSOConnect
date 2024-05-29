
<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // VALIDATE IF THE USERNAME ISN'T EMPTY
    if (empty($username)) {
        echo "<script>alert('Username cannot be empty');</script>";
    } else {
        // PREPARE THE CONSULT FOR THE USERNAME
        $stmt = $conn->prepare("SELECT * FROM register WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username already taken');</script>";
        } else {
            // INSERT THE NEW USERNAME IF IS AVAILABLE
            $insert = $conn->prepare("INSERT INTO users (username) VALUES (?)");
            $insert->bind_param("s", $username);
            if ($insert->execute()) {
                echo "<script>alert('User profile saved successfully');</script>";
            } else {
                echo "<script>alert('Error saving user profile');</script>";
            }
        }
        $stmt->close();
    }
    $conn->close();
}


// CONSULT THE UPDATE
$updateQuery = "UPDATE register SET profile_complete = 1 WHERE id = ?";

// PREPARE THE CONSULT
$stmt = $conn->prepare($updateQuery);

$stmt->bind_param("i", $userId);

// EXECUTE THE CONSULT
$stmt->execute();

// CLOSE THE CONSULT AND CONNECTION
$stmt->close();
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="UFPSO, Connect, Universidad Francisco de Paula Santander, Red   Social" />
  <meta name="keywords" content="UFPSOConnect, Red Social UFPSO, Blog, Universidad, Comunicacion, Frontend, Desarrollo web" />
  <meta name="description" content="Portal para acceder a la red social de la UFPSO" />
  <link rel="author" href="" />
  <link rel="icon" href="../img/logo-vertical-blanco-connect.png" type="image/png" />
  <link rel="stylesheet" href="../css/styles.css" type="text/css" />
  <link rel="stylesheet" href="../css/config-user.css" type="text/css" />
  <title>UFPSOConnect - User Config</title>
</head>

<body>
  <section>
    <div class="principal">
      <nav>
        <img src="../Img/logo-alone.png" alt="UFPSO Icon" />
        <h1>CONNECT</h1>
      </nav>

      <div class="content">
        <h2>Configure your profile</h2>

        <div class="user-content">
          <h3>Create your username</h3>
          <form id="profileForm" action="check-username.php" method="POST">
          <div id="username-status">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'invalid') {
                    echo '<p style="color: red;">Username must be between 5 and 15 characters and can only contain letters, numbers, and underscores.</p>';
                } elseif ($_GET['error'] == 'exists') {
                    echo '<p style="color: red;">Username already taken.</p>';
                } elseif ($_GET['error'] == 'access') {
                    echo '<p style="color: red;">Invalid access to script.</p>';
                }
            }
            ?>
            <div id="message"></div>
        </div>
            <input type="text" name="username" placeholder="@username" id="input-user" onkeyup="validateUsername()" />
            
            <button type="submit">Check Availability</button>
          </form>

          <div class="image-content">
            <h3>Select your image profile</h3>
            <input accept="image/*" type="file" id="img-profile" class="img-profile" />
            <div class="file-select" id="src-file">
              <input type="file" name="src-file" aria-label="Archivo" />
            </div>
          </div>
        </div>

        <div class="card-profile">
          <div class="principal-card-content">
            <div class="img">
              <img src="../Img/user.jpg" alt="" />
            </div>
            <div class="content-row">
              <div class="one">
                <h3>Jeferson Mesa</h3>
                <h4 id="username-text">@username</h4>
              </div>
              <div class="two">Available</div>
              <div class="icon">
                <i class="fa-sharp fa-solid fa-heart"></i>
              </div>
            </div>
          </div>

          <div class="second-card-content">
            <div class="followers">
              <h3>754</h3>
              <p>Followers</p>
            </div>

            <div class="posts">
              <h3>54</h3>
              <p>posts</p>
            </div>

            <div class="friends">
              <h3>125</h3>
              <p>Friends</p>
            </div>
          </div>
        </div>
      </div>
      <!-- UFPSO image footer  -->
      <footer>
        <img src="../Img/logo-vertical-blanco-connect-new.png" alt="" />
      </footer>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/script.js"></script>
  <script src="https://kit.fontawesome.com/2739a6b5b8.js" crossorigin="anonymous"></script>
</body>

</html>