<?php
    include("template.php");
?>

<div class="contentContainer">

    <h2>Total Intake by Registration and Sponsorships: </h2>

    <?php
	    $totalRate = 0; // Return value
        $totalSponsorship = 0; // Return value
        $total = 0; // Return value

        echo "<table><tr><th>Registration</th><th>Sponsorship</th><th>Total</th></tr>";

        $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

        $sql1 = "select rate from attendee";
        $sql2 = "select sponsorAmount from company";

        # table of totals
        $sql1 = "select rate from attendee";
        $sql2 = "select sponsorAmount from company"; 
        $stmt1 = $pdo->prepare($sql1);
        $stmt2 = $pdo->prepare($sql2);     
        $stmt1->execute();
        $stmt2->execute();

        while ($row = $stmt1->fetch()) {
            $totalRate = $totalRate + (int)$row["rate"];
        	$total = $total + (int)$row["rate"];
        }
        
        while ($row = $stmt2->fetch()) {
            $totalSponsorship = $totalSponsorship + (int)$row["sponsorAmount"];
        	$total = $total + (int)$row["sponsorAmount"];
        }
        
        echo "<tr><td>".$totalRate."</td><td>".$totalSponsorship."</td><td>".$total."</td></tr>";
    ?>
</div>