<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db.php';
$action = $_GET['action'] ?? '';

// GET ALL ASSIGNMENTS
if ($action == "get_all") {
    $query = "SELECT e.fname, e.lname, 
                     p.proj_name, w.hours,
                     w.emp_ssn, w.proj_number
              FROM works_on w
              JOIN employee e ON w.emp_ssn = e.ssn
              JOIN project p ON w.proj_number = p.proj_number";
    $result = mysqli_query($conn, $query);
    echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// ADD ASSIGNMENT
if ($action == "add") {
    $emp_ssn     = $_POST['emp_ssn'];
    $proj_number = $_POST['proj_number'];
    $hours       = $_POST['hours'];

    $query = "INSERT INTO works_on (emp_ssn, proj_number, hours)
              VALUES ('$emp_ssn','$proj_number','$hours')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Assignment added!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// DELETE ASSIGNMENT
if ($action == "delete") {
    $emp_ssn     = $_GET['emp_ssn'];
    $proj_number = $_GET['proj_number'];
    $query = "DELETE FROM works_on 
              WHERE emp_ssn='$emp_ssn' 
              AND proj_number='$proj_number'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Assignment deleted!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// UPDATE HOURS
if ($action == "update") {
    $emp_ssn     = $_POST['emp_ssn'];
    $proj_number = $_POST['proj_number'];
    $hours       = $_POST['hours'];

    $query = "UPDATE works_on SET hours='$hours'
              WHERE emp_ssn='$emp_ssn' 
              AND proj_number='$proj_number'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Hours updated!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>