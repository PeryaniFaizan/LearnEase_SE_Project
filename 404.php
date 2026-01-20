<?php
session_start();

// Send proper 404 HTTP status so browsers and crawlers see this as Not Found
http_response_code(404);
header("HTTP/1.1 404 Not Found");

// --- CONFIGURATION ---
// This ensures links work even if the URL is "deep" (e.g. index.php/folder/trash)
// Update this text if you ever rename your main folder
$path = "/S.E_Project-main/"; 

// Determine where the "Back" button should go
$backLink = $path . 'index.php'; // Default: Main Home
$btnText  = 'Back to Home';

if (isset($_SESSION['is_admin_login'])) {
    // Admin goes to Admin Courses
    $backLink = $path . 'Admin/admincourses.php';
    $btnText  = 'Back to Admin Dashboard';
} else if (isset($_SESSION['is_login'])) { 
    // Student goes to their dashboard
    $backLink = $path . 'student-dashboard.php';
    $btnText  = 'Back to Dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            text-align: center;
        }
        .error-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-size: 6rem;
            color: #E74C3C;
            margin-bottom: 0.5rem;
        }
        h2 {
            font-size: 2rem;
            color: #155392;
            margin-bottom: 1rem;
        }
        p {
            color: #7F8C8D;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        .btn {
            display: inline-block;
            background: #4A90E2;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
            background: #357ABD;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <h1>404-error</h1>
        <h2>Page Not Found</h2>
        <p>Oops! The page you are looking for doesn't exist or has been moved.</p>
        
        <a href="<?php echo $backLink; ?>" class="btn"><?php echo $btnText; ?></a>
    </div>

</body>
</html>