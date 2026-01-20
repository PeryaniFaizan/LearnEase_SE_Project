<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include('./header.php'); ?>


  <!-- Register Section -->
  <section>
    <div class="container">
      <div style="max-width: 550px; margin: 0 auto;">
        <div class="card">
          <div class="text-center mb-2">
            <h1 style="color: #4A90E2;">Create Your Account</h1>
            <p>Join LearnEase and start your learning journey today</p>
          </div>

          <form action="process-register.php" id="registerForm" method="POST">
            <div class="form-group">
              <label for="full-name">Full Name</label> <small id="statusMsg1"></small>
              <input type="text" id="fullname" name="full_name" class="form-control" placeholder="Enter your Full Name" required>
            </div>

            <div class="form-group">
              <label for="email">Email Address</label> <small id="statusMsg2"></small>
              <input type="email" id="email" name="email" class="form-control" placeholder="your@maju.edu.pk" required>
            </div>

            <div class="form-group">
            <label for="std_phone">Phone Number</label><small id="statusMsg5"></small>
            <input type="text" id="std_phone" name="std_phone" class="form-control" maxlength="11"
            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
              placeholder="03xxxxxxxxx" required>

            </div>
            <div class="form-group">
              <label for="std_age">Age</label>
              <small id="statusMsg6"></small>
              <input type="text" id="std_age" name="std_age" class="form-control" placeholder="" required
              oninput="this.value=this.value.replace(/[^0-9]/g,'')"
              required>

            </div>
            <div class="form-group">
              <label for="std_gender">Gender</label>
              <small id="statusMsg7"></small>
              <div class="form-group">
                <select id="std_gender" name="std_gender" class="form-control" required>
                  <option value="">Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div> 
            </div>


            <div class="form-group">
              <label for="password">Password</label> <small id="statusMsg3"></small>
              <input type="password" id="password" name="password" class="form-control" placeholder="Create a strong password" required>
              <!-- <label for="password">Atleast 8 Characters</label> -->
            </div>

            <div class="form-group">
              <label for="confirm-password">Confirm Password</label> <small id="statusMsg4"></small>
              <input type="password" id="confirmpassword" name="confirm_password" class="form-control" placeholder="Re-enter your password" required>
            </div>

            <span id="successMsg"></span>
            <button type="button" class="btn btn-primary" style="width: 100%; padding: 0.8rem;" onclick="addStu()" id="signup">Create Account</button>
          </form>

          <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #E0E0E0; text-align: center;">
            <p style="color: #7F8C8D;">Already have an account? <a href="login.php" style="color: #4A90E2; text-decoration: none; font-weight: 500;">Login here</a></p>
          </div>
        </div>
      </div>
    </div>
    
  </section>




  <?php include('./footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/ajaxrequest.js"></script>

</body>
</html>