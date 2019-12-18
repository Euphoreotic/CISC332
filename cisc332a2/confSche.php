<?php
    include("template.php");
?>

<div class="contentContainer">
    <h2> Display Conference Schedule: </h2>
    <p>Enter a date:</p>
    
    <form method="post"> 
        Date:
        <input type="text" name="date" value="YYYY-MM-DD"> 
        <br>
        <br>
        <input type="submit" value="Submit">
    </form>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $date = $_POST['date'];  
                
            #connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
            
            # create and run query 
            $sql = "select eventName, startTime, endTime from session where date = ? order by startTime";
            $stmt = $pdo->prepare($sql);   
            $stmt->execute([$date]);  

            if ($stmt->rowCount() == 0) { 
                echo "<br>";
                echo "<h> There are no sessions to show. </h>";
            } 
            else {     
                # format table for results
                echo "<p>Schedule for <strong>$date</strong>: </p>";
                echo "<table><tr><th>Event</th><th>Start Time</th><th>End Time</th></tr>";

                # display query result
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>".$row["eventName"]."</td><td>".$row["startTime"]."</td><td>".$row["endTime"]."</td></tr>";
                }
            }
        }
    ?>

</div>