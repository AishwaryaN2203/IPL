<?php
 session_start();
// Include configuration file
include_once 'configuration/db-configuration.php';

// Define variables and initialize with empty values
$email2 = $password2 = $confirm_password = "";
$email1 = $password1 = "";

$email_err1 = $password_err1 = $err =  "";
$email_err2 = $password_err2 = $confirm_password_err = "";

// Sign-Up
if(isset($_POST['btn2'])){

    $email2 = trim($_POST['email2']);
    $password2 = trim($_POST['password2']);
    $confirm_password = trim($_POST['confirm_password']);

    if(empty($email2))
        $email_err2 = "Email is Required!!";
    elseif(!filter_var($email2,FILTER_VALIDATE_EMAIL))
        $email_err2 = "Email must be a valid email address";
    if(empty($password2))
        $password_err2 = "Password is Required!!";
    elseif(strlen($password2)<6)
        $password_err2 = "Password should at-least have a length 6";
    if($password2 != $confirm_password)
        $confirm_password_err = "Passwords don't match";
    

    $user_already_exists = "SELECT * FROM sign_up WHERE email_id ='$email2' LIMIT 1";
    $result = mysqli_query($conn,$user_already_exists);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
 
    if($user)
        $email_err2 = "Email already Exists";

    if(empty($email_err2) && empty($password_err2) && empty($confirm_password_err)){

       // $password2 = md5($confirm_password);
        
        $query = "INSERT INTO sign_up (email_id,password,confirm_password) VALUES ('$email2','$password2','$confirm_password')";

        if(mysqli_query($conn,$query)){
            header('location:login_signup.php');
        }
        else
            echo "Query Error";
    }
}

// login
if(isset($_POST["btn1"])){

        $email1 = trim($_POST['email1']);
        $password1 = trim($_POST['password1']);

        if(empty($email1))
            $email_err1 = "Email is Required";
        if(empty($password1))
            $password_err1 ="Password is Required";

        if(empty($email_err1) && empty($password_err1)){
           // $password1 = md5($password1);
            $query = "SELECT user_id FROM sign_up WHERE email_id ='$email1' AND password='$password1' ";
            $results = mysqli_query($conn,$query);
            $q = mysqli_fetch_all($results);

            if(mysqli_num_rows($results) == 1){
                
                $_SESSION['email']=$email1;
                $_SESSION['userId'] = $q[0][0];
                $_SESSION['success'] = "You are now logged in";

                if($email1 == 'ADMINIPL@GMAIL.COM'){
                    header('location:match-admin.php');
                }
                else
                    header('location:match-user.php');
            }else
                $err = "Wrong Email-Id or Password ";
        }
}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>
<?php include('templates/header-ls.php')?>
<link rel="stylesheet" href="stylesheets/login-signup.css">
    <div class="ls-container">
        <div class="form-bx">
        
            <div class="button-Bx">
                <div id="ls-btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="signup()">Sign Up</button>
            </div>
            
            <form id="login" action="" class="input-group" method="post"> 
                <input type="text" class="input-field" value="<?php echo htmlspecialchars($email1) ?>" name="email1" placeholder="Email" >
                <div class="red-text"><?php echo $email_err1 ?></div>
                <input type="password" class="input-field" name="password1" placeholder="Password" >
                <div class="red-text"><?php echo $password_err1 ?></div>
                <div class="red-text"><?php echo $err?></div>
                <button type="submit" name="btn1" class="submit-btn">Login</button>
            </form>

            <form id="signup" class="input-group" action="" method="post">
                <input type="text" class="input-field" value="<?php echo htmlspecialchars($email2) ?>" name="email2" placeholder="Email" >
                <div class="red-text"><?php echo $email_err2 ?></div>
                <input type="password" class="input-field" value="<?php echo htmlspecialchars($password2) ?>" name="password2" placeholder="Password" >
                <div class="red-text"><?php echo $password_err2 ?></div>
                <input type="password" class="input-field" value="<?php echo htmlspecialchars($confirm_password) ?>" name="confirm_password" placeholder="Confirm password" >
                <div class="red-text"><?php echo $confirm_password_err ?></div>
                <button type="submit" name="btn2" class="submit-btn">Sign Up</button>
            </form>

        </div>
    </div>    


<?php include('templates/footer.php') ?>

<script>
    const x = document.getElementById("login");
    const y = document.getElementById("signup");
    const z = document.getElementById("ls-btn");

    function signup(){
        x.style.left = "-400px";
        y.style.left = "50px";
        z.style.left = "100px";
    }

    function login(){
        x.style.left = "50px";
        y.style.left = "450px";
        z.style.left = "0px";
    }

</script>

</html>