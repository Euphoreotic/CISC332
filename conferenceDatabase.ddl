/* 
CISC 332: Project Deliverable 1 
Submitted: Feb 8 2019 
Group 75 
Brandon Tang (10193811)
Tong Chen (10189689)
Will Xie (10189120)
*/ 

create table OrganizingCommittee 
	(subCommittee		varchar(30) not null,
	 chair			    varchar(40) not null,
	 primary key (subCommittee)
	 );

create table CommitteeMembers
	(subCommittee		varchar(30) not null,
	 firstName		    varchar(20) not null,
	 lastName		    varchar(20) not null,
	 email		        varchar(40) not null,
	 primary key (subCommittee, email),
 	 foreign key (subCommittee) references OrganizingCommittee (subCommittee)
	   on delete cascade
	 );

create table Attendee 
	(firstName		varchar(20) not null,
	 lastName		varchar(20) not null,
	 email		    varchar(40) not null, 
	 rate           enum('0', '50', '100'),
	 primary key (email)
	 ); 

create table Professional
	(email      varchar(40) not null,
 	 primary key (email),
	 foreign key (email) references Attendee (email) 
        on delete cascade
     ); 

create table Room
	(roomNumber  	int not null, 
	 beds  			enum('1', '2') not null, 
	 occupancy		enum('2', '3', '4') not null,
	 primary key (roomNumber)
	 ); 

create table Student 
	(email		   varchar(40) not null, 
	 roomNumber	   int, 
	 primary key (email),
	 foreign key (roomNumber) references Room (roomNumber) 
        on delete set null,
	 foreign key (email) references Attendee (email) 
        on delete cascade
     ); 

create table Company 
	(companyName       varchar(40) not null, 
	 tier  		       enum('Platinum', 'Gold', 'Silver', 'Bronze') not null,	
 	 sponsorAmount     enum('10000', '5000', '3000', '1000') not null, 	
     emailSent         int, 
     primary key (companyName)
	 ); 

create table Sponsor 
	(email		    varchar(40) not null,
	 companyName  	varchar(30) not null, 
	 primary key (email),
	 foreign key (companyName) references Company (companyName)   
        on delete cascade,
	 foreign key (email) references Attendee (email) 
        on delete cascade
	 ); 

create table Session
	(sessionID      int not null,
     roomName		varchar(30) not null, 
	 eventName		varchar(30),
	 date  			date not null,
	 startTime		time not null,
 	 endTime		time,
 	 primary key (sessionID)
	);

create table Speakers
	(sessionID      int not null, 
	 email			varchar(40) not null,
	 primary key (sessionID, email),
	 foreign key (email) references Attendee (email)
		on delete cascade,
	 foreign key (sessionID) references Session (sessionID)      on delete cascade
	 );

create table JobAd
	(jobID			char(8) not null,
	 companyName	varchar(40) not null,
	 title  		varchar(30) not null,
	 city			varchar(20) not null,
     province		varchar(20) not null,
     payRate		int,
     primary key (jobID),
     foreign key (companyName) references Company (companyName)
        on delete cascade
     ); 		
