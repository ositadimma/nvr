<?php
include "../../db_conn.php";

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
        include "../../components/dash_nav.php";
        ?>
          
          <div class style='padding-left: 50px; padding-top: 30px; width: 100%'>
           <span>search user</span> <input type="search">
           <a href='../voter_reg.php'><button>add account</button></a>
           <div class='table-body'>
            <div class='table-container'>

            </div>
          <table >
  <tr>
    <th class='thead'>Name</th>
    <th class='thead'>Voter Id</th>
    <th class='thead'>unit</th>
    <th class='thead'>status</th>
    <th class='thead'></th>
  </tr>
  <!-- <tr> -->
    <?php
        $query= "SELECT email, firstname, middlename, surname from accounts";
        $data = mysqli_query($con, $query);
        $arr = $data-> fetch_all(MYSQLI_ASSOC);;//mysqli_fetch_array($data0, MYSQLI_NUM);
        for ($i=0; $i <sizeof($arr) ; $i++) { 
          echo "<tr>
                  <td class='tname'>".$arr[$i]['firstname'].' '.$arr[$i]['middlename'].' '.$arr[$i]['surname']."</td>
                  <td><a href='../voter_reg.php'><button>edit</button>
                  </tr>
                  ";
        } 
    ?>
    <tr>

    </tr>
  <!-- </tr> -->

</table> 
          </div>
          </div>
          </div>
    </div>
</body>
<script src='js/recipe.js'></script>
  
</html>
