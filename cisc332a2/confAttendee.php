<?php
    include("template.php");
?>

<div class="contentContainer">

    <h2> Display all Attendees by Groups: </h2>

    <?php 
        $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

        # table and code for STUDENTS
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        $sql1 = "select firstname, lastname, email from attendee natural join student"; 
        $stmt1 = $pdo->prepare($sql1);     
        $stmt1->execute();
        while ($row = $stmt1->fetch()) {
            echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td></tr>";
        }

        echo "<p> List of <strong>Student</strong> attendees: </p>";

        # table and code for PROFESSIONALS
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        $sql2 = "select firstname, lastname, email from attendee natural join professional";
        $stmt2 = $pdo->prepare($sql2); 
        $stmt2->execute();
        while ($row = $stmt2->fetch()) {
            echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td></tr>";
        }

        echo "<br><p> List of <strong>Professional</strong> attendees: </p>";

        # table and code for SPONSORS
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        $sql3 = "select firstname, lastname, email from attendee natural join sponsor";
        $stmt3 = $pdo->prepare($sql3);    
        $stmt3->execute(); 
        while ($row = $stmt3->fetch()) {
            echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td></tr>";
        }

        echo "<br><p> List of <strong>Sponsor</strong> attendees: </p>";
    ?>
</div>