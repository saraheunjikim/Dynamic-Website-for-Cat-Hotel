<header>
    <div class="headerContainer">
        <div class="logoContainer">
            <a href="index.php">
            <img src="images/icons/meowtel_logo.png" alt="logo">
            </a>
        </div>
        <div class="navBar">
            <ul>
                <li><a href="index.php">MeowTel</a></li>
                <li><a href="aboutUs.php">About Us</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="adminLogin.php">Admin Login</a></li>
                <li><p>+ 1 197 545 5455</p></li>
            </ul>
        </div>
    </div>
    <?php
    function getDbConnection()
    {
        return new mysqli('127.0.0.1', 'root', 'password', 'meowtel');
    }
    function executeStatement($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getDateRange($first, $last)
    {
        $dates = array();
        $step = '+1 day';
        $current = $first;

        while ($current <= $last) {
            $dates[] = convertToSqlDate($current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    function convertToSqlDate($unixTimestamp)
    {
        return date('Y-m-d', $unixTimestamp);
    }

    function getTypeIdToDescription() {
        $db = getDbConnection();
        $query = "SELECT roomTypeId, roomDescription FROM room_type";
        $stmt = $db->prepare($query);
        $roomTypeRecords = executeStatement($stmt);
        $typeIdToDescription = array();
        foreach ($roomTypeRecords as $roomTypeRecord) {
            $typeIdToDescription[$roomTypeRecord['roomTypeId']] = $roomTypeRecord['roomDescription'];
        }

        return $typeIdToDescription;
    }

    function getRoomRecords() {
        $db = getDbConnection();
        $query = "SELECT roomId, roomTypeId, allowedSmoking, bedType FROM room";
        $stmt = $db->prepare($query);
        return executeStatement($stmt);
    }

    function getRoomBookedDateRecords($start, $end) {
        $db = getDbConnection();
        $query = "SELECT roomId, bookedDate FROM room_booked_dates WHERE bookedDate >= ? AND bookedDate <= ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $start, $end);
        return executeStatement($stmt);
    }
    ?>
</header>


