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
    <?php
        $plant_common_name = '';
        $plant_scientific_name = '';
        $ayurvedic_name = '';
        $value =  explode("_",$_GET['compound'])[0];
        $sort_by =  explode("_",$_GET['compound'])[1];
        $sql_fetch="SELECT * FROM keggdata where CompoundName = '$value'";
        $result_f=mysqli_query($conn,$sql_fetch);
    ?>
    <div class="title">
        <h1> Functional Analysis </h1>
    </div>
    <div class="sub-header">
        <div class="selected-name">
            <?php
                $sql_fetch1="SELECT category,Therapeutics_use,Common_Name,Scientific_Name,Ayurveda_recognition FROM plantanimaldata where Scientific_Name = '$value'";
                $result_f1=mysqli_query($conn,$sql_fetch1);
                if(mysqli_num_rows($result_f1) > 0)
                {
                    while ($row = mysqli_fetch_assoc($result_f1) and $count == 0)
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
                $sql_fetch="SELECT * FROM keggdata where CompoundName = '$value'";
                $result_f=mysqli_query($conn,$sql_fetch);
            ?>
        </div>
    </div>

    <div class="annot">
        <table class="content">
            <tr class="col">
                <td>NO</td>
                <td>Category</td>
                <td>Genes</td>
                <td>PValue</td>
                <td>Term</td>
            </tr>
            <?php
                   if(mysqli_num_rows($result_f) > 0)
                    {
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($result_f))
                        {
                            $count += 1;
                            echo "<tr class='value'>";
                            echo "<td>".$count."</td>";
                            echo "<td>".$row['Category']."</td>";
                            echo "<td>".$row['Genes']."</td>";
                            echo "<td>".$row['PValue']."</td>";
                            echo "<td>".$row['Term']."</td>";
                            echo "</tr>";
                        }
                    }
            ?>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            function loadData() {
                $.ajax({
                    url: "plant-data.php",
                    type: "POST",
                    success: function (data) {
                        $("#p_name").append(data);
                    }
                });
            }
            loadData();
        });
    </script>
</body>

</html>