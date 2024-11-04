<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    // Database connection setup.
    $servername = "localhost"; // Adjust if necessary
    $username = "whitebird";     // Adjust with your DB username
    $password = "Crimson24";         // Adjust with your DB password
    $dbname = "users_database"; // Adjust with your DB name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define role mappings
$role_mappings = [
    "admin" => ["table" => "admins", "id_column" => "admins_id", "password_column" => "password", "redirect_url" => "../admin-dashboard-network1.html"],

    "doctor" => ["table" => "doctors", "id_column" => "doctors_id", "password_column" => "doctors_password", "redirect_url" => "doctor-dashboard-network2.html"],
    "health_worker" => ["table" => "health_workers", "id_column" => "health_workers_id", "password_column" => "health_workers_password", "redirect_url" => "health-worker-dashboard-network1.html"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id_number'];
    $user_password = $_POST['password'];
    $user_role = $_POST['role'];

    // Print submitted data for debugging
    echo "Submitted ID: " . htmlspecialchars($user_id) . "<br>";
    echo "Submitted Password: " . htmlspecialchars($user_password) . "<br>";
    echo "Role: " . htmlspecialchars($user_role) . "<br>";

    if (array_key_exists($user_role, $role_mappings)) {
        $table = $role_mappings[$user_role]['table'];
        $id_column = $role_mappings[$user_role]['id_column'];
        $password_column = $role_mappings[$user_role]['password_column'];
        $redirect_url = $role_mappings[$user_role]['redirect_url'];

        // Prepare and execute the SQL query
        $stmt = $conn->prepare("SELECT $id_column, $password_column FROM $table WHERE $id_column = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row[$password_column];

            // Debugging output
            echo "Stored Password: " . htmlspecialchars($stored_password) . "<br>";

            if (password_verify($user_password, $stored_password)) {
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $row[$id_column];
                $_SESSION['user_role'] = $user_role;
                header("Location: $redirect_url");
                exit;
            } else {
                echo "Incorrect Password<br>";
            }
        } else {
            echo "No matching user found<br>";
        }
    } else {
        echo "Invalid user role.<br>";
    }
}

$conn->close();
?>
