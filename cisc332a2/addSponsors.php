<?php
    include("template.php");
?>

<div class="contentContainer">
        <h1> Add a New Sponsor Company: <br> </h1>


        <form method="post">
            Company Name:
            <input type="text" name="companyName"><br><br>
            
            Sponsorship Level:
            <select name = "tier">
                <option value="Platinum">Platinum</option>
	            <option value="Gold">Gold</option>
	            <option value="Silver">Silver</option>
	            <option value="Bronze">Bronze</option>
            </select> <br><br>
            <input type="submit" name="submit" value="Submit"/>
        </form>

        <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $company = $_POST['companyName'];  // Storing Selected Value In Variable
            $tier = $_POST['tier'];  // Storing Selected Value In Variable
            // $amount = "";
            // $numEmails = "";

            switch ($tier) {
                case "Platinum":
                    $amount = '10000';
                    $numEmails = '5';
                    break;

                case "Gold":
                    $amount = '5000';
                    $numEmails = '4';
                    break;

                case "Silver":
                    $amount = '3000';
                    $numEmails = '3';
                    break;

                case "Bronze":
                    $amount = '1000';
                    $numEmails = '0';
                    break;
            }
                
            #connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

            $sql = "insert ignore into Company values (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);   #create the query
            $stmt->execute(array($company, $tier, $amount, $numEmails));   #bind the parameters
            
            if ($stmt->rowCount() == 0) {
                echo "<p>The sponsor you are trying to add already exists in the database.</p>";
            } else {
                echo "<p>The sponsor, <strong>$company</strong>, has been added to the database.</p>";

                $sql2 = "select companyName, tier from company";
                $stmt = $pdo->prepare($sql2);
                $stmt->execute();

                echo "<p>Here is the updated table of companies.</p>";
                echo "<table><tr><th>Company Name</th><th>Tier</th></tr>";

                while ($row = $stmt->fetch()) {
                    echo "<tr><td>".$row["companyName"]."</td><td>".$row["tier"]."</td></tr>";
                }
            }
        }

        ?>
</div>