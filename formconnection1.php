<html>
<body align="center">

<?php

$server = "tahira-server.mysql.database.azure.com";
$database = "tahira-database";
$username = "tahira";
$password = "@bajwa123456789";
$ssl_ca = __DIR__ . "/certs/BaltimoreCyberTrustRoot.crt.pem"; // path to SSL cert

// Initialize MySQLi connection
$conn = mysqli_init();

// Set SSL certificate for secure connection
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

// Connect to database with SSL
if (!mysqli_real_connect($conn, $server, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connection successful.<br>";
}


// Create table if it doesn't exist
$tableCreateQuery = "
CREATE TABLE IF NOT EXISTS formas3 (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    First_name VARCHAR(100) NOT NULL,
    Email_id VARCHAR(255) NOT NULL,
    Telephone_Number VARCHAR(20) NOT NULL,
    comments TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if ($conn->query($tableCreateQuery) === TRUE) {
    echo "Table checked/created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Validate POST data
$Fname = isset($_POST['First_name']) ? $_POST['First_name'] : '';
$F = isset($_POST['Email_id']) ? $_POST['Email_id'] : '';
$E = isset($_POST['Telephone_Number']) ? $_POST['Telephone_Number'] : '';
$R = isset($_POST['comments']) ? $_POST['comments'] : '';

// Check if form data is empty
if (empty($Fname) || empty($F) || empty($E) || empty($R)) {
    echo "All fields are required. Please fill out the form correctly.<br>";
    exit;
}

// Output the received values
echo "Your response is submitted successfully😀😀😀.<br>";
echo "<h2>Your Contact Information</h2>";
echo "Name: " . htmlspecialchars($Fname) . "<br>";
echo "Email: " . htmlspecialchars($F) . "<br>";
echo "Telephone Number: " . htmlspecialchars($E) . "<br>";
echo "Comments: " . htmlspecialchars($R) . "<br><br>";

// Insert data into the database using prepared statements
$stmt = $conn->prepare("INSERT INTO formas3 (First_name, Email_id, Telephone_Number, comments) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $Fname, $F, $E, $R);

if ($stmt->execute()) {
    echo "<h2>Kindly Confirm your details👀</h2>Thanks...!<br>";
} else {
    echo "Error inserting data: " . $stmt->error . "<br>";
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>
</body>
</html>
