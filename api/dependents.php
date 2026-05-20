<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db.php';
$action = $_GET['action'] ?? '';

// GET ALL DEPENDENTS
if ($action == "get_all") {
    $query = "SELECT d.dep_name, d.sex, 
                     d.birth_date, d.relationship,
                     e.fname, e.lname, d.emp_ssn
              FROM dependent d
              JOIN employee e ON d.emp_ssn = e.ssn";
    $result = mysqli_query($conn, $query);
    echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// ADD DEPENDENT
if ($action == "add") {
    $emp_ssn      = $_POST['emp_ssn'];
    $dep_name     = $_POST['dep_name'];
    $sex          = $_POST['sex'];
    $birth_date   = $_POST['birth_date'];
    $relationship = $_POST['relationship'];

    $query = "INSERT INTO dependent 
              (emp_ssn, dep_name, sex, birth_date, relationship)
              VALUES 
              ('$emp_ssn','$dep_name','$sex','$birth_date','$relationship')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Dependent added!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// DELETE DEPENDENT
if ($action == "delete") {
    $emp_ssn  = $_GET['emp_ssn'];
    $dep_name = $_GET['dep_name'];
    $query = "DELETE FROM dependent 
              WHERE emp_ssn='$emp_ssn' 
              AND dep_name='$dep_name'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Dependent deleted!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>