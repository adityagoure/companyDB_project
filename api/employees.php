<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

$action = $_GET['action'] ?? '';

// GET ALL EMPLOYEES
if ($action == "get_all") {
    $query = "SELECT e.ssn, e.fname, e.minit, e.lname, 
                     e.bdate, e.address, e.sex, e.salary,
                     d.dept_name, e.supervisor_ssn, e.dept_number
              FROM employee e
              LEFT JOIN department d ON e.dept_number = d.dept_number";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($data);
}

// ADD EMPLOYEE
if ($action == "add") {
    $ssn        = mysqli_real_escape_string($conn, $_POST['ssn']);
    $fname      = mysqli_real_escape_string($conn, $_POST['fname']);
    $minit      = mysqli_real_escape_string($conn, $_POST['minit']);
    $lname      = mysqli_real_escape_string($conn, $_POST['lname']);
    $bdate      = mysqli_real_escape_string($conn, $_POST['bdate']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $sex        = mysqli_real_escape_string($conn, $_POST['sex']);
    $salary     = mysqli_real_escape_string($conn, $_POST['salary']);
    $dept       = mysqli_real_escape_string($conn, $_POST['dept_number']);
    $supervisor = mysqli_real_escape_string($conn, $_POST['supervisor_ssn']);

    // Handle empty supervisor — use NULL instead of empty string
    $sup_value = ($supervisor == '' || $supervisor == 'null') ? "NULL" : "'$supervisor'";
    // Handle empty dept
    $dept_value = ($dept == '') ? "NULL" : "'$dept'";

    $query = "INSERT INTO employee 
              (ssn, fname, minit, lname, bdate, address, sex, salary, dept_number, supervisor_ssn)
              VALUES 
              ('$ssn','$fname','$minit','$lname','$bdate','$address','$sex','$salary',$dept_value,$sup_value)";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Employee added!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// UPDATE EMPLOYEE
if ($action == "update") {
    $ssn        = mysqli_real_escape_string($conn, $_POST['ssn']);
    $fname      = mysqli_real_escape_string($conn, $_POST['fname']);
    $minit      = mysqli_real_escape_string($conn, $_POST['minit']);
    $lname      = mysqli_real_escape_string($conn, $_POST['lname']);
    $bdate      = mysqli_real_escape_string($conn, $_POST['bdate']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $sex        = mysqli_real_escape_string($conn, $_POST['sex']);
    $salary     = mysqli_real_escape_string($conn, $_POST['salary']);
    $dept       = mysqli_real_escape_string($conn, $_POST['dept_number']);
    $supervisor = mysqli_real_escape_string($conn, $_POST['supervisor_ssn']);

    $sup_value  = ($supervisor == '' || $supervisor == 'null') ? "NULL" : "'$supervisor'";
    $dept_value = ($dept == '') ? "NULL" : "'$dept'";

    $query = "UPDATE employee 
              SET fname='$fname', minit='$minit', lname='$lname',
                  bdate='$bdate', address='$address', sex='$sex',
                  salary='$salary', dept_number=$dept_value,
                  supervisor_ssn=$sup_value
              WHERE ssn='$ssn'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Employee updated!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// DELETE EMPLOYEE
if ($action == "delete") {
    $ssn = mysqli_real_escape_string($conn, $_GET['ssn']);
    $query = "DELETE FROM employee WHERE ssn='$ssn'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Employee deleted!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// GET SINGLE EMPLOYEE
if ($action == "get_one") {
    $ssn = mysqli_real_escape_string($conn, $_GET['ssn']);
    $query = "SELECT * FROM employee WHERE ssn='$ssn'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
}
?>