<?php
// 1. Session and Connection
include('../dbConnection.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: adminlogin.php");
    exit();
}

// 2. DELETE LOGIC
if(isset($_REQUEST['delete'])) {
    $course_id = $_REQUEST['course_id']; 
    $sql = "DELETE FROM course WHERE course_id = $course_id";
    
    if($conn->query($sql) === TRUE) {
        echo '<meta http-equiv="refresh" content="0;URL=?deleted" />';
    } else {
        echo "Unable to Delete Data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses - Admin</title>
  <link rel="stylesheet" href="../styles.css"> 
  <style>
    body { font-family: sans-serif; background-color: #f8f9fa; margin: 0; }
    .navbar { background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 1rem 0; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .logo { font-size: 1.5rem; font-weight: bold; color: #4A90E2; text-decoration: none; }
    .logo span { color: #50C878; }
    .nav-actions { display: flex; align-items: center; float: right; }
    .btn-outline { border: 1px solid #4A90E2; color: #4A90E2; padding: 5px 15px; text-decoration: none; border-radius: 4px; margin-left: 10px; }
    .btn-outline:hover { background: #4A90E2; color: white; }
  </style>
</head>
<body>

  <!-- <nav class="navbar">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
      <a href="../instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
      
      <div class="nav-actions">
        <span style="margin-right: 1rem; color: #2C3E50;">👨‍🏫 <?php echo $_SESSION['admin_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline">Logout</a>
      </div>
    </div>
  </nav> -->

  <nav class="navbar">
    <div class="container">
        <a href="../instructor-dashboard.php" class="logo">Learn<span>Ease</span></a>
        
        <ul class="nav-links">
            <li><a href="../instructor-dashboard.php">Dashboard</a></li>
            <li><a href="../about.php">About</a></li>
            <!-- <li><a href="admincourses.php">Courses</a></li> -->
        </ul>
        
        <div class="nav-actions">
            <span style="margin-right: 1rem; color: #2C3E50;">
                👨‍🏫 <?php echo $_SESSION['admin_name']; ?>
            </span>
            <a href="../logout.php" class="btn btn-outline">Logout</a>
        </div>
    </div>
</nav>

  <section style="margin: 2rem 0;">
    <div class="container">
      <div class="card" style="padding: 1.5rem; overflow-x: auto; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 1.5rem; color: #2C3E50;">📦 Recent Course Orders</h2>
        
        <?php
        $sql = "SELECT * FROM course";
        $result = $conn->query($sql);
        
        if($result->num_rows > 0) {
        ?>
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
          <thead>
            <tr style="background-color: #f8f9fa; text-align: left;">
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">ID</th> 
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Name</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Author</th>
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Price</th> 
              <th style="padding: 1rem; border-bottom: 2px solid #dee2e6; text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php while($row = $result->fetch_assoc()) { ?>
            <tr style="border-bottom: 1px solid #eee;">
              <td style="padding: 1rem; font-weight: bold;"><?php echo $row['course_id']; ?></td>
              <td style="padding: 1rem;"><?php echo $row['course_name']; ?></td>
              <td style="padding: 1rem;"><?php echo $row['course_author']; ?></td>
              <td style="padding: 1rem;">Rs. <?php echo $row['course_price']; ?></td>
              
              <td style="padding: 1rem;">
                <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">

                 <form action="editcourse.php" method="POST" class="d-inline" style="margin: 0;"> 
                  <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                  <a href="editcourse.php?id=<?php echo $row['course_id']; ?>" 
                     style="background: #3498DB; color: white; padding: 0; border-radius: 5px; text-decoration: none; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px;" 
                     title="Edit Course">✏️</a>
                 </form>

                 <form method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" style="margin: 0;">
                    <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                    <button type="submit" name="delete" 
                            style="background: #E74C3C; color: white; border: none; padding: 0; border-radius: 5px; cursor: pointer; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px;" 
                            title="Delete Course">🗑️</button>
                 </form>
                  
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <?php 
        } else {
            echo "<p style='text-align:center; padding: 20px;'>0 Results Found</p>";
        } 
        ?>
      </div>
    </div>
  </section>

  <a href="addcourse.php" 
     style="position: fixed; bottom: 40px; right: 40px; background: linear-gradient(135deg, #3498DB, #2ECC71); color: white; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; text-decoration: none; box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4); z-index: 1000; transition: all 0.3s ease;"
     title="Add New Course"
  >➕</a>

</body>
</html>