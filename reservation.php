<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
session_start();
include("header.php");

function findRoomId($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, $roomType, $bedType, $allowedSmoking) {
    foreach ($roomRecords as $roomRecord) {
        if ($typeIdToDescription[$roomRecord['roomTypeId']] == $roomType
            && strpos($roomRecord['bedType'], $bedType)
            && $roomRecord['allowedSmoking'] == $allowedSmoking) {

            $roomId = $roomRecord['roomId'];
            $booked = false;
            foreach($dates as $date) {
                foreach ($roomBookedDateRecords as $roomBookedDateRecord) {
                    if ($roomBookedDateRecord['roomId'] == $roomId && $roomBookedDateRecord['bookedDate'] == $date) {
                        $booked = true;
                    }
                }
            }

            if (!$booked) {
                return $roomId;
            }
        }
    }
    return null;
}
?>
<main>
        <div id="errorBox">
        <?php
        // VALIDATION
        if (!empty($_POST)) {
            $error = false;
            // CUSTOMER INFORMATION
            if (empty($_POST["firstName"])) {
                echo "<p>First name must be entered. </p>";
                $error = true;
            }
            if (empty($_POST["lastName"])) {
                echo "<p> Last name must be entered. </p>";
                $error = true;
            }
            if (empty($_POST["address1"])) {
                echo "<p> Address must be entered. </p>";
                $error = true;
            }
            if (empty($_POST["city"])) {
                echo "<p> City must be entered. </p>";
                $error = true;
            }
            if (empty($_POST["zipcode"])) {
                echo "<p> Zipcode must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["zipcode"])) {
                if (!preg_match('/[0-9]{5}/', $_POST['zipcode'])) {
                    echo "<p>Zipcode is invalid.</p>";
                    $error = true;
                }
            }
            if (empty($_POST["state"]) || ($_POST["state"]) == 'NULL') {
                echo "<p> State must be selected. </p>";
                $error = true;
            }
            if (empty($_POST["phone"])) {
                echo "<p> Phone must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["phone"])) {
                if (!preg_match("/^[2-9]\d{2}-\d{3}-\d{4}$/", $_POST['phone'])) {
                    $error = true;
                    echo "<p>Phone number is invalid</p>";
                }
            }

            // PAYMENT INFORMATION
            if (empty($_POST["card"])) {
                echo "<p> Card number must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["card"])) {
                if (!preg_match("/(?:[0-9]{15,16})+/s", $_POST['card'])) {
                    $error = true;
                    echo "<p>Card number is invalid</p>";
                }
            }
            if (!empty($_POST["expMonth"])) {
                if (($_POST["expMonth"]) == '0') {
                    echo "<p> Month must be selected. </p>";
                    $error = true;
                }
            }
            if (!empty($_POST["expYear"])) {
                if ($_POST["expYear"] == '0') {
                    echo "<p> Year must be selected. </p>";
                    $error = true;
                }
            }

            // ROOM PREFERENCES
            if (empty($_POST["numberGuests"])) {
                echo "<p> Number of guests must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["numberGuests"])) {
                if (($_POST["numberGuests"]) > 5) {
                    echo "<p> Maximum number of guests is 4 for a suite.
                                  please book additional rooms.</p>";
                }
            }
            if ($_POST["children"] == '0') {
                $error = false;
            } elseif (empty($_POST["children"]) || $_POST["children"] == '9') {
                echo "<p> Children option must be selected. </p>";
                $error = true;
            }
            if (empty($_POST["bed"]) || $_POST["bed"] == '9') {
                echo "<p> Bed size must be selected. </p>";
                $error = true;
            }

            if ($_POST["smoking"] == '0') {
                $error = false;
            } elseif (empty($_POST["smoking"]) || $_POST["smoking"] == '9') {
                echo "<p> Smoking preference be selected. </p>";
                $error = true;
            }

            if ($_POST["cat"] == '0') {
                $error = false;
            } elseif (empty($_POST["cat"] || $_POST["cat"] == '9')) {
                echo "<p> Cat preference be selected. </p>";
                $error = true;
            }

            if ($_POST["breakfast"] == '0') {
                $error = false;
            } elseif (empty($_POST["breakfast"] || $_POST["breakfast"] == '9')) {
                echo "<p> Breakfast preference be selected. </p>";
                $error = true;
            }

            if (empty($_POST["checkinDate"])) {
                echo "<p> Check-in date must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["checkinDate"])) {
                date_default_timezone_set('America/New_York');
                $today = date('Y-m-d', time());
                $checkinDate = $_POST['checkinDate'];
                if ($checkinDate < $today) {
                    echo "<p> Check-in date must be more than today's date. </p>";
                    $error = true;
                }
            }
            if (empty($_POST["checkoutDate"])) {
                echo "<p> Check-out date must be entered. </p>";
                $error = true;
            }
            if (!empty($_POST["checkoutDate"])) {
                $checkinDate = $_POST['checkinDate'];
                if ($_POST['checkoutDate'] < $checkinDate) {
                    echo "<p> Check-out date must be more than today's date. </p>";
                    $error = true;
                }
            }

            // If Deluxe and Superior room was chosen with number of guests > 2.
            if (!empty($_POST["numberGuests"])) {
                if ($_POST["numberGuests"] > 2 && ($_POST["room"] == '1' || $_POST["room"] == '2')) {
                    echo "<p> Deluxe or Superior room can only have 2 guests maximum. </p>";
                    $error = true;
                }
            }

            // If smoking, then only 5th floor is available.
            if (!empty($_POST["smoking"]) && !empty($_POST["floor"])) {
                if ($_POST["smoking"] == '1' && $_POST["floor"] != '5') {
                    echo "<p> Smoking is only available on the 5th floor.</p>";
                    $error = true;
                }
            }

            // Loyalty card program
            if (!empty($_POST["loyaltyCard"])) {
                $loyaltyCard = $_POST['loyaltyCard'];
                $db = getDbConnection();
                $query = "SELECT EXISTS(SELECT * FROM loyalty_card WHERE loyaltyCardId = ?) AS result";
                $statement = $db->prepare($query);
                $statement->bind_param('s', $loyaltyCard);
                $statement->execute();
                $result = $statement->get_result();

                while ($loyalty = $result->fetch_assoc()) {
                    if ($loyalty["result"] == 1) {
                        $db = getDbConnection();
                        $query = "SELECT * FROM loyalty_card WHERE loyaltyCardId = ?";
                        $statement = $db->prepare($query);
                        $statement->bind_param('s', $loyaltyCard);
                        $statement->execute();
                        $result = $statement->get_result();

                        while ($loyaltyInfo = $result->fetch_assoc()) {
                            if ((strtolower($loyaltyInfo["memberFirstName"]) == strtolower($_POST["firstName"]))
                                && (strtolower($loyaltyInfo["memberLastName"]) == strtolower($_POST["lastName"]))) {
                                $error = false;
                            } else {
                            $error = true;
                            echo "<p> Please enter correct Loyalty number. </p>";
                            }
                        }
                    }
                        else if ($loyalty["result"] == 0) {
                        echo "<p> Please enter correct Loyalty number. </p>";
                    }
                }
            } else {
                $error = false;
            }


            if (!$error) {
                $start = strtotime($_POST['checkinDate']);
                $end = strtotime($_POST['checkoutDate']);
                $dates = getDateRange($start, $end);

                $startDate = convertToSqlDate($start);
                $endDate = convertToSqlDate($end);

                $typeIdToDescription = getTypeIdToDescription();
                $roomRecords = getRoomRecords();
                $roomBookedDateRecords = getRoomBookedDateRecords($startDate, $endDate);

                $roomType = "";
                if ($_POST['room'] == 1) {
                    $roomType = "Superior";
                } else if ($_POST['room'] == 2) {
                    $roomType = "Deluxe";
                } else if ($_POST['room'] == 3) {
                    $roomType = "Suite 1";
                } else if ($_POST['room'] == 4) {
                    $roomType = "Suite 2";
                }

                $bedType = "";
                if ($_POST['bed'] == 1) {
                    $bedType = "King";
                } else if ($_POST['bed'] == 2) {
                    $bedType = "Queen";
                }

                $roomId = findRoomId($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, $roomType, $bedType, $_POST['smoking']);

                if ($roomId == null) {
                    echo "<p> No room available for your current selection, please try another combination</p>";
                    $error = true;
                } else {
                    echo $roomId;
                    $_SESSION['roomId'] = $roomId;
                }
            }


            // ALL SUCCESSFUL
            if (!$error) {
                $_SESSION['firstName'] = $_POST['firstName'];
                $_SESSION['lastName'] = $_POST['lastName'];
                $_SESSION['address1'] = $_POST['address1'];
                $_SESSION['city'] = $_POST['city'];
                $_SESSION['state'] = $_POST['state'];
                $_SESSION['zipcode'] = $_POST['zipcode'];
                $_SESSION['phone'] = $_POST['phone'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['loyaltyCard'] = $_POST['loyaltyCard'];
                $_SESSION['numberGuests'] = $_POST['numberGuests'];
                $_SESSION['children'] = $_POST['children'];
                $_SESSION['room'] = $_POST['room'];
                $_SESSION['bed'] = $_POST['bed'];
                $_SESSION['smoking'] = $_POST['smoking'];
                $_SESSION['floor'] = $_POST['floor'];
                $_SESSION['checkinDate'] = $_POST['checkinDate'];
                $_SESSION['checkoutDate'] = $_POST['checkoutDate'];
                $_SESSION['cat'] = $_POST['cat'];
                $_SESSION['breakfast'] = $_POST["breakfast"];
                $_SESSION['card'] = $_POST["card"];

                if ($_SESSION['cat'] == '1') {
                    header("Location: cats.php");
                    exit;
                } else {
                    header("Location: confirmation.php");
                    exit;
                }
            }
        }
        ?>
        </div>
    <section>
        <div id="mainContainer">
            <div id="leftPanel">
                <div id="infoContainer">
                    <h3>Reservation Information</h3>
                    <p>Room and Bed Information</p>
                    <table>
                        <tr>
                            <th>Room Type</th>
                            <th>Floor</th>
                            <th>Bed Type</th>
                        </tr>
                        <tr>
                            <td>Superior</td>
                            <td>2nd, 3rd</td>
                            <td>Queen, King</td>
                        </tr>
                        <tr>
                            <td>Deluxe</td>
                            <td>4th, 5th</td>
                            <td>Queen, King</td>
                        </tr>
                        <tr>
                            <td>Suite Type 1</td>
                            <td>2nd, 3rd</td>
                            <td>Queen</td>
                        </tr>
                        <tr>
                            <td>Suite Type 2</td>
                            <td>4th, 5th</td>
                            <td>King</td>
                        </tr>
                    </table>

                    <p>Room Type and Rate</p>
                    <table>
                        <tr>
                            <th>Room Type</th>
                            <th>Rate per Night</th>
                        </tr>
                        <tr>
                            <td>Suite</td>
                            <td>$500</td>
                        </tr>
                        <tr>
                            <td>Deluxe</td>
                            <td>$350</td>
                        </tr>
                        <tr>
                            <td>Superior</td>
                            <td>$250</td>
                        </tr>
                    </table>

                    <p>Number of Guests</p>
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Maximum Number of Guests Allowed</th>
                        </tr>
                        <tr>
                            <td>Suite</td>
                            <td>Maximum 4 Guests</td>
                        </tr>
                        <tr>
                            <td>Deluxe</td>
                            <td>Maximum 2 Guests</td>
                        </tr>
                        <tr>
                            <td>Superior</td>
                            <td>Maximum 2 Guests</td>
                        </tr>
                    </table>
                    <p>Smoking is only allowed in all 5th floor rooms.</p>
                    <p>Breakfast is free with a loyalty card.</p>
                    <img src="images/cats/cat.jpg" alt="cat">
                </div>
            </div>
            <div id="rightPanel">
            <div id="formContainer">
                <div id="checkoutTable">
                    <form id="checkoutForm" method="post" action="reservation.php">
                    <h3>Customer Information</h3>
                        <table>
                            <tr>
                                <th><label for="firstName">First Name</label></th>
                                <td><input class="inputField" type="text" id="firstName" name="firstName" placeholder="Jone"
                                        <?php
                                        if (isset($_POST["firstName"])) echo "value='" . $_POST["firstName"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="lastName">Last Name</label></th>
                                <td><input class="inputField" type="text" id="lastName" name="lastName" placeholder="Doe"
                                        <?php
                                        if (isset($_POST["lastName"])) echo "value='" . $_POST["lastName"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="address1">Address 1</label></th>
                                <td><input class="inputField" type="text" id="address1" name="address1" placeholder="1234 Jane st"
                                        <?php
                                        if (isset($_POST["address1"])) echo "value='" . $_POST["address1"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="address2">Address 2</label></th>
                                <td><input class="inputField" type="text" id="address2" name="address2" placeholder="Apt 1"</td>
                            </tr>
                            <tr>
                                <th><label for="city">City</label></th>
                                <td><input class="inputField" type="text" id="city" name="city" placeholder="New York"
                                        <?php
                                        if (isset($_POST["city"])) echo "value='" . $_POST["city"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="state">State</label></th>
                                <td><select id="state" name="state">
                                        <?php

                                        $db = getDbConnection();
                                        $query ="SELECT * FROM states";
                                        $statement = $db->prepare($query);
                                        $statement->execute();
                                        $result = $statement->get_result();
                                        $states = $result->fetch_all(MYSQLI_ASSOC);

                                        foreach($states as $state){
                                            $selected = '';
                                            if(isset($_POST["state"]) && $_POST["state"] == $state['stateId'] ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='$state[stateId]' {$selected}>{$state['stateAbbreviation']}</option>";
                                        }
                                        ?></select></td>
                            </tr>
                            <tr>
                                <th><label for="zipcode">Zipcode</label></th>
                                <td><input class="inputField" type="text" id="zipcode" name="zipcode" placeholder="10001"
                                        <?php
                                        if (isset($_POST["zipcode"])) echo "value='" . $_POST["zipcode"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="phone">Phone Number</label></th>
                                <td><input class="inputField" type="text" id="phone" name="phone" placeholder="xxx-xxx-xxxx"
                                        <?php
                                        if (isset($_POST["phone"])) echo "value='" . $_POST["phone"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="email">Email Address</label></th>
                                <td><input class="inputField" type="email" id="email" name="email" placeholder="abc@nyu.edu"
                                        <?php
                                        if (isset($_POST["email"])) echo "value='" . $_POST["email"] . "'";
                                        ?>></td>
                            </tr>
                        </table>
                        <h3>Payment Information</h3>
                        <table>
                            <tr>
                                <th><label for="card">Credit Card</label></th>
                                <td><input class="inputField" type="text" id="card" name="card" placeholder="Numbers without space"
                                        <?php
                                        if (isset($_POST["card"])) echo "value='" . $_POST["card"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="expDate">Expiration Date</label></th>
                                <td><select id="expMonth" name="expMonth">
                                        <?php
                                        $months = array('0' => 'Select Month',
                                            '1' => 'January',
                                            '2' => 'February',
                                            '3' => 'March',
                                            '4' => 'April',
                                            '5' => 'May',
                                            '6' => 'June',
                                            '7' => 'July',
                                            '8' => 'August',
                                            '9' => 'September',
                                            '10' => 'October',
                                            '11' => 'November',
                                            '12' => 'December'
                                        );
                                        foreach($months as $key => $value ){
                                            $selected = '';
                                            if(isset($_POST["expMonth"]) && $_POST["expMonth"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                    <select id="expYear" name="expYear">
                                        <option value="0">Select Year</option>
                                        <?php
                                        $currentYear = 2020;
                                        foreach(range($currentYear, $currentYear+10) as $year) {
                                            $selected = '';
                                            if(isset($_POST["expYear"]) && $_POST["expYear"] == $year) {
                                                $selected = 'selected';
                                            }
                                            echo "<option value='$year' $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <h3>Room Preference</h3>
                        <table>
                            <tr>
                                <th><label for="numberGuests">Number of Guests</label></th>
                                <td><input type="number" id="numberGuests" name="numberGuests" placeholder="1" min = '1'
                                        <?php
                                        if (isset($_POST["numberGuests"])) echo "value='" . $_POST["numberGuests"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="children">Any Children?</label></th>
                                <td><select id="children" name="children">
                                        <?php
                                        $children = array('9' => 'Please select Yes or No.',
                                            '1' => 'Yes',
                                            '0' => 'No',
                                        );
                                        foreach($children as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["children"]) && $_POST["children"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="cat">Cat Preference</label></th>
                                <td><select id="cat" name="cat">
                                        <?php
                                        $catPref = array('9' => 'Please choose cat preference.',
                                            '1' => 'I like to have a cat in my room!',
                                            '0' => 'No cat in the room.',
                                        );
                                        foreach($catPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["cat"]) && $_POST["cat"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="room">Room Preference</label></th>
                                <td><select id="room" name="room">
                                        <?php
                                        $roomPref = array('9' => 'Please choose room preference.',
                                            '1' => 'Superior',
                                            '2' => 'Deluxe',
                                            '3' => 'Suite 1',
                                            '4' => 'Suite 2'
                                        );
                                        foreach($roomPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["room"]) && $_POST["room"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="bed">Bed Size Preference</label></th>
                                <td><select id="bed" name="bed">
                                        <?php
                                        $bedPref = array('9' => 'Please choose bed preference.',
                                            '1' => '1 King Bed',
                                            '2' => '2 Queen Beds',
                                        );
                                        foreach($bedPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["bed"]) && $_POST["bed"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="smoking">Smoking Preference</label></th>
                                <td><select id="smoking" name="smoking">
                                        <?php
                                        $smokingPref = array('9' => 'Please choose smoking preference.',
                                            '1' => 'Yes',
                                            '0' => 'No',
                                        );
                                        foreach($smokingPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["smoking"]) && $_POST["smoking"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="floor">Floor Preference</label></th>
                                <td><select id="floor" name="floor">
                                        <?php
                                        $floorPref = array('9' => 'Please choose floor preference.',
                                            '2' => '2nd Floor',
                                            '3' => '3rd Floor',
                                            '4' => '4th Floor',
                                            '5' => '5th Floor'
                                        );
                                        foreach($floorPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["floor"]) && $_POST["floor"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="breakfast">Breakfast Preference</label></th>
                                <td><select id="breakfast" name="breakfast">
                                        <?php
                                        $bfPref = array('9' => 'Please choose breakfast preference.',
                                            '1' => 'Yes, $20 without the loyalty card',
                                            '0' => 'No',
                                        );
                                        foreach($bfPref as $key => $value){
                                            $selected = '';
                                            if(isset($_POST["breakfast"]) && $_POST["breakfast"] == $key ){
                                                $selected = 'selected';
                                            }
                                            echo "<option value='{$key}' {$selected}>{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="checkinDate">Check-in Date</label></th>
                                <td><input type="date" id="checkinDate" name="checkinDate"
                                    <?php
                                    if (isset($_POST["checkinDate"])) echo "value='" . $_POST["checkinDate"] . "'";
                                    ?>></td>
                            </tr>
                            <tr>
                                <th><label for="checkoutDate">Check-out Date</label></th>
                                <td><input type="date" id="checkoutDate" name="checkoutDate"
                                        <?php
                                        if (isset($_POST["checkoutDate"])) echo "value='" . $_POST["checkoutDate"] . "'";
                                        ?>></td>
                            </tr>
                            <tr>
                                <th><label for="loyaltyCard">Loyalty Card Number</label></th>
                                <td><input type="text" id="loyaltyCard" name="loyaltyCard" placeholder="Ex) 330000"
                                        <?php
                                        if (isset($_POST["loyaltyCard"])) echo "value='" . $_POST["loyaltyCard"] . "'";
                                        ?>></td>
                            </tr>
                        </table>
                        <input id="submitButton" type="submit" name="submit" value="Submit">
                    </form>
                    </div>
            </div>
            </div>
        </div>
    </section>
</main>
<?php
include("footer.php");
?>
</body>
</html>