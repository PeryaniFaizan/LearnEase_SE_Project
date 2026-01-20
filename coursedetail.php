<?php
// 1. Session, Connection and Header
include('./dbConnection.php'); 
include('./header.php'); 

// 2. Validate Course ID from URL
if(isset($_GET['course_id'])){
    $course_id = $_GET['course_id'];
    
    // Fetch specific course details
    $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<div class="container" style="margin-top: 3rem; margin-bottom: 5rem;">
    <div class="row" style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
        <div class="col-img" style="flex: 1; min-width: 300px;">
            <?php 
                // Adjusting the image path
                $final_img = str_replace('../', './', $row['course_img']); 
            ?>
            <img src="<?php echo $final_img; ?>" alt="Course Image" style="width: 100%; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        </div>
        
        <div class="col-details" style="flex: 1.5; min-width: 300px;">
            <h2 style="color: #2C3E50; margin-bottom: 1rem;">Course Name: <?php echo $row['course_name']; ?></h2>
            <p style="font-size: 1.1rem; line-height: 1.6; color: #7F8C8D;">
                <strong>Description:</strong> <?php echo $row['course_desc']; ?>
            </p>
            <p style="margin-top: 1rem;"><strong>Duration:</strong> <?php echo $row['course_duration']; ?></p>
            
            <div style="margin: 1.5rem 0; font-size: 1.3rem; font-weight: bold;">
                Price: <span style="text-decoration: line-through; color: #7F8C8D; font-size: 1rem; margin-right: 10px;">
                    Rs <?php echo $row['course_original_price']; ?>
                </span> 
                Rs <?php echo $row['course_price']; ?>
            </div>
            
            <?php 
            if(isset($_SESSION['is_login'])){
                // User is logged in, show normal checkout form
                echo '
                <form action="checkout.php" method="POST">
                    <input type="hidden" name="id" value="'. $row['course_id'] .'">
                    <button type="submit" class="btn btn-primary" name="buy" style="padding: 0.8rem 2.5rem; font-size: 1.1rem;">Buy Now</button>
                </form>';
            } else {
                // User is not logged in, redirect to login page
                echo '<a href="login.php" class="btn btn-primary" style="padding: 0.8rem 2.5rem; font-size: 1.1rem;">Buy Now</a>';
            }
            ?>
        </div>
    </div>

    <hr style="margin: 4rem 0; border: 0; border-top: 1px solid #eee;">

    <h3 style="margin-bottom: 1.5rem;">📚 Course Curriculum</h3>
    <table class="table" style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <thead>
            <tr style="background-color: #f8f9fa; text-align: left;">
                <th style="padding: 1rem; border-bottom: 2px solid #dee2e6; width: 100px;">Lesson No.</th>
                <th style="padding: 1rem; border-bottom: 2px solid #dee2e6;">Lesson Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch lessons related to this specific course_id
            $sql_lessons = "SELECT * FROM lesson WHERE course_id = '$course_id'";
            $res_lessons = $conn->query($sql_lessons);
            $count = 0;

            if($res_lessons->num_rows > 0) {
                while($l_row = $res_lessons->fetch_assoc()) {
                    $count++;
                    echo '<tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem; font-weight: bold;">'. $count .'</td>
                            <td style="padding: 1rem;">'. $l_row['lesson_name'] .'</td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="2" style="padding: 2rem; text-align: center; color: #7F8C8D;">No lessons added for this course yet.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php 
// 3. Footer
include('./footer.php'); 
?>