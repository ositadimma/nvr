<?php
// Include config file
require_once "../db_conn.php";
if ($_SESSION['type']=='admin' || $_SESSION['type']=='eo') {
    echo $_SESSION['type'];
    include "../components/dash_nav.php";
}
 
// Define variables and initialize with empty values
$email= $firstname = $middlename = $surname = $password = $confirm_password = "";
$email_err = $firstname_err = $middlename_err = $general_err = $surname_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    

// $target_dir = "../uploads/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// echo $target_file; 
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }

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
        
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $email_err= "please enter a valid email";
        }
    
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
            $param_line1 = trim($_POST["line1"]);
            $param_line2 = trim($_POST["line2"]);
            $param_post_code = trim($_POST["post_code"]);
            $param_state = trim($_POST["state"]);



            
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
        $res = mysqli_query($con, "INSERT INTO accounts (ref_no, email, firstname, middlename, surname, type) 
        VALUES ('$refno','$param_email','$param_firstname', '$param_middlename', 
        '$param_surname', 'basic')");
        $res1 = mysqli_query($con, "INSERT INTO voters (line1, line2, `post code`, state ) 
    VALUES ('$param_line1','$param_line2','$param_post_code', '$param_state')");
        if($res){
            header("Location: ./admin/accounts.php");
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

    <?php 
    if (isset($_SESSION['type']) && $_SESSION['type']=='admin') {
        echo $_SESSION['type'];
        include "../components/dash_nav.php";
    }
    ?>
   
    <div class="wrapper">
        <h2>Complete Registration.</h2>
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
            <label>Address</label>     
            <div class="form-group">
                <label>line 1</label>
                <input type="text" name="line1" class="form-control ">
                
            </div>
            <div class="form-group">
                <label>line 2</label>
                <input type="text" name="line2" class="form-control">
            </div>
            <div class="form-group">
                <label>post code</label>
                <input type="text" name="post_code" class="form-control ">
                
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="password" name="state" class="form-control">
            </div>
            <!-- Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload"> -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
        <span class="invalid-feedback"><?php echo $general_err; ?></span>
    </div>    
</body>
</html>