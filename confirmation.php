<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/confirmation.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
session_start();
include("header.php");
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$addressStreet = $_SESSION["address1"];
$addressCity = $_SESSION["city"];
$addressState = $_SESSION["state"];
$addressZip = $_SESSION["zipcode"];
$phone = $_SESSION["phone"];
$email = $_SESSION["email"];
$loyaltyCard = $_SESSION["loyaltyCard"];
$date = date("Y-m-d");
$checkIn = $_SESSION["checkinDate"];
$checkOut = $_SESSION["checkoutDate"];
$numberGuests = $_SESSION['numberGuests'];
$child = $_SESSION['children'];
$roomType = $_SESSION['room'];
$bedType = $_SESSION['bed'];
$smoke = $_SESSION['smoking'];
$floor = $_SESSION['floor'];
$cat = $_SESSION['cat'];
$card = $_SESSION['card'];
$date_diff = range($checkIn,$checkOut);
$roomId = $_SESSION['roomId'];
$breakfast = $_SESSION['breakfast'];


$db = getDbConnection();

$sql = "INSERT INTO guest (guestFirstName, guestLastName, guestPhone, guestEmail, addressStreet, addressCity, addressState, addressZip, loyaltyCardNumber) 
VALUES ('$firstName', '$lastName', '$phone', '$email', '$addressStreet', '$addressCity', '$addressState', '$addressZip', '$loyaltyCard')";
$stmt = $db->prepare($sql);
$db->query($sql);
$guestId= $db->insert_id;

$start = strtotime($_SESSION['checkinDate']);
$end = strtotime($_SESSION['checkoutDate']);
$startDate = convertToSqlDate($start);
$endDate = convertToSqlDate($end);

$sql = "INSERT INTO reservation (guestId, reservationDate, checkInDate, checkOutDate, guestNo, children, catInRoom, wantBreakfast,smokingPreference)
VALUES ('$guestId','$date','$startDate','$endDate','$numberGuests','$child','$cat','$breakfast', '$smoke')";
$stmt = $db->prepare($sql);
$db->query($sql);
$reservationId= $db->insert_id;

$sql = "INSERT INTO payment (guestId, paymentDate, firstName, lastName, cardNumber)
VALUES ('$guestId', '$date', '$firstName', '$lastName','$card')";
$stmt = $db->prepare($sql);
$db->query($sql);

$dates = getDateRange($start, $end);
foreach ($dates as $d) {
    $sql = "INSERT INTO room_booked_dates (reservationId, roomId, bookedDate) VALUES ('$reservationId', '$roomId', '$d')";
    $stmt = $db->prepare($sql);
    $db->query($sql);
}

// Cat is selected
if (isset($_GET['catId'])) {
    $catId = $_GET['catId'];
    $sql = "UPDATE cat SET catStatusId = '111' WHERE catId = $catId";
    $stmt = $db->prepare($sql);
    $db->query($sql);

    $sql2 = "INSERT INTO cat_assignment (reservationId, catId) VALUES ('$reservationId', '$catId')";
    $stmt2 = $db->prepare($sql2);
    $db->query($sql2);
}
?>
<main>
    <section>
        <div id="mainContainer">
            <div id="leftPanel">
                <div id="formContainer">
                    <h2> Confirmation </h2>
                    <div id="checkoutTotals">
                        <table>
                            <?php
                            if (isset($catId)) {
                                $db = getDbConnection();
                                $query = "SELECT * FROM cat WHERE catId = ?";
                                $statement = $db->prepare($query);
                                $statement->bind_param('i', $catId);
                                $statement->execute();
                                $result = $statement->get_result();

                                while ($cat = $result->fetch_assoc()) {
                                    echo "<tr>
                                <td class='head'>Your Cat</td>
                                <td> <img src='images/cats/$cat[image].png' alt='$cat[image]'> </td>
                                </tr>";
                                }
                            } elseif (!isset($_GET['catId'])) {
                                echo "<tr>
                                <td class='head'>Your Cat</td>
                                <td> No cat.</td>
                                </tr>";
                            }
                            ?>
                            <tr>
                                <td class="head">Reservation #</td>
                                <td><?php echo $reservationId?></td>
                            </tr>
                            <tr>
                                <td class="head">Number of Guests</td>
                                <td><?php echo $numberGuests?></td>
                            </tr>
                            <tr>
                                <td class="head">Room Type</td>
                                <td><?php if($roomType == 1 ) echo "Superior";
                                    elseif ($roomType == 2) echo "Deluxe";
                                    elseif ($roomType == 3) echo"Suite 1";
                                    else echo "Suite 2";?></td>
                            </tr>
                            <tr>
                                <td class="head">Bed Type</td>
                                <td><?php if($bedType == 1) echo "1 King Bed";
                                        else echo "2 Queen Beds"?></td>
                            </tr>
                            <tr>
                                <td class="head">Smoking Preference</td>
                                <td><?php
                                    if ($smoke == 0) {
                                        echo "No";
                                    } else {
                                        echo "Yes";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                        <?php
                        if ($breakfast == 1) {
                            echo "
                            <table>
                            <tr>
                                <td class='head'>Breakfast per Person</td>
                                <td>$20</td>
                            </tr>
                            <tr>
                                <td class='head total'>Total Breakfast Cost</td>                           
                            ";
                            $breakfastCost = 0;
                            if ($loyaltyCard == null || empty($loyaltyCard)) {
                                $breakfastCost = $numberGuests * 20;
                            }
                            echo "<td class='total'>$$breakfastCost</td>";
                            echo "</tr></table>";
                        }
                        ?>
                        <table>
                            <tr>
                                <td class="head">Number of Nights</td>
                                <td>
                                    <?php
                                    $nights = count($dates) - 1;
                                    echo $nights;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="head">Rate Per Night</td>
                                <td>
                                    <?php
                                    $rate = 0;
                                    if ($roomType == 1) {
                                        $rate = 250;
                                    } else if ($roomType == 2) {
                                        $rate = 350;
                                    } else {
                                        $rate = 500;
                                    }
                                    echo '$' . $rate;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="head total">Total Rate</td>
                                <td class="total">
                                    <?php
                                    $roomCost = $rate * $nights;
                                    echo "$" . $roomCost;
                                    ?>
                                </td>
                            </tr>
                        </table>

                        <div id="totalReservation">
                            <h3> Total Reservation Cost </h3>
                            <p>
                                <b>
                                    <?php
                                    if (!isset($breakfastCost)) {
                                        echo '$' . $roomCost;
                                    } else {
                                        $totalCost = $breakfastCost + $roomCost;
                                        echo '$' . $totalCost;
                                    }
                                    ?>
                                </b>
                            </p>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
<?php
include("footer.php");
session_destroy()
?>
</body>
</html>