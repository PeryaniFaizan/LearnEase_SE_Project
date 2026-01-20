<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Courses - LearnEase</title>
  
  <link rel="stylesheet" href="styles.css">
  
  <style>
    /* Force the Container to be centered */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* THE GRID SYSTEM - Forces 3 columns */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    /* THE CARD - Fixes the image size */
    .course-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Crucial: Forces image to be 200px tall and not stretch */
    .course-card img {
        width: 100%;
        height: 200px;
        object-fit: cover; 
        display: block;
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 10px;
        font-weight: bold;
        color: #2C3E50;
    }

    /* Search Bar Styling */
    .search-box-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-top: -30px; 
        position: relative;
        z-index: 10;
        border: 1px solid #eee;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 20px;
        align-items: end;
    }

    /* Mobile Responsive Fixes */
    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
        }
        .course-grid {
            grid-template-columns: 1fr; /* 1 column on mobile */
        }
    }
  </style>
</head>
<body style="background-color: #f8f9fa;">

  <?php 
    include('./header.php');
    include('./dbConnection.php'); 

    // 1. Fetch data for Suggestions & Dropdown
    $all_courses = [];
    $sql_names = "SELECT course_name FROM course";
    $result_names = $conn->query($sql_names);
    if($result_names->num_rows > 0){
        while($row_name = $result_names->fetch_assoc()){
            $all_courses[] = $row_name['course_name'];
        }
    }
  ?>

  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 80px 0 60px 0;">
    <div class="container text-center">
      <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px; color: white;">Explore Our Courses</h1>
      <p style="font-size: 1.2rem; opacity: 0.9; color: white;">Discover courses taught by expert instructors</p>
    </div>
  </section>

  <div class="container">
      <div class="search-box-card">
        <form action="" method="GET" class="filter-form">
          
          <div class="form-group" style="margin: 0;">
            <label for="search" style="font-weight: 600; margin-bottom: 5px; display: block;">Search Courses</label>
            <input type="text" 
                   name="search" 
                   id="search" 
                   class="form-control" 
                   placeholder="e.g. Web Development" 
                   list="course_suggestions"
                   autocomplete="off"
                   value="<?php if(isset($_GET['search'])){ echo htmlspecialchars($_GET['search']); } ?>">
            
            <datalist id="course_suggestions">
                <?php 
                foreach($all_courses as $c_name) {
                    echo "<option value='" . htmlspecialchars($c_name) . "'>";
                }
                ?>
            </datalist>
          </div>

          <div class="form-group" style="margin: 0;">
            <label for="course_select" style="font-weight: 600; margin-bottom: 5px; display: block;">Select Course</label>
            <select name="course_select" id="course_select" class="form-control">
              <option value="">All Courses</option>
              <?php 
                foreach($all_courses as $c_name) {
                    $selected = (isset($_GET['course_select']) && $_GET['course_select'] == $c_name) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($c_name) . "' $selected>" . htmlspecialchars($c_name) . "</option>";
                }
              ?>
            </select>
          </div>

          <div class="form-group" style="margin: 0;">
             <button type="submit" class="btn btn-primary" style="width: 100%; height: 45px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Filter</button>
          </div>

        </form>
      </div>
  </div>

  <section style="padding: 40px 0;">
    <div class="container">
      <h2 style="margin-bottom: 20px; color: #333;">Available Courses</h2>
      
      <div class="course-grid">
        <?php
          // --- QUERY LOGIC ---
          $sql = "SELECT * FROM course WHERE 1=1";

          // Search Logic (Case Insensitive)
          if (isset($_GET['search']) && !empty($_GET['search'])) {
              $search_term = $conn->real_escape_string($_GET['search']);
              $sql .= " AND (LOWER(course_name) LIKE LOWER('%$search_term%') OR LOWER(course_desc) LIKE LOWER('%$search_term%'))";
          }

          // Dropdown Logic
          if (isset($_GET['course_select']) && !empty($_GET['course_select'])) {
              $select_term = $conn->real_escape_string($_GET['course_select']);
              $sql .= " AND course_name = '$select_term'";
          }

          $result = $conn->query($sql);

          // --- DISPLAY LOOP ---
          if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $course_id = $row['course_id'];
              $course_name = $row['course_name'];
              $course_desc = $row['course_desc'];
              $course_author = $row['course_author'];
              $course_img = $row['course_img'];
              
              // Image path fix
              $final_img = str_replace('../', './', $course_img); 
        ?>
            <div class="course-card">
              <img src="<?php echo $final_img; ?>" alt="<?php echo $course_name; ?>">
              <div class="card-body">
                <h3 class="card-title"><?php echo $course_name; ?></h3>
                <div><span class="badge badge-primary" style="background: #007bff; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">Course</span></div>
                <p style="margin-top: 10px; color: #555; font-size: 0.95rem; line-height: 1.5; flex-grow: 1;">
                  <?php echo substr($course_desc, 0, 90); ?>...
                </p>
                <p style="font-size: 0.9rem; color: #888; margin-bottom: 15px;">Instructor: <?php echo $course_author; ?></p>
                <a href="coursedetail.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary" style="display: block; width: 100%; text-align: center; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px;">Enroll for Free</a>
              </div>
            </div>
        <?php
            }
          } else {
            // No Results View
            echo "<div style='grid-column: 1 / -1; text-align: center; padding: 3rem;'>";
            echo "<h3 style='color: #555;'>No courses found matching your criteria.</h3>";
            echo "<br><a href='courses.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View All Courses</a>";
            echo "</div>";
          }
        ?>
      </div> </div>
  </section>

  <!-- <section style="background-color: #2C3E50; color: white; text-align: center; padding: 40px 0;">
    <div class="container">
      <h2 style="color: white; margin-bottom: 10px;">Can't Find What You're Looking For?</h2>
      <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.8;">Suggest a course topic or become an instructor!</p>
      <a href="register.php" style="background: transparent; border: 2px solid white; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: 0.3s;">Become an Instructor</a>
    </div>
  </section> -->

  <?php include('./footer.php'); ?>
</body>
</html>