<?php
// 1. Session and Database Connection
include_once('../dbConnection.php'); 

// Security Check
if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['is_login'])) {
  header("Location: ../login.php");
  exit();
}


$stuEmail = $_SESSION['stuLogEmail']; 
$msg = "";

// 2. Handle Profile Update (name and image only)
if (isset($_POST['updateStuNameBtn'])) {
    if (trim($_POST['stuName']) == "") {
        $msg = '<div style="color: #e67e22; text-align: center; font-weight: bold; margin-bottom:1rem;">⚠️ Name is required</div>';
    } else {
        $stuName = trim($_POST['stuName']);
        
        $stuImgName = $_FILES['stuImg']['name'];
        $stuImgTemp = $_FILES['stuImg']['tmp_name'];
        $imgFolder = '../image/student/' . $stuImgName; 

        if (!empty($stuImgName)) {
            // Upload new image
            if(move_uploaded_file($stuImgTemp, $imgFolder)) {
                $sql = "UPDATE stddata SET stu_name = '$stuName', stu_img = '$imgFolder' WHERE stu_email = '$stuEmail'";
            } else {
                $msg = '<div style="color: #e74c3c; text-align: center;">❌ Failed to upload image. Check "image/student" folder.</div>';
            }
        } 
        else {
            // Update text only
            $sql = "UPDATE stddata SET stu_name = '$stuName' WHERE stu_email = '$stuEmail'";
        }

        if (!isset($sql) || $conn->query($sql) === TRUE) {
            $_SESSION['stu_name'] = $stuName; 
            $msg = '<div style="color: #27ae60; text-align: center; font-weight: bold; margin-bottom:1rem;">✅ Saved Successfully!</div>';
        } else {
            $msg = '<div style="color: #e74c3c; text-align: center;">❌ Update Failed: ' . $conn->error . '</div>';
        }
    }
}

// 3. Fetch Data
$sql = "SELECT * FROM stddata WHERE stu_email = '$stuEmail'";
$result = $conn->query($sql);
if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row['stu_id'];
    $stuName = $row['stu_name'];
    $dbImgPath = $row['stu_img']; 
}

// 4. Placeholder Logic (Prevents broken image icon)
$stuImg = $dbImgPath;
if(empty($stuImg) || !file_exists($stuImg)) {
    // If you have a local default file, use it:
    if(file_exists('../image/student/default.png')) {
        $stuImg = '../image/student/default.png';
    } else {
        // Otherwise use this online placeholder so it looks good
        $stuImg = 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
    }
}

// Update query to set default image for broken links
$sql = "UPDATE stddata
SET stu_img = '../image/student/default.png'
WHERE stu_img = '../image/student/default.img'
   OR stu_img LIKE '%.img'";
$conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - LearnEase</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body style="background-color: #f8f9fa;">

<?php
// Navbar
  include_once('../header.php');
?>

  <!-- <nav class="navbar">
    <div class="container">
      <a href="../student-dashboard.php" class="logo">Learn<span>Ease</span></a>
      <div class="nav-actions">
        <a href="../logout.php" class="btn btn-outline">Log Out</a>
      </div>
    </div>
  </nav> -->

  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
       <div style="display: flex; justify-content: space-between; align-items: center;">
         <h1 style="color: white;">My Profile</h1>
         <!-- <a href="../student-dashboard.php" class="btn" style="border: 1px solid white; color: white;">Dashboard</a> -->
       </div>
    </div>
  </section>

  <section style="margin: 4rem 0;">
    <div class="container" style="max-width: 600px; margin: 0 auto;">
      <div class="card" style="padding: 2.5rem; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
        
        <?php echo $msg; ?>

        <form action="" method="POST" enctype="multipart/form-data">
          <div style="text-align: center; margin-bottom: 2.5rem;">
              
              <img src="<?php echo $stuImg; ?>" 
                   alt="Your Profile Picture" 
                   style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #4A90E2; margin-bottom: 1rem; background-color: #eee;">
              
              <label style="display: block; font-size: 0.9rem; color: #7f8c8d; margin-bottom: 0.5rem;">Change Picture</label>
              <input type="file" name="stuImg" style="font-size: 0.8rem; margin: 0 auto; display: block;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label>Student ID</label>
            <input type="text" value="<?php echo $stuId; ?>" readonly style="width: 100%; padding: 0.8rem; background: #f9f9f9; border: 1px solid #eee;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label>Email</label>
            <input type="email" value="<?php echo $stuEmail; ?>" readonly style="width: 100%; padding: 0.8rem; background: #f9f9f9; border: 1px solid #eee;">
          </div>

          <div style="margin-bottom: 1.2rem;">
            <label>Name</label>
            <input type="text" name="stuName" value="<?php echo $stuName; ?>" required style="width: 100%; padding: 0.8rem;">
          </div>

          <div style="margin-bottom: 2rem;">
            <label>Password</label>
            <div style="padding: 0.8rem; background: #f9f9f9; border-radius: 6px; color: #666;">For security, change your password via <a href="changepassword.php">Change Password</a>.</div>
          </div>

          <button type="submit" name="updateStuNameBtn" style="width: 100%; background: #4A90E2; color: white; padding: 1rem; border: none; border-radius: 6px; cursor: pointer;">
              Update Profile
          </button>
        </form>
      </div>
    </div>
  </section>

</body>
</html>