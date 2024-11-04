<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : ''; // Identifies the user type.
    
    // Initialize variables to store form data for admin
    $username = isset($_POST['admin_username']) ? $_POST['admin_username'] : '';
    $surname = isset($_POST['admin_surname']) ? $_POST['admin_surname'] : '';
    $password = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';
    $password = password_hash($password, PASSWORD_BCRYPT);
    $gender = isset($_POST['admin_gender']) ? $_POST['admin_gender'] : '';
    $age = isset($_POST['admin_age']) ? $_POST['admin_age'] : '';
    $email = isset($_POST['admin_email']) ? $_POST['admin_email'] : '';
    $phone = isset($_POST['admin_phone']) ? $_POST['admin_phone'] : '';
    $address = isset($_POST['admin_address']) ? $_POST['admin_address'] : '';
    $date_of_joining = isset($_POST['admin_date_of_joining']) ? $_POST['admin_date_of_joining'] : '';

    // Initialize variables to store form data for doctor
    $doctor_username = isset($_POST['doctor_username']) ? $_POST['doctor_username'] : '';
    $doctor_surname = isset($_POST['doctor_surname']) ? $_POST['doctor_surname'] : '';
    $doctor_password = isset($_POST['doctor_password']) ? $_POST['doctor_password'] : '';
        $doctor_password = password_hash($doctor_password, PASSWORD_BCRYPT);

    $doctor_gender = isset($_POST['doctor_gender']) ? $_POST['doctor_gender'] : '';
    $doctor_age = isset($_POST['doctor_age']) ? $_POST['doctor_age'] : '';
    $doctor_email = isset($_POST['doctor_email']) ? $_POST['doctor_email'] : '';
    $doctor_phone = isset($_POST['doctor_phone']) ? $_POST['doctor_phone'] : '';
    $doctor_address = isset($_POST['doctor_address']) ? $_POST['doctor_address'] : '';
    $doctor_emergency_contact = isset($_POST['doctor_emergency_contact']) ? $_POST['doctor_emergency_contact'] : '';
    $doctor_date_of_joining = isset($_POST['doctor_date_of_joining']) ? $_POST['doctor_date_of_joining'] : '';

    // Initialize variables to store form data for healthworker
    $healthworkers_username = isset($_POST['healthworkers_username']) ? $_POST['healthworkers_username'] : '';
    $healthworkers_surname = isset($_POST['healthworkers_surname']) ? $_POST['healthworkers_surname'] : '';
    $healthworkers_password = isset($_POST['healthworkers_password']) ? $_POST['healthworkers_password'] : '';
        $healthworkers_password = password_hash($healthworkers_password, PASSWORD_BCRYPT);
    $healthworkers_gender = isset($_POST['healthworkers_gender']) ? $_POST['healthworkers_gender'] : '';
    $healthworkers_age = isset($_POST['healthworkers_age']) ? (int)$_POST['healthworkers_age'] : '';
    $healthworkers_email = isset($_POST['healthworkers_email']) ? $_POST['healthworkers_email'] : '';
    $healthworkers_phone = isset($_POST['healthworkers_phone']) ? $_POST['healthworkers_phone'] : '';
    $healthworkers_address = isset($_POST['healthworkers_address']) ? $_POST['healthworkers_address'] : '';
    $healthworkers_emergency_contact = isset($_POST['healthworkers_emergency_contact']) ? $_POST['healthworkers_emergency_contact'] : '';
    $healthworkers_date_of_joining = isset($_POST['healthworkers_date_of_joining']) ? $_POST['healthworkers_date_of_joining'] : '';
   
   // Retrieve form data with patients_ prefix and isset() checks for paitent
    $patients_username = isset($_POST['patients_username']) ? $_POST['patients_username'] : '';
    $patients_surname = isset($_POST['patients_surname']) ? $_POST['patients_surname'] : '';
    $patients_gender = isset($_POST['patients_gender']) ? $_POST['patients_gender'] : '';
    $patients_age = isset($_POST['patients_age']) ? (int)$_POST['patients_age'] : 0;
    $patients_symptoms = isset($_POST['patients_symptoms']) ? $_POST['patients_symptoms'] : '';
    $patients_diagnosis = isset($_POST['patients_diagnosis']) ? $_POST['patients_diagnosis'] : '';
    $patients_route_of_admission = isset($_POST['patients_route_of_admission']) ? $_POST['patients_route_of_admission'] : '';
    $patients_date_of_admission = isset($_POST['patients_date_of_admission']) ? $_POST['patients_date_of_admission'] : '';
    $patients_address = isset($_POST['patients_address']) ? $_POST['patients_address'] : '';
    $patients_hospital = isset($_POST['patients_hospital']) ? $_POST['patients_hospital'] : '';
    $patients_phone = isset($_POST['patients_phone']) ? $_POST['patients_phone'] : '';
    $patients_unit = isset($_POST['patients_unit']) ? $_POST['patients_unit'] : '';
    $patients_origin = isset($_POST['patients_origin']) ? $_POST['patients_origin'] : '';
    $patients_status = isset($_POST['patients_status']) ? $_POST['patients_status'] : '';

    // Database connection setup.
    $servername = "localhost"; // Adjust if necessary
    $username_db = "whitebird";     // Adjust with your DB username
    $password_db = "Crimson24";         // Adjust with your DB password
    $dbname = "users_database"; // Adjust with your DB name

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement and bind parameters based on user type.
    switch ($user_type) {
        case 'Admin':
            $sql = "INSERT INTO admins (username, surname, password, gender, age, email, phone, address, date_of_joining) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssissss', $username, $surname, $password, $gender, $age, $email, $phone, $address, $date_of_joining);
            break;

        case 'Doctor':
            $specialization = $_POST['specialization'];
            $doctor_emergency_contact = $_POST['doctor_emergency_contact'];
            $sql = "INSERT INTO doctors (doctor_username, doctor_surname,doctor_password, doctor_gender, doctor_age, doctor_email, doctor_phone, doctor_address, specialization, doctor_emergency_contact, doctor_date_of_joining) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssissssss', $doctor_username, $doctor_surname, $doctor_password, $doctor_gender, $doctor_age, $doctor_email, $doctor_phone, $doctor_address, $specialization, $doctor_emergency_contact, $doctor_date_of_joining);
            break;

        case 'Health Worker':
            $healthworkers_department = isset($_POST['healthworkers_department']) ? $_POST['healthworkers_department'] : '';            
            $sql = "INSERT INTO healthworkers (healthworkers_username, healthworkers_surname, healthworkers_password, healthworkers_gender, healthworkers_age, healthworkers_email, healthworkers_phone, healthworkers_address, healthworkers_department, healthworkers_emergency_contact, healthworkers_date_of_joining) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssissssss', $healthworkers_username, $healthworkers_surname, $healthworkers_password, $healthworkers_gender, $healthworkers_age, $healthworkers_email, $healthworkers_phone, $healthworkers_address, $healthworkers_department, $healthworkers_emergency_contact, $healthworkers_date_of_joining);
            break;

        case 'Patient':
      
        $sql = "INSERT INTO patients (patients_username, patients_surname, patients_gender, patients_age, patients_symptoms, patients_diagnosis, patients_route_of_admission, patients_date_of_admission, patients_address, patients_hospital, patients_phone, patients_unit, patients_origin, patients_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

    $stmt->bind_param('sssissssssssss', 
    $patients_username, 
    $patients_surname, 
    $patients_gender, 
    $patients_age, 
    $patients_symptoms, 
    $patients_diagnosis, 
    $patients_route_of_admission, 
    $patients_date_of_admission, 
    $patients_address, 
    $patients_hospital, 
    $patients_phone, 
    $patients_unit, 
    $patients_origin, 
    $patients_status
);


        break;
        default;
            die('Invalid user type selected.');
    }
if ($stmt->execute()) {
    echo "<div style='
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            '>
            <div style='
                padding: 20px; 
                border: 2px solid green; 
                background-color: #e6ffed; 
                color: green; 
                border-radius: 10px; 
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
                max-width: 400px; 
                text-align: center;'>
                <h2 style='font-size: 24px; margin-bottom: 10px;'>Success!</h2>
                <p style='font-size: 18px;'>The new record for <strong>$user_type</strong> has been created successfully.</p>
                <a href='../admin-dashboard-network1.html' style='
                    display: inline-block; 
                    margin-top: 20px; 
                    padding: 10px 20px; 
                    background-color: #28a745; 
                    color: white; 
                    text-decoration: none; 
                    border-radius: 5px;'>Back to Dashboard</a>
            </div>
          </div>";
} else {
    // Handle error
}
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
