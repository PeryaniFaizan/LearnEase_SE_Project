<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}
// include('../header.php');

$msg = "";
$adminEmail = $_SESSION['adminLogEmail']; // Using the email stored in session

// 2. Handle Password Update Logic
if (isset($_POST['adminPassUpdateBtn'])) {
    if (($_POST['adminPass'] == "")) {
        $msg = '<div style="color: #e67e22; margin-bottom: 1rem; font-weight: bold; text-align: center;">⚠️ Please enter a new password</div>';
    } else {
        $adminPass = $_POST['adminPass'];
        $adminPass = password_hash($adminPass, PASSWORD_DEFAULT);

        // Update the password in the user table
        $sql = "UPDATE user SET user_pwd = '$adminPass' WHERE user_email = '$adminEmail'";

        if ($conn->query($sql) === TRUE) {
            $msg = '<div style="color: #27ae60; margin-bottom: 1rem; font-weight: bold; text-align: center;">✅ Password Updated Successfully!</div>';
        } else {
            $msg = '<div style="color: #e74c3c; margin-bottom: 1rem; font-weight: bold; text-align: center;">❌ Update Failed: ' . $conn->error . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar">
    <div class="container">
      <a href="index.php" class="logo">Learn<span>Ease</span></a>
      <ul class="nav-links">
        <li><a href="../instructor-dashboard.php">Dashboard</a></li>
        <li><a href="Admin/admincourses.php">Courses</a></li>
      </ul>
      <div class="nav-actions">
        <span style="margin-right: 1rem; color: #2C3E50;">👨‍🏫 <?php echo $_SESSION['admin_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline">Logout</a>
        <a href="Admin/adminchangepass.php" class="btn btn-outline" style="margin-left: 10px;">Change Password</a>
      </div>
    </div>
  </nav>

  <section style="margin: 4rem 0;">
    <div class="container" style="max-width: 500px;">
      <div class="card" style="padding: 2.5rem; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.08);">
        
        <h2 style="margin-bottom: 2rem; color: #2C3E50; text-align: center;">🔐 Change Password</h2>
        
        <?php echo $msg; ?>

        <form action="" method="POST">
          <div style="margin-bottom: 1.2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Address</label>
            <input type="email" value="<?php echo $adminEmail; ?>" readonly 
                   style="width: 100%; padding: 0.8rem; border: 1px solid #eee; border-radius: 6px; background: #f9f9f9; color: #777;">
          </div>

          <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">New Password</label>
            <input type="password" name="adminPass" placeholder="Enter new password" required 
                   style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="display: flex; gap: 10px;">
            <button type="submit" name="adminPassUpdateBtn" 
                    style="flex: 3; background: #3498DB; color: white; border: none; padding: 1rem; border-radius: 6px; cursor: pointer; font-weight: bold;">
              Update Password
            </button>
            <a href="instructor-dashboard.php" 
               style="flex: 1; text-align: center; background: #f1f2f6; color: #2C3E50; padding: 1rem; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #ddd;">
              Cancel
            </a>
          </div>
        </form>

      </div>
    </div>
  </section>

</body>
</html>