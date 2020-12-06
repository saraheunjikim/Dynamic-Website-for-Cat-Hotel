<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/adminHome.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
include("header.php");

function getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, $roomType, $bedType, $allowedSmoking) {
    $result = array();
    foreach ($dates as $date) {
        $result[$date] = 0;
        foreach ($roomRecords as $roomRecord) {
            if ($typeIdToDescription[$roomRecord['roomTypeId']] == $roomType
                && strpos($roomRecord['bedType'], $bedType)
                && $roomRecord['allowedSmoking'] == $allowedSmoking) {

                $roomId = $roomRecord['roomId'];
                $booked = false;

                foreach ($roomBookedDateRecords as $roomBookedDateRecord) {
                    if ($roomBookedDateRecord['roomId'] == $roomId && $roomBookedDateRecord['bookedDate'] == $date) {
                        $booked = true;
                    }
                }

                if (!$booked) {
                    $result[$date]++;
                }
            }
        }
    }
    return $result;
}

function populateTableRow($tableRow) {
    foreach ($tableRow as $date => $num) {
        echo "<th>$num</th>";
    }
}
?>
    <main>
        <div>
            <select name="week" id="week">
                <?php
                $mondayTimestamp = strtotime("Monday +0 week");
                $sundayTimestamp = strtotime("Sunday +1 week");
                $dates = getDateRange($mondayTimestamp, $sundayTimestamp);

                $monday = convertToSqlDate($mondayTimestamp);
                $sunday = convertToSqlDate($sundayTimestamp);

                echo "<option value='selectedWeek'>$monday - $sunday</option>";

                $typeIdToDescription = getTypeIdToDescription();
                $roomRecords = getRoomRecords();
                $roomBookedDateRecords = getRoomBookedDateRecords($monday, $sunday);

                $superiorQueenNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Superior', 'Queen', 0);
                $superiorKingNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Superior', 'King', 0);
                $deluxeQueenNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Deluxe', 'Queen', 0);
                $deluxeQueenSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Deluxe', 'Queen', 1);
                $deluxeKingNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Deluxe', 'King', 0);
                $deluxeKingSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Deluxe', 'King', 1);
                $suiteQueenNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Suite 1', 'Queen', 0);
                $suiteKingNonSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Suite 2', 'King', 0);
                $suiteKingSmoking = getTableRow($typeIdToDescription, $roomRecords, $roomBookedDateRecords, $dates, 'Suite 2', 'King', 1);
                ?>
            </select>
        </div>
        <div>
            <table id="roomTableContainer">
                <tr>
                    <th class="tableHead">Type</th>
                    <th class="tableHead">Monday</th>
                    <th class="tableHead">Tuesday</th>
                    <th class="tableHead">Wednesday</th>
                    <th class="tableHead">Thursday</th>
                    <th class="tableHead">Friday</th>
                    <th class="tableHead">Saturday</th>
                    <th class="tableHead">Sunday</th>
                </tr>
                <tr>
                    <td>Superior/Queen/Non-smoking</td>
                    <?php
                    populateTableRow($superiorQueenNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Superior/King/Non-smoking</td>
                    <?php
                    populateTableRow($superiorKingNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Deluxe/Queen/Non-smoking</td>
                    <?php
                    populateTableRow($deluxeQueenNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Deluxe/Queen/Smoking</td>
                    <?php
                    populateTableRow($deluxeQueenSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Deluxe/King/Non-smoking</td>
                    <?php
                    populateTableRow($deluxeKingNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Deluxe/King/Smoking</td>
                    <?php
                    populateTableRow($deluxeKingSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Suite/Queen/Non-smoking</td>
                    <?php
                    populateTableRow($suiteQueenNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Suite/King/Non-smoking</td>
                    <?php
                    populateTableRow($suiteKingNonSmoking);
                    ?>
                </tr>
                <tr>
                    <td>Suite/King/Smoking</td>
                    <?php
                    populateTableRow($suiteKingSmoking);
                    ?>
                </tr>
            </table>
        </div>
    </main>
</body>