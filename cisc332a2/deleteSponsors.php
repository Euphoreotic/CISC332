<?php
    include("template.php");
?>

<div class="contentContainer">

    <h2> Delete a Sponsoring Company </h2>
    <p>Which sponsor company would you like to delete:</p>

    <form method="post">
        <select name="companyName">
            <option value=""></option>
            <?php
                $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
                $sql = "select companyName from company";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo '<option value ="'.$row["companyName"].'">'.$row["companyName"].'</option>';
                }
            ?>
        </select>
        <input type="submit" value="Submit">
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $company = $_POST['companyName'];  // Storing Selected Value In Variable

            if (empty($company)) {
                echo "<p>Nothing was selected.<p>";
            } else {
                #connect to the database
                $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
                $sql = "delete from attendee where attendee.email in (select sponsor.email FROM sponsor, company where sponsor.companyName = ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$company]);

                $sql2 = "delete from company where company.companyName = ?";
                $stmt = $pdo->prepare($sql2);
                $stmt->execute([$company]);

                echo "<p>The sponsoring company <strong>$company</strong> and all associated attendees have been deleted from the database.";
                
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