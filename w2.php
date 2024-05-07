<?php
session_start();
$host = 'localhost';
$user = 'root'; // Update with your DB user
$password = ''; // Update with your DB password
$dbname = 'LibraryManagement';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['userID'];
    $membershipType = $_POST['membershipType'];
    $startDate = $_POST['startDate'];

    // Determine end date based on membership type
    $endDate = null;
    switch ($membershipType) {
        case '6 months':
            $endDate = date('Y-m-d', strtotime("+6 months", strtotime($startDate)));
            break;
        case '1 year':
            $endDate = date('Y-m-d', strtotime("+1 year", strtotime($startDate)));
            break;
        case '2 years':
            $endDate = date('Y-m-d', strtotime("+2 years", strtotime($startDate)));
            break;
    }

    // Check if membership already exists for the user
    $sql = "SELECT * FROM Memberships WHERE UserID = ? AND StartDate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userID, $startDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing membership
        $updateSQL = "UPDATE Memberships SET MembershipType = ?, EndDate = ? WHERE UserID = ? AND StartDate = ?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("ssis", $membershipType, $endDate, $userID, $startDate);
        $updateStmt->execute();
    } else {
        // Insert new membership
        $insertSQL = "INSERT INTO Memberships (UserID, MembershipType, StartDate, EndDate) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSQL);
        $insertStmt->bind_param("iss
