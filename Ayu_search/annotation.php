<?php
    session_start();
    include 'conn.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/ShowDataTable2.css">
    <title>Document</title>
</head>
<body>
    
    <?php
        if(!isset($_SESSION['user']))
        {
          header('location:index.php');
        }
        echo "<div class='title'><h1>Protein-ligand Interaction ( ".$_GET['compound']." - ".$_GET['gene']."  )</h1></div>";
    ?>
    <div id="one">
        <br>  
        <?php
         $imageName = $_GET['compound'].'_'.strtoupper($_GET['gene']).'.JPG';
        if(file_exists("images/".$imageName)){
            echo "<img class='struct' src='images/".$imageName."' alt='structure' >";
        }else{
            $imageName = $_GET['compound'].'_'.strtolower($_GET['gene']).'.JPG';
            echo "<img class='struct' src='images/".$imageName."' alt='structure' >";
        }
        ?>  
        <img class="label" src="images/label.JPG" alt="label">
     </div>
</body>
</html> 