<?php
// Include config file
require_once "../db_conn.php";
 
// Define variables and initialize with empty values
$email= $firstname = $middlename = $surname = $password = $confirm_password = "";
$email_err = $firstname_err = $middlename_err = $general_err = $surname_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate values
  
    if(empty(trim($_POST["firstname"])) 
    || empty(trim($_POST["surname"]))
    || empty(trim($_POST["email"]))
    ){
        if(empty(trim($_POST["firstname"])) ){
            $firstname_err = "Please enter a firstname.";
        }
        if(empty(trim($_POST["surname"])) ){
            $surname_err = "Please enter a surname.";
        }
        if(empty(trim($_POST["email"])) ){
            $email_err = "Please enter an email.";
        }
    }  else{
        if(!preg_match('/^[a-zA-Z]+$/', trim($_POST["firstname"]))){
            $firstname_err = "firstname can only contain letters";
            
        } 
        if(!preg_match('/^[a-zA-Z]+$/', trim($_POST["middlename"]))){
            $middlename_err = "middlename can only contain letters";
            
        } 
        if(!preg_match('/^[a-zA-Z]+$/', trim($_POST["surname"]))){
            $surname_err = "surname can only contain letters";
            
        } 
        // if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     $email_err= "please enter a valid email";
        // }
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $email_err= "please enter a valid email";
        }
        // Prepare a select statement
        // $stmt = "SELECT id, firstname FROM accounts WHERE email = '$email'";
        // $res = mysqli_query($mysqli, $sql); 
        // $data = $res -> fetch_array(MYSQLI_NUM);
        // echo mysqli_error($mysqli);
        // if($data==[]){
        // }
    
        // $num = mysqli_num_rows($result);  
        $sql = "SELECT id, firstname FROM accounts WHERE email = ?";
      
        
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_firstname = trim($_POST["firstname"]);
            $param_middlename = trim($_POST["middlename"]);
            $param_surname = trim($_POST["surname"]);
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email has been used already.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && 
    empty($firstname_err) && 
    empty($middlename_err) && 
    empty($surname_err) && 
    empty($password_err) && 
    empty($confirm_password_err)){
        
        // // Prepare an insert statement
        $refno= 'rg'.time();
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $res = mysqli_query($con, "INSERT INTO accounts (ref_no, email, firstname, middlename, surname, 
        password, type) VALUES ('$refno','$param_email','$param_firstname', '$param_middlename', 
        '$param_surname', '$param_password', 'basic')");
        if($res){
            header("Location: login.php");
        } else {
            $general_err= 'something went wrong';
        }
         
    }
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Create a new voter account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>firstname</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div> 
            <div class="form-group">
                <label>middlename</label>
                <input type="text" name="middlename" class="form-control <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middlename; ?>">
                <span class="invalid-feedback"><?php echo $middlename_err; ?></span>
            </div>
            <div class="form-group">
                <label>surname</label>
                <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                <span class="invalid-feedback"><?php echo $surname_err; ?></span>
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>      
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        <span class="invalid-feedback"><?php echo $general_err; ?></span>
    </div>    
</body>
</html>