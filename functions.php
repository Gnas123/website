<?php

    function getUser($conn, $username) {
        $query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    function getAccess(){
        // Check if the user is allowed access
        if(!isset($_SESSION['islogin'])) {
            return true;
        }
        if ($_SESSION['islogin'] == true) {
            return false;
        }
        return true;
    }

    function getUserType(){
        if (isset($_SESSION['usertype'])) {
            if ($_SESSION['usertype'] == 1) {
                return "admin";
            } else if ($_SESSION['usertype'] == 0) {
                return "user";
            }
        }
        return "guest";
    }

    function setLogin($user_db, $password){
        // login thanh cong
        // $user_db = getUser($conn, $username);
        // $user_pass = $user_db['pass'];
        $hash_pass = md5($password);
        $user_hash_pass = $user_db['hash_pass']; 

        // check passwork correctness
        if ($hash_pass != $user_hash_pass){
            echo "<script>
                alert('Incorrect password or username');
                window.location.href = 'index.php?page_type=login';
            </script>";
            // http://localhost/website/index.php?page_type=login
            die;
        }

        $_SESSION['username'] = $user_db['name'];
        $_SESSION['islogin'] = true;                //! login thanh cong
        $_SESSION['usertype'] = $user_db['admin'];  //! type of user   
        
        // Set a cookie for the user's login
        setcookie("username", $user_db['username'], time() + (86400 * 1), "/"); // Expires in 1 days

    }

    function setRegister($conn, $username, $password, $email, $name=null){
        // check existed username
        if (getUser($conn, $username)) {
            return false; // Username already exists
        } 
        if(!$name){
            $name = $username;
        }
        // save to db
        $hash_password = md5($password);
        // luon la user, admin can tao rieng
        $query = "INSERT INTO user (username, name, hash_pass, email, admin) VALUES ('$username', '$name', '$hash_password', '$email', 0)";                    
        
        // include_once("connection.php");
        $conn->query($query);

        return true;
    }

    // function updateUser($conn, $username, $name, $email){
    //     if (empty($username) || empty($name) || empty($email)) {
    //         return false; // Missing required fields
    //     }
    //     // check existed username
    //     if (!getUser($conn, $username)) {
    //         return false; // Username not exists
    //     } 
    //     // save to db
    //     $query = "UPDATE user 
    //                 SET username='$username', 
    //                     name='$name', 
    //                     email='$email', 
    //                 WHERE username='$username'
    //             ";                    
        
    //     // include_once("connection.php");
    //     $conn->query($query);

    //     return true;
    // }
    function updateUser($conn, $username, $name, $email) {
        if (empty($username) || empty($name) || empty($email)) {
            return false; // Missing required fields
        }
        // Check if the username exists
        if (!getUser($conn, $username)) {
            return false; // Username does not exist
        }
        // Save to database
        $query = "UPDATE user 
                  SET username='$username', 
                      name='$name', 
                      email='$email' 
                  WHERE username='$username'";
    
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            echo "Error updating record: " . $conn->error;
            return false;
        }
    }
    function deleteUser($conn, $username) {
        if (empty($username)) {
            return false; // Missing required field
        }
        // Check if the username exists
        if (!getUser($conn, $username)) {
            return false; // Username does not exist
        }
        // Delete the user from the database
        $query = "DELETE FROM user WHERE username='$username'";
    
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            echo "Error deleting user: " . $conn->error;
            return false;
        }
    }
?>