
<!-- Header LOGIN_SIGNUP Section -->

<?php

    if(isset($_POST['logout'])){
        session_start();
        session_destroy();
        header("Location: index.php");
    }

?>
<div class="header">
    <nav class="navbar navbar-custom-header navbar-expand-lg ">
        <a class="navbar-logo" href="login_signup.php"><img class="logo" src="images/main_logo.png" alt=""></a>               
        <button type="button" class="btn btn-outline-warning right logout"><a class="header-btn" href="index.php">LOGOUT</a></button>
    </nav> 
</div>
<style>
    .header-btn{
        width: 350px;
    height: 50px;
    text-align: center;
    border-color: #D5A021;
    outline-color: #D5A021;
}
    </style>