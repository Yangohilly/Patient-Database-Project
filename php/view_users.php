<?php
header('Content-Type: application/json');

    // Database connection setup.
    $servername = "localhost"; // Adjust if necessary
    $username_db = "whitebird";     // Adjust with your DB username
    $password_db = "Crimson24";         // Adjust with your DB password
    $dbname = "users_database"; // Adjust with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get the view type from the request
$view = $_GET['view'] ?? '';

// Validate the view type
$valid_views = ['admin', 'doctor', 'healthworker', 'patient'];
if (!in_array($view, $valid_views)) {
    echo json_encode([]);
    exit;
}

// Switch case for view type
switch ($view) {
    case 'admin':
        $table = 'admins';
        $columns = 'admins_id, username, surname, password, gender, age, email, phone, address, date_of_joining';
        break;
    case 'doctor':
        $table = 'doctors';
        $columns = 'doctors_id, doctor_username, doctor_surname, doctor_password, doctor_gender, doctor_age, doctor_email, doctor_phone, doctor_address, specialization, doctor_emergency_contact, doctor_date_of_joining';
        break;
    case 'healthworker':
        $table = 'healthworkers';
        $columns = 'healthworkers_id, healthworkers_username, healthworkers_surname, healthworkers_password, healthworkers_gender, healthworkers_age, healthworkers_email, healthworkers_phone, healthworkers_address, healthworkers_department, healthworkers_emergency_contact, healthworkers_date_of_joining';
        break;
case 'patient':
    $table = 'patients';
    $columns = 'patients_id, patients_username, patients_surname, patients_gender, patients_age, patients_symptoms, patients_diagnosis, patients_route_of_admission, patients_date_of_admission, patients_address, patients_hospital, patients_phone, patients_unit, patients_origin, patients_status';
    break;

}

// Prepare and execute SQL query
$sql = "SELECT $columns FROM $table";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and return data
$data = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode($data);


// Close the statement and connection
$stmt->close();
$conn->close();
?>
