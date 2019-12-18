<?php
    include("template.php");
?>

<div class="contentContainer">
        
        <h2> Display Members of a Sub-Committee: <br> </h2>

        <form method="post">
            <select name = "subcommittee">
                <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
                    $sql = "select subcommittee from organizingcommittee";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch()) {
                        echo '<option value ="'.$row["subcommittee"].'">'.$row["subcommittee"].'</option>';
                    }
                ?>
            </select>
            <input type="submit" name="submit" value="Submit"/>
        </form>

        <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
       
            $subcomm = $_POST['subcommittee']; 

            #  connect to database
            $pdo1 = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

            # create and run query 
            $sql = "select firstname, lastname from committeemembers where subcommittee = ?";
            $stmt = $pdo1->prepare($sql); 
            $stmt->execute([$subcomm]);  
            
            if ($stmt->rowCount() == 0) { 
                echo "<br>";
                echo "<h> No sub-committee members to show. </h>";
            } 
            else { 
                echo "<p>Members of the <strong>$subcomm</strong>: </p>";
                echo "<table><tr><th>First Name</th><th>Last Name</th></tr>";

                # display query result 
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td></tr>";
                }
            }
        }

        ?>
</div>