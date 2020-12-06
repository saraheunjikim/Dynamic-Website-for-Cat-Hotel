<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/cats.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
session_start();
include("header.php");
?>
<section>
        <div class="contentsContainer">
            <div class="catsContainer">
                <h3> Here is available cats for your room!</h3>
                <?php
                if ($_SESSION['cat'] == '1' && $_SESSION['children'] == '0') {
                    $db = getDbConnection();
                    $query = "SELECT * FROM cat WHERE activityLevelId = '101' AND goodWithKids = '0' AND catStatusId = '112'";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $result = $statement->get_result();
                    $cat = $result->fetch_assoc();

                    if ($cat == null) {
                        echo "Sorry No Available cats this time!
                                <a href='confirmation.php'>
                                <button class='button buttonNoCats'>Continue to Confirmation Page.</button>
                                </a>";
                    } else {
                        while ($cat = $result->fetch_assoc()) {
                            echo "<div class='catItem'>
                                  <img src='images/cats/$cat[image].png' alt='$cat[image]'>
                                  <ul>
                                      <li class='name'> $cat[catName] </li>
                                      <li class='age'> $cat[catAge] years old</li>";
                                      if ($cat['coatLengthId'] == '108') {
                                          echo "<li class='hair'> Short Hair</li> ";
                                      } else {
                                          echo "<li class='hair'> Long Hair </li>";
                                      }
                                      echo "<li class='gender'> Gender: $cat[catGender] </li></ul>
                                  <div class='buttons'> 
                                      <a href='confirmation.php?catId=$cat[catId]'> 
                                      <button class='button buttonRoom'>Add to Room</button> 
                                      </a>
                                  </div> 
                              </div>";
                        }
                    }
                } elseif ($_SESSION['cat'] == '1' && $_SESSION['children'] == '1'){
                    $db = getDbConnection();
                    $query = "SELECT * FROM cat WHERE activityLevelId = '101' AND goodWithKids = '1' AND catStatusId = '112'";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $result = $statement->get_result();
                    $cat = $result->fetch_assoc();
                    if ($cat == null) {
                        echo "Sorry No Available cats this time!
                                <a href='confirmation.php'>
                                <button class='button buttonNoCats'>Continue to Confirmation Page.</button>
                                </a>";
                    } else {
                        while ($cat = $result->fetch_assoc()) {
                            echo "<div class='catItem'>
                                      <img src='images/cats/$cat[image].png' alt='$cat[image]'>
                                      <ul>
                                          <li class='name'> $cat[catName] </li>
                                          <li class='age'> $cat[catAge] years old</li>
                                          <li class='goodWithKids'>Kids Friendly!</li>";
                        if ($cat['coatLengthId'] == '108') {
                            echo "<li class='hair'> Short Hair</li> </ul>";
                        } else {
                            echo "<li class='hair'> Long Hair </li> </ul>";
                        }
                        echo "<li class='gender'> Gender: $cat[catGender] </li></ul>
                                      <div class='buttons'> 
                                          <a href='confirmation.php?catId=$cat[catId]'> 
                                          <button class='button buttonRoom'>Add to Room</button> 
                                          </a>
                                      </div> 
                              </div>";
                        }
                    }
                }
                ?>
            </div>
</section>
</main>
</body>
<?php
include("footer.php");
?>
</html>