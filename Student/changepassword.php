<?php
// 1. Session and Database Connection
include_once('../dbConnection.php'); 

if(!isset($_SESSION)){
    session_start();
}
// Security: Redirect if student is not logged in
if (!isset($_SESSION['is_login'])) {
    header("Location: ../login.php");
    exit();
}



$stuEmail = $_SESSION['stuLogEmail']; 
$msg = "";

// 2. Handle Password Update Submission
if (isset($_POST['updatePassBtn'])) {
    if ($_POST['stuPass'] == "" || $_POST['stuConfPass'] == "") {
      $msg = '<div style="color: #e67e22; text-align: center; font-weight: bold; margin-bottom:1rem;">⚠️ Both fields are required</div>';
    } 
    else if ($_POST['stuPass'] !== $_POST['stuConfPass']) {
      $msg = '<div style="color: #e74c3c; text-align: center; font-weight: bold; margin-bottom:1rem;">❌ Passwords do not match!</div>';
    } 
    else {
      $stuPass = password_hash($_POST['stuPass'], PASSWORD_DEFAULT);

      // Use prepared statement to update the user password column
      $stmt = $conn->prepare("UPDATE user SET user_pwd = ? WHERE user_email = ?");
      if ($stmt) {
          $stmt->bind_param('ss', $stuPass, $stuEmail);
          if ($stmt->execute()) {
              $msg = '<div style="color: #27ae60; text-align: center; font-weight: bold; margin-bottom:1rem;">✅ Password Updated Successfully!</div>';
          } else {
              $msg = '<div style="color: #e74c3c; text-align: center;">❌ Update Failed: ' . $stmt->error . '</div>';
          }
          $stmt->close();
      } else {
          $msg = '<div style="color: #e74c3c; text-align: center;">❌ Update Failed: ' . $conn->error . '</div>';
      }
    }
}

// 3. Fetch current student image for Navbar display
$sql = "SELECT stu_img FROM stddata WHERE stu_email = '$stuEmail'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$stuImg = $row['stu_img'];
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
      <a href="../index.php" class="logo">Learn<span>Ease</span></a>
      <ul class="nav-links">
        <li><a href="studentprof.php">Profile</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
      </ul>
      
      <div class="nav-actions">
        <a href="../logout.php" class="btn btn-outline">Log Out</a>
      </div>
    </div>
  </nav>

  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <h1 style="color: white; margin: 0;">Security Settings</h1>
          <p style="color: white; font-size: 1.1rem; margin-top: 0.5rem;">Update your account password</p>
        </div>
        <a href="../student-dashboard.php" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold;">
          📊 Dashboard
        </a>
      </div>
    </div>
  </section>

  <section style="margin: 4rem 0;">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
      <div class="card" style="padding: 2.5rem; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
        
        <?php echo $msg; ?>

        <form action="" method="POST">
          <div style="margin-bottom: 1.2rem;">
            <label style="font-weight: bold; color: #2C3E50; display: block; margin-bottom: 0.4rem;">Email Address</label>
            <input type="email" value="<?php echo $stuEmail; ?>" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #eee; background: #f9f9f9; border-radius: 6px; color: #888;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label style="font-weight: bold; color: #2C3E50; display: block; margin-bottom: 0.4rem;">New Password</label>
            <input type="password" name="stuPass" placeholder="Enter new password" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <div style="margin-bottom: 2rem;">
            <label style="font-weight: bold; color: #2C3E50; display: block; margin-bottom: 0.4rem;">Confirm New Password</label>
            <input type="password" name="stuConfPass" placeholder="Re-enter new password" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>

          <button type="submit" name="updatePassBtn" style="width: 100%; background: #4A90E2; color: white; padding: 1rem; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 1.1rem;">
              Update Password
          </button>
        </form>
      </div>
    </div>
  </section>

</body>
</html>