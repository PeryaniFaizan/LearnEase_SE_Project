<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Web Development - LearnEase</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="container">
      <a href="index.php" class="logo">Learn<span>Ease</span></a>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="courses.php">Courses</a></li>
      </ul>
      <div class="nav-actions">
        <a href="login.php" class="btn btn-outline">Login</a>
        <a href="register.php" class="btn btn-primary">Sign Up</a>
      </div>
    </div>
  </nav>

  <!-- Course Header -->
  <section style="background: linear-gradient(135deg, #4A90E2 0%, #50C878 100%); color: white; padding: 3rem 0;">
    <div class="container">
      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: center;">
        <div>
          <span class="badge badge-primary" style="margin-bottom: 1rem;">Web Development</span>
          <h1 style="color: white; font-size: 2.5rem;">Complete Web Development Bootcamp</h1>
          <p style="font-size: 1.1rem; color: white; margin: 1rem 0;">Master modern web development from scratch - HTML, CSS, JavaScript, and beyond</p>
          <div style="display: flex; gap: 2rem; flex-wrap: wrap; margin-top: 1.5rem;">
            <div>
              <div style="color: white; font-size: 0.9rem; opacity: 0.9;">Instructor</div>
              <div style="font-weight: bold; color: white;">Sarah Johnson</div>
            </div>
            <div>
              <div style="color: white; font-size: 0.9rem; opacity: 0.9;">Students Enrolled</div>
              <div style="font-weight: bold; color: white;">12,543</div>
            </div>
            <div>
              <div style="color: white; font-size: 0.9rem; opacity: 0.9;">Course Level</div>
              <div style="font-weight: bold; color: white;">Beginner</div>
            </div>
          </div>
        </div>
        <div class="card" style="background-color: white;">
          <img src="https://via.placeholder.com/400x250/4A90E2/FFFFFF?text=Course+Preview" alt="Course Preview" style="width: 100%; border-radius: 5px; margin-bottom: 1rem;">
          <h2 style="font-size: 2rem; color: #50C878; margin-bottom: 1rem;">Free Course</h2>
          <a href="#" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-bottom: 0.5rem;">Enroll for Free</a>
          <a href="#" class="btn btn-outline" style="width: 100%; text-align: center;">Add to Wishlist</a>
          <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #E0E0E0;">
            <p style="font-size: 0.9rem; color: #7F8C8D; margin-bottom: 0.5rem;">✓ Lifetime access</p>
            <p style="font-size: 0.9rem; color: #7F8C8D; margin-bottom: 0.5rem;">✓ Certificate of completion</p>
            <p style="font-size: 0.9rem; color: #7F8C8D;">✓ Access on mobile and desktop</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Course Info Tabs -->
  <section>
    <div class="container">
      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
          <!-- What You'll Learn -->
          <div class="card mb-2">
            <h2>What You'll Learn</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Build complete websites from scratch</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Master HTML5 and CSS3 fundamentals</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Learn JavaScript and modern ES6+</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Create responsive mobile-friendly sites</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Work with APIs and external data</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Deploy projects to production</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Use Git for version control</p>
              </div>
              <div style="display: flex; gap: 0.5rem;">
                <span style="color: #50C878;">✓</span>
                <p style="margin: 0;">Build portfolio-ready projects</p>
              </div>
            </div>
          </div>

          <!-- Course Description -->
          <div class="card mb-2">
            <h2>Course Description</h2>
            <p>This comprehensive course takes you from complete beginner to confident web developer. You'll learn by building real projects and gain hands-on experience with modern web technologies.</p>
            <p>Whether you want to start a career in web development, freelance, or build your own projects, this course provides all the skills you need. We cover everything from the basics of HTML and CSS to advanced JavaScript concepts and modern frameworks.</p>
            <p>By the end of this course, you'll have built multiple projects for your portfolio and be ready to take on professional web development work.</p>
          </div>

          <!-- Course Curriculum -->
          <div class="card mb-2">
            <h2>Course Curriculum</h2>
            <p style="color: #7F8C8D; margin-bottom: 1.5rem;">8 sections • 124 lectures • 42h 18m total length</p>

            <div style="border: 1px solid #E0E0E0; border-radius: 5px; overflow: hidden;">
              <div style="background-color: #F8F9FA; padding: 1rem; border-bottom: 1px solid #E0E0E0; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 style="font-size: 1.1rem; margin: 0;">Section 1: Getting Started</h3>
                  <span style="color: #7F8C8D;">6 lectures • 1h 12m</span>
                </div>
              </div>
              <div style="padding: 1rem; background-color: white;">
                <div style="padding: 0.5rem 0; display: flex; justify-content: space-between;">
                  <span>📄 Introduction to Web Development</span>
                  <span style="color: #7F8C8D;">12:34</span>
                </div>
                <div style="padding: 0.5rem 0; display: flex; justify-content: space-between;">
                  <span>📄 Setting Up Your Development Environment</span>
                  <span style="color: #7F8C8D;">15:22</span>
                </div>
                <div style="padding: 0.5rem 0; display: flex; justify-content: space-between;">
                  <span>📄 Your First Web Page</span>
                  <span style="color: #7F8C8D;">18:45</span>
                </div>
              </div>
            </div>

            <div style="border: 1px solid #E0E0E0; border-radius: 5px; overflow: hidden; margin-top: 1rem;">
              <div style="background-color: #F8F9FA; padding: 1rem; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 style="font-size: 1.1rem; margin: 0;">Section 2: HTML Fundamentals</h3>
                  <span style="color: #7F8C8D;">12 lectures • 3h 24m</span>
                </div>
              </div>
            </div>

            <div style="border: 1px solid #E0E0E0; border-radius: 5px; overflow: hidden; margin-top: 1rem;">
              <div style="background-color: #F8F9FA; padding: 1rem; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 style="font-size: 1.1rem; margin: 0;">Section 3: CSS Styling & Layout</h3>
                  <span style="color: #7F8C8D;">18 lectures • 5h 42m</span>
                </div>
              </div>
            </div>

            <div style="border: 1px solid #E0E0E0; border-radius: 5px; overflow: hidden; margin-top: 1rem;">
              <div style="background-color: #F8F9FA; padding: 1rem; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 style="font-size: 1.1rem; margin: 0;">Section 4: JavaScript Basics</h3>
                  <span style="color: #7F8C8D;">22 lectures • 6h 15m</span>
                </div>
              </div>
            </div>

            <div style="border: 1px solid #E0E0E0; border-radius: 5px; overflow: hidden; margin-top: 1rem;">
              <div style="background-color: #F8F9FA; padding: 1rem; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 style="font-size: 1.1rem; margin: 0;">Section 5: Advanced JavaScript</h3>
                  <span style="color: #7F8C8D;">20 lectures • 7h 30m</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Requirements -->
          <div class="card mb-2">
            <h2>Requirements</h2>
            <ul style="padding-left: 1.5rem;">
              <li>No prior programming experience needed</li>
              <li>A computer (Windows, Mac, or Linux)</li>
              <li>Internet connection</li>
              <li>Enthusiasm to learn!</li>
            </ul>
          </div>
        </div>

        <!-- Sidebar -->
        <div>
          <!-- Instructor Info -->
          <div class="card mb-2">
            <h3>Instructor</h3>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
              <img src="https://via.placeholder.com/80/4A90E2/FFFFFF?text=SJ" alt="Instructor" style="width: 80px; height: 80px; border-radius: 50%;">
              <div>
                <h4 style="margin-bottom: 0.3rem;">Sarah Johnson</h4>
                <p style="font-size: 0.9rem; color: #7F8C8D; margin-bottom: 0.5rem;">Senior Web Developer</p>
                <p style="font-size: 0.85rem;">🎓 25,000+ Students</p>
                <p style="font-size: 0.85rem;">📚 5 Courses</p>
              </div>
            </div>
            <p style="margin-top: 1rem; font-size: 0.9rem;">Sarah is a full-stack developer with 10+ years of experience building web applications for Fortune 500 companies.</p>
          </div>

          <!-- Course Features -->
          <div class="card">
            <h3>This course includes:</h3>
            <div style="margin-top: 1rem;">
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">📹 42 hours video content</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">📝 15 coding exercises</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">📄 20 downloadable resources</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">🎯 10 hands-on projects</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">🏆 Certificate of completion</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">♾️ Lifetime access</p>
              <p style="font-size: 0.9rem; margin-bottom: 0.8rem;">📱 Mobile & desktop access</p>
              <p style="font-size: 0.9rem;">💬 Q&A support</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
   <?php 
  include('./footer.php');
  ?>
</body>
</html>
