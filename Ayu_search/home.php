<?php
    session_start();
    include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/one.css">
    <title>Document</title>
</head>
<body>
    <?php
        $plant_flag = 0; 
        $animal_flag = 0; 
        $compound_flag = 0; 
        if(!isset($_SESSION['user']))
        {
          header('location:index.php');
        }
        if(isset($_POST['submit'])){
            $selected_value = '';
            try{
                if (!isset($_POST['compound']) and !isset($_POST['plant'])){
                    $selected_value = $_POST['animal']."%Animal";
                }
                if (!isset($_POST['animal']) and !isset($_POST['compound'])){
                    $selected_value = $_POST['plant']."%Plant";
                }
                if (!isset($_POST['animal']) and !isset($_POST['plant'])){
                    $selected_value = $_POST['compound']."%compound";
                    unset($_POST['compound']);
                }
                echo $selected_value;
                $_SESSION['selected_value'] = $selected_value;
                header("Location: ShowDataTable.php");
            }
            catch (Exception $e){
                echo 'message:error';
            }
        }
    ?>
    <div class="title">
        <h1>AYUSearch</h1>
        <p>"A computational tool for cataloguing and predicting the biological activities of Natural products"</p>
    </div>
    <div class="main">
        <div class="about-content">
            <p>About</p> 
            <p>The tool presents the record on natural products used in Traditional 
                Indian Medicinal practice (Ayurveda). Simply it provides the detail 
                on 60 natural compounds, its 636 Phytochemicals and their experimentally
                 validated biological targets. It offers the binding affinity scores for 
                 phytochemicals and their target. The tool further ranks the potential 
                 biological targets for queried items. Also, it integrates the detail 
                 on biological role predicted through KEGG and GO functional annotation.
                  Using this, the user can find the answer for multiple queries at one 
                  place towards phishing through one or two keywords.</p>
        </div>
        <div class="search-heading"><p>Search Data</p></div>
        <div class="main-content">
            <div class="bg-content">
            <!-- <p>Search Data</p> -->
            <ol>
                <div class="select-name">
                    <button onclick="selectPlantName()" class="btn-primary">Plant Name</button>
                    <button onclick="selectAnimalName()" class="btn-primary">Animal Product Name</button>
                    <button onclick="selectCompoundName()" class="btn-primary">Compound Name</button>
                </div>
                <form action="home.php" method="post">
                    <div class="select-option">
                        <div class="selected-plant-content display-element">
                            <label for="plant">Choose a Plant name:</label><br>
                            <select id="plant" name="plant">
                            <option disabled selected>Plant Name</option>  
                                <?php
                                    $sql_fetch="SELECT DISTINCT Scientific_Name, category FROM plantanimaldata";
                                    $result_f=mysqli_query($conn,$sql_fetch);
                                    if(mysqli_num_rows($result_f) > 0)
                                    {
                                        while ($row = mysqli_fetch_assoc($result_f))
                                        {
                                            if($row['category'] == "Plant"){
                                                echo "<option class='".$row['Scientific_Name']."'>".strtoupper($row['Scientific_Name'])."</option>";
                                            }
                                        }
                                        $plant_flag += 1;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="selected-animal-content hide-element">
                            <label for="animal">Choose a Animal Product name:</label>
                            <select id="animal" name="animal">
                            <option disabled selected>Animal Name</option>  
                                <?php
                                        $sql_fetch="SELECT DISTINCT Scientific_Name, category FROM plantanimaldata";
                                        $result_f=mysqli_query($conn,$sql_fetch);

                                        if(mysqli_num_rows($result_f) > 0)
                                        {
                                            while ($row = mysqli_fetch_assoc($result_f))
                                            {
                                                if($row['category'] == "Animal"){
                                                    echo "<option class='".$row['Scientific_Name']."'>".strtoupper($row['Scientific_Name'])."</option>";
                                                }
                                            }
                                            $animal_flag += 1;
                                        }
                                ?>
                            </select>
                        </div>                
                        <div class="selected-compound-content hide-element">
                            <label for="compound">Choose a Compound name:</label><br>
                            <select id="compound" name="compound">
                            <option disabled selected>Compound Name</option>  
                                <?php
                                        $sql_fetch="SELECT DISTINCT Phytochemical_Name FROM plantanimaldata";
                                        $result_f=mysqli_query($conn,$sql_fetch);

                                        if(mysqli_num_rows($result_f) > 0)
                                        {
                                            while ($row = mysqli_fetch_assoc($result_f))
                                            {
                                                    echo "<option class='".$row['Phytochemical_Name']."'>".strtoupper($row['Phytochemical_Name'])."</option>";
                                            }
                                            $compound_flag += 1;
                                        }
                                ?>
                            </select>
                        </div>
        
                        <button onclick="resetValues()" type="submit" name="submit" class="btn-primary" >Submit</button>
                </form>
                </div>
            </ol>
            </div>
        </div>
    </div> 
    <script src="./js/changeState.js"></script>   
</body>
</html>