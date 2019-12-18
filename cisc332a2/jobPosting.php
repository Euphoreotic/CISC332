<?php
    include("template.php");
?>

<div class="contentContainer">
    <h2> Jobs Available: </h2>

    <p> Select a company to display their job postings</p>

    <form method="post">
        <select name="companyName">
            <option name="all companies">All Companies</option>
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
            
            $company = $_POST['companyName'];

            #connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
            
            # create queries
            if ($company == "All Companies") {
                $sql = "select companyName, title, jobID, province, city, payrate from jobad";
            } else {
                $sql = "select title, jobID, province, city, payrate from jobad where companyName = ?";
            }
            # run queries
            $stmt = $pdo->prepare($sql); 
            $stmt->execute([$company]);   
            
            if ($stmt->rowCount() == 0) { 
                echo "<br>";
                echo "<h> There are no job postings available for this company. </h>";
            } 
            else {  
                echo "<p>Available jobs from: <strong>$company</strong> </p>";

                # display jobs for all companies
                if ($company == "All Companies") {
                    echo "<table><tr><th>Company Name</th><th>Job Title</th><th>Job ID</th><th>Province</th><th>City</th><th>Payrate</th></tr>";
                } else {
                    echo "<table><tr><th>Job Title</th><th>Job ID</th><th>Province</th><th>City</th><th>Payrate</th></tr>";
                }

                # display results in table
                while ($row = $stmt->fetch()) {
                    if ($company == "All Companies") {
                        echo "<tr><td>".$row["companyName"]."</td><td>".$row["title"]."</td><td>".$row["jobID"]."</td><td>".$row["province"]."</td><td>".$row["city"]."</td><td>".$row["payrate"]."</td></tr>";
                    } else {
                        echo "<tr><td>".$row["title"]."</td><td>".$row["jobID"]."</td><td>".$row["province"]."</td><td>".$row["city"]."</td><td>".$row["payrate"]."</td></tr>";
                    }
                }
            }
        }
    ?>

</div>