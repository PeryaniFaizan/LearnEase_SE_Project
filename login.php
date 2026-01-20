<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include('./header.php'); ?>

  <section>
    <div class="container">
      <div style="max-width: 450px; margin: 0 auto;">
        <div class="card">
          <div class="text-center mb-2">
            <h1 style="color: #4A90E2;">Welcome Back!</h1>
            <p>Login to continue your learning journey</p>
          </div>

          <form id="stuLoginForm">
            <div class="form-group">
              <label for="stuLogEmail">Email Address</label>
              <input type="email" id="stuLogEmail" name="stuLogEmail" class="form-control" placeholder="your@maju.edu.pk" required>
            </div>

            <div class="form-group">
              <label for="stuLogPass">Password</label>
              <input type="password" id="stuLogPass" name="stuLogPass" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="form-group" style="display: flex; justify-content: flex-end; align-items: center;">
              <a href="#" style="color: #4A90E2; text-decoration: none; font-size: 0.9rem;">Forgot Password?</a>
            </div>

            <div class="text-center">
               <small id="statusLogMsg"></small>
            </div>
            
            <button type="button" class="btn btn-primary" style="width: 100%; padding: 0.8rem; margin-top: 1rem;" 
            onclick="checkStuLogin()">Login</button>
          </form>

          <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #E0E0E0; text-align: center;">
            <p style="color: #7F8C8D;">Don't have an account? <a href="register.php" style="color: #4A90E2; text-decoration: none; font-weight: 500;">Sign up for free</a></p>
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