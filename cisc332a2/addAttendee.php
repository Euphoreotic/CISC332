<?php
    include("template.php");
?>

<script>
    function showCompanies(hide) {
        if (hide){
            document.getElementById("companyList").setAttribute("hidden", true);
        } 
        else {
            document.getElementById("companyList").removeAttribute("hidden");
        }
    }
</script>

<div class="contentContainer">
    <h2> Add a New Attendee: </h2> 
    <form method="post">
        First Name:
        <input type="text" name="firstName">

        Last Name: 
        <input type="text" name="lastName">

        Email:
        <input type="text" name="email">
        <br>
        <br>

        You are a: 
        <br>
        <input type="radio" name="attendeeType" value="Student" onclick="showCompanies(true)"> Student <br>
        <input type="radio" name="attendeeType" value="Professional" onclick="showCompanies(true)"> Professional <br>
        <input type="radio" name="attendeeType" value="Sponsor" onclick="showCompanies(false)"> Sponsor <br>
        <br> 

        <div id="companyList" hidden>
            Company Name:
            <select name="companyName">
                
                <option value="" selected></option>
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
        </div>

        <br> <br> 
        <input type="submit" name="Submit" value="Submit"> 
    </form>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            # input variables
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $attendeeType = isset($_POST['attendeeType']) ? $_POST['attendeeType'] : '';
            $companyName = isset($_POST['companyName']) ? $_POST['companyName'] : '';
            $rate = '';

            # check attendee type and assign associated rate 
            if ($attendeeType == "Student") { 
                $rate = 50;  
            } elseif ($attendeeType == "Professional") { 
                $rate = 100;
            } elseif ($attendeeType == "Sponsor") { 
                $rate = 0;
                if ($companyName == "") { 
                    echo "<p>Error: Company Name has not been inputted for Sponsor attendee.</p>";
                    exit(); // stop execution; prevents attendee creation
                } 
            } else {
                echo "<p> Error: Attendee type has not been selected. </p>";
            }
                
            #connect to the database
            $pdo = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");

            # add row to ATTENDEE table  
            $sql = "insert into attendee values (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);   
            $stmt->execute(array($firstName, $lastName, $email, $rate)); 
            
            if ($stmt->rowCount() == 0) {
                echo "<p>The attendee you are trying to add already exists in the database.</p>";
            } else {
                    
                echo "<h1> Adding new attendee to database: </h1>";
                
                if ($attendeeType == "Student") { 
                    
                    # find available rooms
                    $sql2 = "select roomNumber from room where ((beds = '1') and (occupancy <= 2)) or ((beds = '2') and (occupancy <= 4))";
                    $stmt = $pdo->prepare($sql2);
                    $stmt->execute();
                    $result = ($stmt->fetch());
                    $availableRoom = $result[0]; # take first available room returned
                    
                    # if no rooms available, student is assigned to NULL 
                    if ($availableRoom == null) { 
                        echo "<p> All rooms are full. Student was not assigned a room. </p>";
                        echo "<p> Please contact facilities management for more details. </p>";
                    } 

                    # add row to STUDENT table
                    $sql3 = "insert into student values (?, ?)"; 
                    $stmt = $pdo->prepare($sql3);
                    $stmt->execute(array($email, $availableRoom));

                    # update room occupancy 
                    $sql4 = "update room set occupancy = case occupancy when '2' then '3'
                                                                        when '3' then '4'
                                                        end 
                            where roomNumber = ?";
                    $stmt = $pdo->prepare($sql4);
                    $stmt->execute([$availableRoom]);
                    
                    # query for new student data
                    $sql5 = "select firstname, lastname, email, rate, roomNumber from attendee natural join student where attendee.email = ?";
                    $stmt = $pdo->prepare($sql5);
                    $stmt->execute([$email]);
                    
                    # display new student 
                    echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Rate</th><th>Room Number</th></tr>";
                    while ($row = $stmt->fetch()) {
                        echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td><td>".$row["rate"]."</td><td>".$row["roomNumber"]."</td></tr>";
                    }   // end while
                    
                } elseif ($attendeeType == "Professional") {
                    
                    # add row to PROFESSIONAL table
                    $sql6 = "insert into professional values (?)"; 
                    $stmt = $pdo->prepare($sql6);
                    $stmt->execute([$email]);
                    
                    # query for new professional data
                    $sql7 = "select firstname, lastname, attendee.email, rate from attendee natural join professional where attendee.email = ?";
                    $stmt = $pdo->prepare($sql7);
                    $stmt->execute([$email]);
                    
                    # display new professional
                    echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Rate</th></tr>";
                    while ($row = $stmt->fetch()) {
                        echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td><td>".$row["rate"]."</td></tr>";
                    }   //end while

                } else {    // $attendeeType == "Sponsor" is last option, error checked above
                    
                    # add row to SPONSOR table 
                    $sql8 = "insert into sponsor values (?,?)"; 
                    $stmt = $pdo->prepare($sql8);
                    $stmt->execute(array($email, $companyName));
                    
                    # query for new sponsor data
                    $sql9 = "select firstname, lastname, attendee.email, companyName, rate from attendee natural join sponsor where attendee.email = ?";
                    $stmt = $pdo->prepare($sql9);
                    $stmt->execute([$email]);
                    
                    # display new sponsor
                    echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Company Name</th><th>Rate</th></tr>";
                    while ($row = $stmt->fetch()) {
                        echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td><td>".$row["companyName"]."</td><td>".$row["rate"]."</td></tr>";
                    }   // end while
                }   // end else
            }   //end else
        }   // end if
    ?>
</div>