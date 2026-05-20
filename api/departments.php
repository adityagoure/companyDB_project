<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

$action = $_GET['action'] ?? '';

// GET ALL DEPARTMENTS
if ($action == "get_all") {
    $query = "SELECT d.dept_number, d.dept_name, 
                     e.fname, e.lname, d.manager_start,
                     COUNT(emp.ssn) as total_employees
              FROM department d
              LEFT JOIN employee e ON d.manager_ssn = e.ssn
              LEFT JOIN employee emp ON emp.dept_number = d.dept_number
              GROUP BY d.dept_number";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($data);
}

// ADD DEPARTMENT
if ($action == "add") {
    $dept_number  = $_POST['dept_number'];
    $dept_name    = $_POST['dept_name'];
    $manager_ssn  = $_POST['manager_ssn'];
    $manager_start = $_POST['manager_start'];

    $query = "INSERT INTO department 
              (dept_number, dept_name, manager_ssn, manager_start)
              VALUES 
              ('$dept_number','$dept_name','$manager_ssn','$manager_start')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Department added!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// DELETE DEPARTMENT
if ($action == "delete") {
    $dept_number = $_GET['dept_number'];
    $query = "DELETE FROM department WHERE dept_number='$dept_number'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Department deleted!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// UPDATE DEPARTMENT
if ($action == "update") {
    $dept_number  = $_POST['dept_number'];
    $dept_name    = $_POST['dept_name'];
    $manager_ssn  = $_POST['manager_ssn'];
    $manager_start = $_POST['manager_start'];

    $query = "UPDATE department 
              SET dept_name='$dept_name',
                  manager_ssn='$manager_ssn',
                  manager_start='$manager_start'
              WHERE dept_number='$dept_number'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Department updated!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// GET DEPARTMENT LOCATIONS
if ($action == "get_locations") {
    $dept_number = $_GET['dept_number'];
    $query = "SELECT * FROM dept_locations 
              WHERE dept_number='$dept_number'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($data);
}

// ADD LOCATION
if ($action == "add_location") {
    $dept_number = $_POST['dept_number'];
    $location    = $_POST['location'];

    $query = "INSERT INTO dept_locations (dept_number, location)
              VALUES ('$dept_number', '$location')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Location added!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>