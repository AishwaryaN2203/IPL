<?php
session_start();

include('configuration/db-configuration.php');
include('imp/function.php');
include('imp/trigger.php');

$match_no = $_SESSION['selected_match_id'];
$sql = "SELECT * FROM schedule_table WHERE match_id = $match_no ";
$result  = mysqli_query($conn,$sql);
$match_info = mysqli_fetch_all($result);

$email = $_SESSION['email'];
$t1 = $match_info[0][0];
$t2 = $match_info[0][1];

$sql_t1 = "SELECT name FROM team_table WHERE team_id = $t1";
$result = mysqli_query($conn,$sql_t1); 
$r_t1 = mysqli_fetch_all($result);
$team1 = $r_t1[0][0];

$sql_t2 = "SELECT name FROM team_table WHERE team_id = $t2";
$result = mysqli_query($conn,$sql_t2);
$r_t2 = mysqli_fetch_all($result);
$team2 = $r_t2[0][0];

$dob = $first = $last = $gender = $phno = $payment = "";
$dob_err = $first_err = $last_err = $gender_err = $phno_err = $payment_err = "";

if(isset($_POST["submit"])){
    $dob = trim($_POST['date']);
    $first = trim($_POST['name1']);
    $last = trim($_POST['name2']);
    $phno = trim($_POST['number']);
    $seat_req = trim($_POST['seats']);

    if(empty($dob))
        $dob_err = "Date of Birth is Required!!";
    if(empty($first))
        $first_err = "First name field is required";
    if(empty($last))
        $last_err = "Last name field is required";
    if(empty($phno)) 
        $phno_err = "Phone No field is required";
    else if(!( strlen($phno)==10))
        $phno_err = "Phone No has to be 10 digits";


    $_SESSION['seats_req']  = $seat_req;
    
    if(isset($_POST['gender'])){
        if($_POST['gender']=='m')
            $gender = 'male';
        elseif($_POST['gender']=='f')
            $gender = 'female';
        elseif($_POST['gender']=='o')
            $gender = 'other';
    }
    if(empty($gender))
        $gender_err = "Gender field is required";
    
    if(isset($_POST['payment'])){
        if($_POST['payment']=='c')
            $payment = 'credit';
        elseif($_POST['payment']=='d')
            $payment = 'debit';
    }
    if(empty($payment))
        $payment_err = "Payment mode required";
    
    $uid = $_SESSION['userId'];
   
    if(empty($dob_err) && empty($first_err) && empty($last_err) && empty($gender_err) && empty($phno_err) && empty($payment_err))
    {
        if (!($conn->query("UPDATE schedule_table SET seats = seats - $seat_req WHERE match_id = $match_no") === TRUE) )
            echo "Error updating record: " . $conn->error;
  
         
        $amt = $match_info[0][8];  
        $total_amt = $seat_req * $amt;

        $query = "INSERT INTO booking (user_id,match_id,first_name,last_name,DOB,gender,Ph_no,payment,no_of_seats,total_amount) 
        VALUES ('$uid','$match_no','$first','$last','$dob','$gender','$phno','$payment','$seat_req','$total_amt')";	

        if(mysqli_query($conn,$query)){
            $sql = "SELECT book()";
            $results = mysqli_query($conn,$sql);
            $q = mysqli_fetch_all($results) or die('no');

            mysqli_free_result($result);
            $_SESSION['ticket_no'] = $q[0][0];
            header('location:ticket.php');   
        }
        else
            echo "Query Error";  
    }
}
?>


<!doctype html>
<html lang="en" >

<?php include('templates/header.php') ?>
<?php include('templates/header-logout.php') ?>
<?php include('templates/user-header.php')?>
<link rel="stylesheet" href="stylesheets/reserve.css" >
  <div class="res">
    <form action="" method="POST" >
            <div class="title">Booking Details</div>
            <div class="form">
            <div class="input_field">
                <label>User_id : </label>
                <input type="text" disabled  value="<?php echo htmlspecialchars($email)?>" style="color: black;">      
            </div>

            <div class="input_field">
                <label>Match_id : </label>
                <input type="text" disabled  value="<?php echo htmlspecialchars($match_no)?>" style="color: black;"> 
            </div>

            <div class="input_field">
                <label>Match:</label>
                <input type="text" disabled  value="<?php echo htmlspecialchars($team1)?>" style="color: black;" size="2">       
                VS                   
                <input type="text" disabled  value="<?php echo htmlspecialchars($team2)?>" style="color: black;" size="2"> 
            </div>

            <div class="input_field">
                <label>First name : </label>
                <input type="text" name="name1" id="name" value="<?php echo htmlspecialchars($first) ?>" placeholder="Enter Your First Name">
                <div class="red-text"><?php echo $first_err ?></div>   
            </div>

            <div class="input_field">
                <label>Last name : </label>
                <input type="text" name="name2" id="name" value="<?php echo htmlspecialchars($last) ?>" placeholder="Enter Your Last Name">
                <div class="red-text"><?php echo $last_err ?></div><br><br>
            </div>

            <div class="input_field">
                    <label >Gender :</label>
                    <input type="radio" name = "gender" value="m" id="male"><label for="male">Male</label>
                    <input type="radio" name = "gender" value="f" id="female"><label for="female">Female</label>
                    <input type="radio" name = "gender" value="o" id="other"><label for="other">Other</label>
                <div class="red-text"><?php echo $gender_err ?></div>
            </div>            
            
           <div class="input_field">               
                <label>DOB : </label>
                <input type="date" name="date" id="name" value="<?php echo htmlspecialchars($dob) ?>">
                <div class="red-text"><?php echo $dob_err ?></div><br><br>
            </div>
            
            <div class="input_field">     
                <label>Phone number : </label>
                <input type="number" name="number" id="name" value="<?php echo htmlspecialchars($phno) ?>" placeholder="Enter Your Phone no"><br><br>
            </div>
            <div class="red-text"><?php echo $phno_err ?></div>

            <div class="input_field">     
                    <label >PAYMENT MODE:</label><br>
                    <input type="radio" name = "payment" value="c" id="credit"><label for="credit">Credit Card</label>
                    <input type="radio" name = "payment" value="d" id="debit"><label for="debit">Debit Card</label>
            </div>
            <div class="red-text"><?php echo $payment_err ?></div> 
           
            <div class="input_field">
                <label>Seats : </label>
                <input type="number" min='0' max='<?php echo htmlspecialchars($match_info[0][7]) ?>' class="input" id="seats" name="seats" placeholder="Enter number of seats">
            </div> 

            <div class="input_field">
                <input type="submit" value="Confirm" name="submit" class="btn">
            </div> 
     </div>          
    </form>

                    
</div>
    
<?php include('templates/footer.php') ?>
</html>