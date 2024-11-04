<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }
         .container {
             padding: 20px;
             border: 1px solid #ddd; /* Ensure border color and style are correct */
             border-radius: 8px;
             margin: 20px;
             position: relative; /* Fixed from 'ove' to 'relative' */
         }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
            max-height: 100px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-align: center;
        }
        .header .print-button {
            text-align: right;
        }
        .print-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title .date {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="../images/AGH.png" alt="Doctor's Image">
            <h2>Admin User List</h2>
            <div class="print-button">
                <button onclick="printReport()">Print Report</button>
            </div>
        </div>

        <div class="title">
            <div class="date"><?php echo date('F d, Y'); ?></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admin ID</th>
                    <th>Admin Name</th>
                    <th>Admin Surname</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date of Joining</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('db_connect.php');
                session_start();
                $result = $conn->query("SELECT * FROM admins");

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['admins_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_of_joining']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No admin records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>