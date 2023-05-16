<?php
    session_start();
    include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
     integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <title>Document</title>
</head>
<body>
 <!-- <div class='title' <link rel="stylesheet" href="CSS/ShowDataTable2.css">><h1>Advanced Search</h1></div> -->
<div>
<?php
        $print=0;
        $Entry="";
        $EntryName="";
        $ProName="";
        $Organism="";
        $records="";
        $target="";
        $flag=0;   
        if(!isset($_SESSION['user']))
        {
          header('location:index.php');
        }     
    ?>
    <?php
        $plant_common_name = '';
        $plant_scientific_name = '';
        $ayurvedic_name = '';
        if(!isset($_POST['submit'])){
            $plant_animal =  explode("_",$_GET['name'])[0];
            $sort_by =  explode("_",$_GET['name'])[1];
            $compound = $_GET['compound'];
            $_SESSION['plant_animal'] = $_GET['name'];
            $_SESSION['compound'] = $_GET['compound'];
        }else{
            $plant_animal = explode("_",$_SESSION['plant_animal'])[0];
            $sort_by = explode("_",$_SESSION['plant_animal'])[1];
            $compound = $_SESSION['compound'];
        }
        $Entry="";
        $EntryName="";
        $ProName="";
        $Organism="";
        $records="";
        $target="";
        $flag=0;        

        if(isset($_POST['submit']))
        {
            $selected_gene = $_POST['p_SupperClass'];
            $sql_fetch3="SELECT Target_Gene,PDB_ID,Binding_affinity FROM plantanimaldata where Phytochemical_Name = '$compound'
            and Scientific_Name = '$plant_animal' and Target_Gene = '$selected_gene'
            ORDER BY Phytochemical_Name DESC, Target_Gene ASC, Binding_affinity DESC";
            $result_f3=mysqli_query($conn,$sql_fetch3);
            $i=0;
            $print=1;
            $target=$_POST['p_SupperClass'];
            if(mysqli_num_rows($result_f3) > 0)
            {
                while ($row = mysqli_fetch_assoc($result_f3))
                {
                    $ID[$i]=$row['PDB_ID'];
                    $score[$i]=$row['Binding_affinity'];
                    $i=$i+1;
                }
            }
        }

    ?>
