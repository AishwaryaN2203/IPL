<?php



?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>

    <div class="ls-container">
        <div class="form-bx">
        
            <div class="button-Bx">
                <div id="ls-btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="signup()">Sign Up</button>
            </div>

            <form id="login" action="" class="input-group">
                <input type="text" class="input-field" name="UserId" placeholder="Email Id" >
                <input type="text" class="input-field" name="Enter Password" placeholder="Password" >
                <button type="submit" class="submit-btn">Login</button>
            </form>

            <form id="signup" action="" class="input-group">
                <input type="text" class="input-field" name="UserId" placeholder="Email Id" >
                <input type="text" class="input-field" name="Enter Password" placeholder="Password" >
                <input type="text" class="input-field" name="Confirm Password" placeholder="Confirm password" >
                <button type="submit" class="submit-btn">Sign Up</button>
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