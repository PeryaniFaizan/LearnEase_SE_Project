<?php
    // 1. Start session safely
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    include_once('../dbConnection.php');

    function json_exit($data) {
        echo json_encode($data);
        exit;
    }

    //CHECK IF EMAIL ALREADY EXISTS ---
    if (isset($_POST['checkemail']) && isset($_POST['email'])) {
    $email = strtolower(trim($_POST['email']));

    // Prepared statement to get count
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM stddata WHERE LOWER(stu_email) = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $count = (int)$row['cnt'];
    $stmt->close();

    // Keep backwards compatibility (return number)
    json_exit($count);
    }


    //REGISTRATION LOGIC ---

    if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['std_age']) && isset($_POST['std_phone']) && isset($_POST['std_gender'])) {
    
        $fullname = trim($_POST['fullname']);
        $email = strtolower(trim($_POST['email']));
        $password_plain = $_POST['password'];
        $std_age = (int)$_POST['std_age'];
        $std_phone = trim($_POST['std_phone']);
        $std_gender = trim($_POST['std_gender']);
        $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

        $role = 'student';
        $stmt = $conn->prepare("INSERT INTO user (user_email, user_pwd, role) VALUES (?, ?, ?)");
        if (!$stmt) {
            json_exit(["status" => "error", "error" => "DB prepare failed: " . $conn->error]);
        }
        $stmt->bind_param('sss', $email, $password_hashed, $role);
        if (!$stmt->execute()) {
            $stmt->close();
            json_exit(["status" => "user_insert_failed", "error" => $stmt->error]);
        }
        $userId = $conn->insert_id;
        $stmt->close();

            // Prepared Statement for safe insertion
        $stmt = $conn->prepare("INSERT INTO stddata (stu_name, stu_email, stu_phone, stu_age, stu_gender,stu_img ,user_id) VALUES (?, ?, ?, ?, ?, ?,?)");
        if (!$stmt) {
            json_exit(["status" => "error", "error" => "DB prepare failed: " . $conn->error]);
        }
        $img='../image/student/default.jpg';
        $stmt->bind_param('sssisis', $fullname, $email, $std_phone, $std_age, $std_gender,$img, $userId);
        if (!$stmt->execute()) {
            $stmt->close();
            // If student insert fails, consider rolling back user insert or inform the client
            json_exit(["status" => "student_insert_failed", "error" => $stmt->error]);
        }
        $stmt->close();

        // Success
        json_exit("OK");
    }

    // LOGIN LOGIC ---
    if(isset($_POST['checkLogemail']) && isset($_POST['stuLogEmail']) && isset($_POST['stuLogPass'])){

        $stuLogEmail = strtolower(trim($_POST['stuLogEmail']));
        $stuLogPass  = $_POST['stuLogPass'];

        // SQL matches your database columns: stu_email and stu_pass
        $sql = "SELECT *
                FROM user 
                WHERE LOWER(user_email) = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $stuLogEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $row = $result->fetch_assoc();
            $hashed_password = $row['user_pwd'];

            if (password_verify($stuLogPass, $hashed_password)) {
                $user_id = $row['user_id'];
                $sql= "SELECT * FROM stddata WHERE user_id=$user_id";
                $result = $conn->query($sql);
                $data = $result ? $result->fetch_assoc() : [];            
                
                $_SESSION['is_login'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['stu_name'] = isset($data['stu_name']) ? $data['stu_name'] : '';
                $_SESSION['stuLogEmail'] = $stuLogEmail;

                $stmt->close();
                echo json_encode(["status"=>"success","role"=>$row['role'],"name"=>$_SESSION['stu_name']]);
                exit;
            } 
            else {
                // Password mismatch
                $stmt->close();
                echo json_encode(["status"=>"invalid","message"=>"Invalid Email or Password"]);
                exit;
            }
        }
        else { //user no found
            echo json_encode(["status"=>"invalid","message"=>"Invalid Email or Password"]);
            $stmt->close();
            exit;
        }
        $stmt->close();
    }
    $conn->close();
?>