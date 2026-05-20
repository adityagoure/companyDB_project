<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db.php';

// Ensure all mysqli errors are reported as exceptions we can catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$action = $_GET['action'] ?? '';

// GET ALL PROJECTS
if ($action == "get_all") {
    $query = "SELECT p.proj_number, p.proj_name, 
                     p.location, d.dept_name, p.dept_number,
                     COUNT(w.emp_ssn) as total_employees
              FROM project p
              LEFT JOIN department d ON p.dept_number = d.dept_number
              LEFT JOIN works_on w ON p.proj_number = w.proj_number
              GROUP BY p.proj_number";
    $result = mysqli_query($conn, $query);
    echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// ADD PROJECT
if ($action == "add") {
    $proj_number = $_POST['proj_number'] ?? '';
    $proj_name   = $_POST['proj_name'] ?? '';
    $location    = $_POST['location'] ?? '';
    $dept_number = $_POST['dept_number'] ?? '';

    // Validate required fields
    if (empty($proj_number) || empty($proj_name)) {
        echo json_encode(["status" => "error", "message" => "Project number and name are required."]);
        exit;
    }

    try {
        $query = "INSERT INTO project (proj_number, proj_name, location, dept_number)
                  VALUES ('$proj_number','$proj_name','$location','$dept_number')";

        mysqli_query($conn, $query);
        echo json_encode(["status" => "success", "message" => "Project added!"]);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo json_encode(["status" => "error", "message" => "Project number $proj_number already exists. Please use a different number."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        }
    }
}

// DELETE PROJECT
if ($action == "delete") {
    $proj_number = $_GET['proj_number'] ?? '';
    try {
        $query = "DELETE FROM project WHERE proj_number='$proj_number'";
        mysqli_query($conn, $query);
        echo json_encode(["status" => "success", "message" => "Project deleted!"]);
    } catch (mysqli_sql_exception $e) {
        echo json_encode(["status" => "error", "message" => "Cannot delete: " . $e->getMessage()]);
    }
}

// UPDATE PROJECT
if ($action == "update") {
    $proj_number = $_POST['proj_number'] ?? '';
    $proj_name   = $_POST['proj_name'] ?? '';
    $location    = $_POST['location'] ?? '';
    $dept_number = $_POST['dept_number'] ?? '';

    try {
        $query = "UPDATE project 
                  SET proj_name='$proj_name',
                      location='$location',
                      dept_number='$dept_number'
                  WHERE proj_number='$proj_number'";

        mysqli_query($conn, $query);
        echo json_encode(["status" => "success", "message" => "Project updated!"]);
    } catch (mysqli_sql_exception $e) {
        echo json_encode(["status" => "error", "message" => "Update failed: " . $e->getMessage()]);
    }
}
?>