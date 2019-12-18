<?php
    include("template.php");
?>

<div class="contentContainer">
    <p> Welcome to the conference database web interface! </p>
    <p> The table below contains the functions available through this web application. Refer to the table for information if you need any help. </p>

    <table>
        <tr><th>Function</th><th>Description</th></tr>
        <tr><td>Sub-Committee Members</td><td> This function displays all members of a particular organizing sub-committee. <br> The user is expected to select the sub-committee of interest from the dropdown menu</td></tr>
        <tr><td>Total Intake</td><td>This function computes the total intake (money) from the conference. It will be categorized into total registration amounts and total sponsorship amounts. <br> The user will not need to provide any input. </td></tr>
        <tr><td>Room Occupancy</td><td>This function displays the names of students assigned to a certain room number. <br> The user is expected to input a valid room number. </td></tr>
        <tr><td>Add Attendees</td><td>This function allows the user to add a new attendee into the database. <br> The user is expected to provide the first name, last name, email address, and attendee type. <br> If the attendee to be added is a student, they will automatically be assigned to a room if available. If no rooms are available, they will be added to the database with no room number along with an error message. <br> If the attendee to be added is a sponsor, the user must select which company they are from. The company must exist in the database before a sponsor attendee can be added. </td></tr>
        <tr><td>Conference Attendees</td><td> This function displays the list of conference attendees separated into students, professionals, and sponsors. <br> The user does not need to provide any input. </td></tr>
        <tr><td>Sponsor Comapnies</td><td> This function displays all sponsor companies and their sponsorship level. <br> The user does not need to input any data.</td></tr>
        <tr><td>Add Sponsor Company</td><td>This function allows the user to add a new sponsoring company into the database. <br> The user is expected to provide the company name and sponsorship level.</td></tr>
        <tr><td>Delete Sponsor Company</td><td>This function allows the user to delete a sponsoring company and it's associated attendees. <br> The user will be expected to select the company to delete.</td></tr>
        <tr><td>Job Postings</td><td> This function displays jobs available from each and/or every company. <br> The user is expected to select their company of interest, or the "All Companies" option.</td></tr>
        <tr><td>Conference Schedule</td><td> This function displays all events occuring on a given date. <br> The user is expected to select the date of interest.</td></tr>
        <tr><td>Switch Sessions</td><td>This function allows the user to swap two sessions' dates, times and/or location. <br> The user will be expected to provide the session ID of the two sessions to be swapped. </td></tr>
    </table>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>