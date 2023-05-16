<?php
    session_start();
    include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/ShowDataTable2.css">
</head>
<body>  
<div class="title">
        <h1>AYUSearch</h1>
    </div>
    <?php
        if(!isset($_SESSION['user']))
        {
          header('location:index.php');
        }
        $value = explode("%",$_SESSION['selected_value'])[0];
        $sort_by = explode("%",$_SESSION['selected_value'])[1];
        $_SESSION['sort_by']=$sort_by;
        if($sort_by == 'Plant' or $sort_by == 'Animal'){
            $sql_fetch="SELECT * FROM plantanimaldata where Scientific_Name = '$value' and category = '$sort_by'";
        }else{
            $sql_fetch="SELECT * FROM plantanimaldata where Phytochemical_Name = '$value'";
        }
        $result_f=mysqli_query($conn,$sql_fetch);
        $plant_common_name = '';
        $plant_scientific_name = '';
        $ayurvedic_name = '';        
        $phytochemical_class = '';
        $phytochemical_superclass = '';
        $phytochemical_name = '';
        $phytochemical_identifier = '';
        if($sort_by == 'Plant' or $sort_by == 'Animal'){
            $sql_fetch1="SELECT * FROM plantanimaldata where Scientific_Name = '$value' and category = '$sort_by'";
        }else{
            $sql_fetch1="SELECT * FROM plantanimaldata where Phytochemical_Name = '$value'";
        }
        $count = 0;
        $result_f1=mysqli_query($conn,$sql_fetch1);
        if(mysqli_num_rows($result_f1) > 0)
        {
            
            while ($row = mysqli_fetch_assoc($result_f1) and $count == 0)
            {
                if($count){
                    break;
                }
                if($sort_by == 'compound'){
                    $phytochemical_class = $row['Phytochemical_Class'];
                    $phytochemical_superclass = $row['Phytochemical_Superclass'];
                    $phytochemical_name = $row['Phytochemical_Name'];
                    $phytochemical_identifier =$row['Phytochemical_Identifier'];
                }else{

                    $plant_common_name = $row['Common_Name'];
                    $plant_scientific_name = $row['Scientific_Name'];
                    $ayurvedic_name = $row['Ayurveda_recognition'];
                    $therapeutics_use = $row['Therapeutics_use'];
                }

                $count += 1;
            }
            $count = 0;
        }
    ?>
    <div class="sub-header">
        <div class="selected-name">
            <?php
                if($sort_by != 'compound'){
                    echo "<p>".$sort_by." Common Name: <span class='color-select'>".strtoupper($plant_common_name)."</span></p>";
                    echo "<p>".$sort_by." Scientific Name: <i><span class='color-select'>".strtoupper($plant_scientific_name)."</span></i></p>";
                    echo "<p>Ayurveda Recognition of ".$sort_by.": <span class='color-select'>".strtoupper($ayurvedic_name)."</span></p>";
                    echo "<p>Therapeutics use of ".$sort_by." Part: <span class='color-select'>".strtoupper($therapeutics_use)."</span></p>";
                }else{
                    echo "<p>Phytochemical Class: <span class='color-select'>".strtoupper($phytochemical_class)."</span></p>";
                    echo "<p>Phytochemical Superclass:<span class='color-select'>".strtoupper($phytochemical_superclass)."</span></p>";
                    echo "<p>Phytochemical Name: <span class='color-select'>".strtoupper($phytochemical_name)."</span></p>";
                    echo "<p><i>".$phytochemical_identifier."</i></p>";
                }
            ?>  
        </div>
        <div class="table-info">
            Target Gene and PDB ID displayed through <span class='green-color'>PINK</span> are 
            experimentally validated,  while the <span class='blue-color'>BLUE</span> indicates computationally predicted PDB IDs
        </div>
    </div>
    <div class="annot">
        <table class="content">
            <?php
                if($sort_by == 'compound'){
                    echo "<tr class='col col1'>";
                    echo "<td>NO</td>";
                    echo "<td>Plant/Animal Scientific Name</td>";
                    echo "<td>Plant/Animal Common Name</td>";
                }else{
                    echo "<tr class='col'>";
                    echo "<td>NO</td>";
                    echo "<td>Phytochemical Superclass</td>";
                    echo "<td>Phytochemical Class</td>";
                    echo "<td>Phytochemical Name</td>";
                    echo "<td>Phytochemical Identifier</td>";
                }
                echo "<td>Target Gene</td>";           
                echo "<td>PDB ID</td>";
                echo "<td>Advance search</td>";           
                echo "<td>Functional analysis</td>";
                echo "<td>Ayurvedic properties</td>";
                echo "</tr>";
            ?>
            <?php
                    $checkDuplicate = '';
                    $count = 1;
                    
                    if(mysqli_num_rows($result_f) > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result_f))
                        {
                            if($sort_by == 'compound'){
                                if($checkDuplicate != $row['Common_Name'] || $row['id'] == 0){
                                    echo "<tr class='value value1'>";
                                    echo "<td class='top-border'>".$count."</td>";
                                    echo "<td class='top-border'>".strtoupper($row['Scientific_Name'])."</td>";
                                    echo "<td class='top-border'>".strtoupper($row['Common_Name'])."</td>";
                                    $checkDuplicate = $row['Common_Name'];
                                    $count += 1;
                                }else{
                                    echo "<tr class='value value1'>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    $checkDuplicate = $row['Common_Name'];
                                }
                            }else{
                                if($checkDuplicate != $row['Phytochemical_Name'] || $row['id'] == 0){
                                    echo "<tr class='value'>";
                                    echo "<td class='top-border'>".$count."</td>";
                                    echo "<td class='top-border'>".strtoupper($row['Phytochemical_Superclass'])."</td>";
                                    echo "<td class='top-border'>".strtoupper($row['Phytochemical_Class'])."</td>";
                                    echo "<td class='top-border'>".strtoupper($row['Phytochemical_Name'])."</td>";
                                    $Phytochemical_string = $row['Phytochemical_Identifier'];
                                    $Phytochemical_before = explode(":", $Phytochemical_string)[0];
                                    $Phytochemical_after = explode(":", $Phytochemical_string)[1];
                                    $Phytochemical_substring = "PubChem Identifier";
                                    if (strpos($Phytochemical_string, $Phytochemical_substring) !== false) {
                                        echo "<td class='top-border'><a href=https://pubchem.ncbi.nlm.nih.gov/#query=".$Phytochemical_after." target='_blank'>".$Phytochemical_after."</a></td>";
                                    } else {
                                        echo "<td class='top-border'><a href=http://www.chemspider.com/Chemical-Structure.".$Phytochemical_after.".html target='_blank'>".$Phytochemical_after."</a></td>";
                                    }
                                    
                                    $checkDuplicate = $row['Phytochemical_Name'];
                                    $count += 1;
                                }else{
                                    echo "<tr class='value'>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    echo "<td class='hide-bottom-border'></td>";
                                    $checkDuplicate = $row['Phytochemical_Name'];
                                }
                            }
                            if($row['Colour_code'] == 'Experimentally proved Target gene'){
                                echo "<td class='green-color'>".$row['Target_Gene']."</td>";
                                echo "<td class='green-color'><a class='green-color' href=https://www.rcsb.org/structure/".$row['PDB_ID']." target='_blank'>".$row['PDB_ID']."</a></td>";
                            }else{
                                echo "<td class='blue-color'>".$row['Target_Gene']."</td>";
                                echo "<td class='blue-color'><a class='blue-color' href=https://www.rcsb.org/structure/".$row['PDB_ID']." target='_blank'>".$row['PDB_ID']."</a></td>";
                            }
                            $plant_category = $row['Scientific_Name']."_".$sort_by;
                            $link_search = 'AdvancedSearch.php?name='.$plant_category."&compound=".$row['Phytochemical_Name'];
                            $link_ayurved = 'AyurvedicData.php?compound='.$plant_category;
                            $link = 'plantAnnot.php?compound='.$plant_category;
        
                            echo "<td><a href='$link_search' target='_blank'>More</a></td>";
                            echo "<td><a href='$link' target='_blank'>More</a></td>";
                            echo "<td><a href='$link_ayurved' target='_blank'>More</a></td>";
                            echo "</tr>";
                        }
                    }
            ?>
        </table>
        <div class='reference'>
            <p class='reference-title'><u><?php if($sort_by != "compound"){echo "References";} ?></u></p>
            <table>
                <tr class = 'col col2'>
                    <?php
                        if($sort_by != "compound"){
                            echo "<td>NO</td>";
                            echo "<td>References</td>";
                        }
                     ?>
                </tr>
                    <?php
                        $sql_fetch1="SELECT * FROM referencedata where plant_Name = '$value'";
                        $result_f1=mysqli_query($conn,$sql_fetch1);
                        if(mysqli_num_rows($result_f1) > 0)
                        {
                            while ($row = mysqli_fetch_assoc($result_f1))
                            {
                                echo "<tr class='value value2'>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['reference']."</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
            </table>
        </div>
    </div>  
</body>
</html>