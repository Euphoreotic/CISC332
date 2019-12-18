<?php
    include("template.php");
?>

<div class="contentContainer">

    <h2>Sponsor Companies and Sponsorship Levels: </h2>

    <?php 
        $company = 'companyName';  

        #connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

        # create and run query 
        $sql = "select companyName, tier from company";
        $stmt = $pdo->prepare($sql);   
        $stmt->execute([$company]);   

        # if no sponsoring companies exist 
        if ($stmt->rowCount() == 0) { 
            echo "<br>";
            echo "<h> No sponsor companies currently exist. </h>";
        } 
        else { 
            # display results in table 
            echo "<table><tr><th>Company Name</th><th>Tier</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row["companyName"]."</td><td>".$row["tier"]."</td></tr>";
            }
        }
    ?>

</div>