<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  

  <!-- Login Section -->
  <section>
    <div class="container">
      <div style="max-width: 450px; margin: 0 auto;">
        <div class="card">
          <div class="text-center mb-2">
            <h1 style="color: #4A90E2;">Welcome Back Admin!</h1>
            <p>Admin Login Form</p>
          </div>

          <form action="process-login.php" method="POST">
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="adminemail" name="email" class="form-control" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="adminpassword" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
            
              <!-- <a href="#" style="color: #4A90E2; text-decoration: none;">Forgot Password?</a> -->
            </div>
            <small id="statusAdminLogMsg"></small>
            <button type="button" class="btn btn-primary" style="width: 100%; padding: 0.8rem;" 
            onclick="checkAdminLogin()">Login</button>
          </form>

          

        
        </div>
      </div>
    </div>
  </section>

  
 <!-- Load jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load your AJAX file ONCE -->
<script src="js/adminajaxrequest.js"></script>
</body>
</html>
