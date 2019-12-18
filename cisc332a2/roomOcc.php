<?php
    include("template.php");
?>

<div class="contentContainer">
    <h2> Display Room Occupants: </h2>

    <form method="post">
        Room number:
        <input type="text" name="roomNumber">
        <br> 
        <br> 
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $roomNo = $_POST['roomNumber'];
        
            #connect to the database
            $pdo2 = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
            
            # create and run query 
            $sql = "select roomNumber, student.email, firstname, lastname from room natural join student, attendee where roomnumber = ? and student.email = attendee.email";
            $stmt = $pdo2->prepare($sql);  
            $stmt->execute([$roomNo]);   
            
            # no students in room 
            if ($stmt->rowCount() == 0) { 
                echo "<br>";
                echo "<h> No students assigned to room number <strong>$roomNo<strong>. </h>";
            } 
            # room comtains occupants 
            else {
                # display results in table
                echo "<p>Students housing in room number <strong>$roomNo</strong>: </p>";
                echo "<table><tr><th>First Name</th><th>Last Name</th></tr>";
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td></tr>";
                }
            }
            
    
        
            
        } 

    ?>

</div>