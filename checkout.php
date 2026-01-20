<?php
// 1. Connection and Session
include('./dbConnection.php');

if(!isset($_SESSION)){
    session_start();
}

// Security: If not logged in, send to login page
if(!isset($_SESSION['is_login'])){
    header("Location: login.php");
    exit();
}

$stuEmail = $_SESSION['stuLogEmail']; //

// 2. Handle the "Enroll" / "Buy" Action
if(isset($_POST['buy'])){
    $course_id = $_POST['id']; // From the hidden input in coursedetail.php
    $order_id = "ORDR" . rand(10000, 99999); // Generate a simple unique ID
    $date = date('Y-m-d');
    
    // Check if the student is already enrolled in this course
    $check_sql = "SELECT * FROM courseorder WHERE stu_email = '$stuEmail' AND course_id = '$course_id'";
    $check_result = $conn->query($check_sql);
    
    if($check_result->num_rows > 0){
        echo "<script>alert('You are already enrolled in this course!'); window.location.href='student-dashboard.php';</script>";
    } else {
        // Since it's "Enroll for Free", we set status to 'Success' directly
        $sql = "INSERT INTO courseorder (order_id, stu_email, course_id, status, order_date) 
                VALUES ('$order_id', '$stuEmail', '$course_id', 'Success', '$date')";
        
        if($conn->query($sql) === TRUE){
            echo "<script>alert('Enrollment Successful!'); window.location.href='student-dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    // If someone tries to access checkout.php directly without a course ID
    header("Location: courses.php");
    exit();
}
?>