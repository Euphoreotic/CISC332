<?php
    include("template.php");
?>

<div class="contentContainer">

    <h2>Switch Two Sessions:</h2>   
    <p> Enter the sessions numbers of the sessions you want to switch:</p>

    <form method="post">
        Insert first session number:
        <input type="text" name="sessionNum1"><br><br>
        
        Insert second session number:
        <input type="text" name="sessionNum2"><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
    
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $event1 = $_POST['sessionNum1']; // Storing Selected Value In Variable
            $event2 = $_POST['sessionNum2']; // Storing Selected Value In Variable

            echo "<p>Switch event $event1 with $event2: </p>";
                
            #connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
            
            $sqla = "CREATE TEMPORARY TABLE temp1
                    SELECT sessionID, eventName
                    FROM Session
                    WHERE sessionID = ? OR sessionID = ?";
            $sqlb = "CREATE TEMPORARY TABLE temp2
                    SELECT sessionID, eventName
                    FROM Session
                    WHERE sessionID = ? OR sessionID = ?";
            $sqlc = "UPDATE Session 
                    SET eventName = CASE sessionID
                WHEN ? then (SELECT eventName FROM temp1 WHERE sessionID = ?)
                        WHEN ? then (SELECT eventName FROM temp2 WHERE sessionID = ?)
                    END
            WHERE sessionID = ? OR sessionID = ?";
            $sqld = "UPDATE Speakers 
                    SET sessionID = CASE sessionID
                        WHEN ? then ?
                        WHEN ? then ?
                    END
            WHERE sessionID = ? OR sessionID = ?";
            $sqle = "DROP TEMPORARY TABLE temp1";
            $sqlf = "DROP TEMPORARY TABLE temp2";
                    
            $stmta = $pdo->prepare($sqla);   #create the query
            $stmtb = $pdo->prepare($sqlb);   #create the query
            $stmtc = $pdo->prepare($sqlc);   #create the query
            $stmtd = $pdo->prepare($sqld);   #create the query
            $stmte = $pdo->prepare($sqle);   #create the query
            $stmtf = $pdo->prepare($sqlf);   #create the query
            $stmta->execute(array($event1, $event2));   #bind the parameters
            $stmtb->execute(array($event1, $event2));   #bind the parameters
            $stmtc->execute(array($event1, $event2, $event2, $event1, $event1, $event2));   #bind the parameters
            $stmtd->execute(array($event1, $event2, $event2, $event1, $event1, $event2));   #bind the parameters
            $stmte->execute();   #bind the parameters
            $stmtf->execute();   #bind the parameters        

            echo "<p>Here are the updated sessions</p>";

            # table for SESSION
            echo "<table><tr><th>Session ID</th><th>Room</th><th>Event</th><th>Date</th><th>Start</th><th>End</th></tr>";
            $sql1 = "select * from Session where sessionID = ? OR sessionID = ?"; 
            $stmt1 = $pdo->prepare($sql1);     
            $stmt1->execute(array($event1, $event2));
            while ($row = $stmt1->fetch()) {
                echo "<tr><td>".$row["sessionID"]."</td><td>".$row["roomName"]."</td><td>".$row["eventName"]."</td><td>".$row["date"]."</td><td>".$row["startTime"]."</td><td>".$row["endTime"]."</td></tr>";
            }
            
            # table for Speakers
            echo "<table><tr><th>Session ID</th><th>Email</th></tr>";
            $sql2 = "select * from speakers where sessionID = ? OR sessionID = ?"; 
            $stmt2 = $pdo->prepare($sql2);     
            $stmt2->execute(array($event1, $event2));
            while ($row = $stmt2->fetch()) {
                echo "<tr><td>".$row["sessionID"]."</td><td>".$row["email"]."</td></tr>";
            }

            echo "<br><p>Here are the speakers associated with each Session</p>";
        }
    ?>

</div>