</div>
    <div class="container">
        <div class="col-12 menu">
            <div class="col-12 main-menu">
                <div class="selected-name">
                    <?php
                        $sql_fetch2="SELECT category,Therapeutics_use,Common_Name,Scientific_Name,Ayurveda_recognition FROM plantanimaldata where Scientific_Name = '$plant_animal'";
                        $result_f2=mysqli_query($conn,$sql_fetch2);
                        if(mysqli_num_rows($result_f2) > 0)
                        {
                            while ($row = mysqli_fetch_assoc($result_f2) and $count == 0)
                            {
                                if($count){
                                    break;
                                }
                                $plant_common_name = $row['Common_Name'];
                                $plant_scientific_name = $row['Scientific_Name'];
                                $ayurvedic_name = $row['Ayurveda_recognition'];
                                $therapeutics_use = $row['Therapeutics_use'];
                                $category = $row['category'];
                             
                            }
                        }
                        echo "<p>".$category." Common Name: <span class='color-select'>".strtoupper($plant_common_name)."</span></p>";
                        echo "<p>".$category." Scientific Name: <i><span class='color-select'>".strtoupper($plant_scientific_name)."</span></i></p>";
                        echo "<p>Ayurveda Recognition of ".$category.": <span class='color-select'>".strtoupper($ayurvedic_name)."</span></p>";
                        echo "<p>Therapeutics use of ".$category." Part : <span class='color-select'>".strtoupper($therapeutics_use)."</span></p>";
                       
                       $sql_fetch="SELECT DISTINCT Target_Gene FROM plantanimaldata where Phytochemical_Name = '$compound'
                         and Scientific_Name = '$plant_animal'
                         ORDER BY Phytochemical_Name DESC, Target_Gene ASC, Binding_affinity DESC";
                        $result_f=mysqli_query($conn,$sql_fetch);
                    ?>
                </div>
                <form action="AdvancedSearch.php?name=".$plant_animal method="post" >
                        <li class="superclass">
                            <select id="p_SupperClass" name="p_SupperClass">
                                <option disabled selected> TargetGene </option> 
                                <?php
                                    if(mysqli_num_rows($result_f) > 0)
                                    {
                                        while ($row = mysqli_fetch_assoc($result_f))
                                        {
                                            echo "<option>".$row['Target_Gene']."</option>";
                                        }
                                    }
                                ?> 
                            </select>
                        </li>
                    <div>
                        <button class="btn-primary" type="submit" name="submit">SUBMIT</button>
                    </div>
                </form>
            </div>
            <div class="col-11 box-ans">
                <div class="box-a col-4 box-ac">
                    <div class="id-title">Compound Name</div>
                        <ul class="scroll"> 
                            <li><?php echo strtoupper($compound) ?></li>                       
                        </ul>
                </div>
                <div class="box-a col-4 box-aa">
                    <div class="id-title">TargetGenes</div>
                    <ul class="scroll">
                         <?php       
                            if($print==1)
                            {
                                $sql_fetch="SELECT DISTINCT Target_Gene FROM plantanimaldata where Phytochemical_Name = '$compound'
                                and Scientific_Name = '$plant_animal'
                                ORDER BY Phytochemical_Name DESC, Target_Gene ASC, Binding_affinity DESC";
                                $result_f=mysqli_query($conn,$sql_fetch);
                                if(mysqli_num_rows($result_f) > 0)
                                {
                                    while ($row = mysqli_fetch_assoc($result_f))
                                    {
                                        $link = "https://www.uniprot.org/uniprot/?query=".$row['Target_Gene']."&sort=score";
                                        if($target == $row['Target_Gene']){
                                            echo "<li><a style='color: red;' href=".$link." target='_blank'>".$row['Target_Gene']."</a></li>";  // displaying data in option menu
                                         }else{
                                             echo "<li><a href=".$link." target='_blank'>".$row['Target_Gene']."</a></li>";  // displaying data in option menu
                                         }
                                     }
                                 }
                            }
                            else
                            {
                                echo "";
                            }
                        
                        ?> 
                    </ul>
                </div>
                <div class="box-a col-4 box-ab"> 
                    <div class="id-title">Hits</div>
                    <ul class="scroll showList">
                        <?php
                                if($print==1)
                                {
                                    $temp = $i;
                                    while($i!=0)
                                    {
                                        $idx = $temp - $i;
                                        $_SESSION['gene'] = $ID[$idx];
                                        $_SESSION['compound'] = $compound;
                                        $imageName1 = $_SESSION['compound'].'_'.strtoupper($_SESSION['gene']).'.JPG';
                                        $imageName2 = $_SESSION['compound'].'_'.strtolower($_SESSION['gene']).'.JPG';
                                        $ID[$idx]=strtoupper($ID[$idx]);
                                        $link1="https://www.rcsb.org/structure/".$ID[$idx];
                                        if(file_exists("images/".$imageName1) or file_exists("images/".$imageName2)){
                                            $imageLink = 'annotation.php?compound='.$_SESSION['compound'].'&gene='.$_SESSION['gene'];
                                            echo "<li><a href='$link1' target='_blank'>".$ID[$idx].":</a>
                                            <a href='$imageLink' target='_blank' style='color: green;'>Docking Result(click here)</a><br>Binding affinity:-".$score[$idx]."kcal/mol</li>";
                                        }else{
                                            echo "<li><a href='$link1' target='_blank'>".$ID[$idx].":</a><br>Binding affinity:-".$score[$idx]."kcal/mol</li>";
                                        }
                                        $i--;
                                    }
                                }
                                else
                                {
                                    echo "";
                                }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="other-options">
                <ol>
                <span class='canonical-smiles'>Compound Canonical SMILES:</span>
                    <?php
                        $name = [];
                        $sql_fetch="SELECT Canonical_SMILES,Druggability FROM phytochemicaldata where Phytochemical = '$compound'";
                        $result_f=mysqli_query($conn,$sql_fetch);
                        if(mysqli_num_rows($result_f) > 0)
                        {
                            while ($row = mysqli_fetch_assoc($result_f))
                            {
                                $name = preg_split('/\s+/', $row['Druggability']);
                                $casnonicasl_name = $row['Canonical_SMILES'];
                            }
                        }
                        echo "<span class='canonical-smiles-value'>".$casnonicasl_name."</span>";
                    ?>
                    <li>1.Druggability <button onclick="selectDrug()">Click to hide/show</button></li>
                    <div class="annot drug-data hide">
                        <table>
                            <tr class="header">
                                <td>No</td>
                                <td>Druggability</td>
                            </tr>
                            <?php
                                echo "<tr class='value'><td>1</td><td>miLogP  ".$name[1]."</td></tr>";
                                echo "<tr class='value'><td>2</td><td>TPSA  ".$name[3]."</td></tr>";
                                echo "<tr class='value'><td>3</td><td>MW  ".$name[5]."</td></tr>";
                                echo "<tr class='value'><td>4</td><td>nON  ".$name[7]."</td></tr>";
                                echo "<tr class='value'><td>5</td><td>nOHNH  ".$name[9]."</td></tr>";
                                echo "<tr class='value'><td>6</td><td>nrotb  ".$name[11]."</td></tr>";
                                echo "<tr class='value'><td>7</td><td>volume  ".$name[13]."</td></tr>";
                                echo "<tr class='value'><td>8</td><td>Drug-likeness model score  ".$name[17]."</td></tr>";
                            ?>
                        </table>
                        <div>
                            <p>Screening based on Lipinski's rule and drug-like behavioral properties</p>
                            <p>Overall Result: PASS</p>
                        </div>
                    </div>
                    <li>2.PASS activity prediction <button  onclick="selectBiological()">Click to hide/show</button></li>
                    <div class="annot biological hide">
                        <table>
                            <tr class="header">
                                <td>No</td>
                                <td>Activity</td>
                                <td>Pa</td>
                                <td>Pi</td>
                            </tr>
                            <?php
                                $sql_fetch="SELECT Activity,Pa,Pi FROM passdata where Phytochemical = '$compound'";
                                $result_f=mysqli_query($conn,$sql_fetch);
                                if(mysqli_num_rows($result_f) > 0)
                                {
                                    $count=0;
                                    while ($row = mysqli_fetch_assoc($result_f))
                                    {
                                        $count += 1;
                                        // $name = preg_split('/\s+/', $row['Druggability']);
                                        echo "<tr class='value'>";
                                        echo "<td>".$count."</td>";
                                        echo "<td>".$row['Activity']."</td>";
                                        echo "<td>".$row['Pa']."</td>";
                                        echo "<td>".$row['Pi']."</td>";
                                        echo "<tr>";
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </ol>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
    function loadData(type , name){
        $.ajax({
            url : "plant-data.php",
            type: "POST",
            data : {type : type , name1 : name},
            success : function(data){
                if(type == "compoundData"){
                    $("#p_class").html(data);
                }else if(type == "geneData"){
                    $("#p_SupperClass").html(data);
                }else{
                    $("#p_name").append(data);
                }
            }
        });
    }
    loadData();

    $("#p_name").on("change",function(){
        var plantName = $('#p_name').val();
        loadData("compoundData",plantName);
    })

    $("#p_class").on("change",function(){
        var compounName = $('#p_class').val();
        console.log(compounName,"ds");
        loadData("geneData",compounName);
    })
     
});
</script>
<script src="./js/menubar.js"></script>
</body>
</html>

