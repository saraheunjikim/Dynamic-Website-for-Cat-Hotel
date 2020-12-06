<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/adminLogin.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
include("header.php");
?>
    <main>
        <section>
            <form action="adminLogin.php" method="post">
                <div class="avatarContainer">
                    <img src="images/admin/admin_avatar.png" alt="avatar" class="avatar">
                </div>
                <?php
                if (count($_POST) != 0) {
                    $error = false;
                    if ($_POST['username'] == "") {
                        echo "<p class='checkoutFormErrors'>Username is empty</p>";
                        $error = true;
                    }

                    if ($_POST['password'] == "") {
                        echo "<p class='checkoutFormErrors'>Password is empty</p>";
                        $error = true;
                    }

                    if ($_POST['username'] != "" && $_POST['password'] != "") {
                        $db = getDbConnection();
                        $query = "SELECT username, password FROM admin WHERE admin.username = ? AND admin.password = ?";
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
                        $result = executeStatement($stmt);

                        if ($result == NULL) {
                            echo "<p class='checkoutFormErrors'>Username or password is not correct</p>";
                            $error = true;
                        }
                    }

                    if (!$error) {
                        header("Location: adminHome.php");
                        exit;
                    }
                }
                ?>
                <div class="container">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" required>

                    <button type="submit">Login</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>
            </form>
        </section>
    </main>
</body>