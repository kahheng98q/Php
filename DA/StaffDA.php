<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php

require_once '..\DA\connectionDA.php';
require_once '..\Domain\Staff.php';
$id = "";

function getStaffLogin($email) {
    $UEmail = strtoupper($email);
    try {
        $conn = connectDB();
        $sql = "SELECT StaffPassword, StaffID FROM Staff WHERE UPPER(StaffEmail) = '$UEmail'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $GLOBALS['id'] = $row["StaffID"];
                return $row["StaffPassword"];
            }
        } else
            return 0;
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

function retrieveStaff() {
    try {
        $conn = connectDB();
        $id = $GLOBALS['id'];
        $sql = "SELECT * FROM Staff WHERE StaffID = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $staff = new Staff($id, $row["StaffName"], $row["StaffEmail"], $row["StaffPassword"], $row["Position"]);
        }
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
    return $staff;
}

function createStaff(Staff $staff) {
    $conn = connectDB();

    try {
        $stmt = $conn->prepare("INSERT INTO Staff VALUE (?,?,?,?,?)");
        $stmt->bind_param("sssss", $a, $b, $c, $d, $e);

        $a = $staff->getId();
        $b = $staff->getName();
        $c = $staff->getEmail();
        $d = $staff->getPass();
        $e = $staff->getPosition();
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } catch (SQLException $ex) {
        echo 'error: ' . $ex;
    }
}

function requestEmailS($email) {
    try {
        $conn = connectDB();

        $UEmail = strtoupper($email);
        $sql = "SELECT * FROM Staff WHERE UPPER(StaffEmail) = '$UEmail'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["StaffName"];
        } else
            return false;
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

function updatePasswordS($email, $password) {
    try {
        $conn = connectDB();

        $UEmail = strtoupper($email);
        $stmt = $conn->prepare("UPDATE Staff SET StaffPassword = ? WHERE UPPER(StaffEmail) = '$UEmail'");
        $stmt->bind_param("s", $a);

        $a = $password;
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

