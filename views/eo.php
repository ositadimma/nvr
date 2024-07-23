<?php
include $_SERVER['DOCUMENT_ROOT']."/os0072/connection.php";
session_start();
// $sql = "SELECT Lastname, Age FROM Persons ORDER BY Lastname";
// $result = mysqli_query($mysqli, $sql);


// // Fetch all
// mysqli_fetch_all($result, MYSQLI_ASSOC);

// // Free result set
// mysqli_free_result($result);

// mysqli_close($mysqli);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body >
    <div class='dashboard-container'>
    <div class='sideboardcover'>
      <?php
        include "sideboard.php";
        ?>
          
          <div class style='padding-left: 50px; padding-top: 30px; width: 100%'>
           <span>search user</span> <input type="search">
           <div><button>add user</button></div>
           <div class='table-body'>
            <div class='table-container'>

            </div>
          <table >
  <tr>
    <th class='thead'>Name</th>
    <th class='thead'>Voter Id</th>
    <th class='thead'>Polling unit</th>
    <th class='thead'>Approved</th>
    <th class='thead'></th>
  </tr>
  <!-- <tr> -->
    <?php
        $query0= "SELECT email, firstname, middlename, lastname, voterId from users where type='basic'";
        $data0 = mysqli_query($mysqli, $query0);
        $data0Array = $data0 -> fetch_all(MYSQLI_ASSOC);;//mysqli_fetch_array($data0, MYSQLI_NUM);
        print_r($data0Array);
        echo sizeof($data0Array);
        for ($i=0; $i <sizeof($data0Array) ; $i++) { 
          echo "<tr>
                  <td class='tname'>".$data0Array[$i]['firstname'].' '.$data0Array[$i]['middlename'].' '.$data0Array[$i]['lastname']."</td></tr>
                  <td>".$data0Array[$i]['voterId']."</td>
                  <td>".$data0Array[$i]['polling_unit']."</td>
                  ";
        # code...
        // echo '<div>'.$data0Array[$i].'</div>';
        // echo "<td>".$data0Array[$i]['firstname']."</td>";
        // echo "<td>".$data0Array[$i]['middlename']."</td>";
        // echo "<td>".$data0Array[$i]['lastname']."</td>";
        // echo "<td>".$data0Array[$i]['firstname']."</td>";
        // echo "<td>".$data0Array[$i]['firstname']."</td>";
        // echo "<td class='tname'>".$data0Array[$i]['firstname']."</td>
        // <td class='tcontent'>".$data0Array[$i]['firstname']."</td>
        // <td class='tcontent'>".$data0Array[$i]['firstname']."</td>
        // <td class='tcontent'>".Approved."</td>
        // <td class='tcontent'><button>Edit</button></td>";
        }
      //  if($data0Array==[]){
      //      $sql = "INSERT INTO users (email, name, password, category) VALUES ('$email', '$name', '$password', '$category')";
      //      $result = mysqli_query($mysqli, $sql);
      //      header("Location: login.php");
      //      die();
      //      // // Fetch all
      //      // mysqli_fetch_all($result, MYSQLI_ASSOC);
      //  }  
    ?>
  <!-- </tr> -->

</table> 
          </div>
          </div>
          </div>
    </div>
</body>
<script src='js/recipe.js'></script>
  
</html>