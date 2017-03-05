
/* 

SCHEMA:

	Rental(rID, title, price, desc, area, address, link, addDate)

	Contact(rID, name, phone, email)
	FK rID ref Rental(rID)

	Users(id, pword, email, name, admin)

	Report(desc, type, time, rID, id)
	FK rID ref Rental(rID), FK id ref Users(id)

	SavedAds(rID, id)
	FK rID ref Rental(rID), FK id ref Users(id)




*/ 




CREATE TABLE rental (

	rID INTEGER AUTO_INCREMENT, 
	title VARCHAR(50) NOT NULL,
	price DECIMAL(7,2) NOT NULL,
	description VARCHAR(400),
	area VARCHAR(20),
	address VARCHAR(70),
	link VARCHAR(200),
	datedAdded DATETIME DEFAULT CURRENT_TIMESTAMP, 
	PRIMARY KEY (rID)




);

CREATE TABLE contact (
	
	rID INTEGER,
	name VARCHAR(30),
	phone VARCHAR(15),
	email VARCHAR(30),
	PRIMARY KEY (rID, name),
	FOREIGN KEY (rID) REFERENCES rental(rID)
		ON DELETE CASCADE 
		ON UPDATE CASCADE 

);


CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255)   NOT NULL,
  email varchar(255)   NOT NULL,
  password varchar(255) NOT NULL,
  remember_token varchar(100) DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) 

/*
		Below here not used in release 1 but they seemed easy enough to have in here. 
*/


CREATE TABLE savedAds ( 

	id VARCHAR(20),
	rID INTEGER,
	PRIMARY KEY (id,rID),
	FOREIGN KEY (rID) REFERENCES rental(rID)
		ON DELETE CASCADE 
		ON UPDATE CASCADE, 
	FOREIGN KEY (id) REFERENCES users(id)
		ON DELETE CASCADE 
		ON UPDATE CASCADE 


);

CREATE TABLE report ( 
	
	id VARCHAR(20),
	rID INTEGER,
	timeAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	reportType VARCHAR(25),
	description VARCHAR(100),
	PRIMARY KEY (id, timeAdded),
	FOREIGN KEY (rID) REFERENCES rental(rID)
		ON DELETE CASCADE 
		ON UPDATE CASCADE, 
	FOREIGN KEY (id) REFERENCES users(id)
		ON DELETE CASCADE 
		ON UPDATE CASCADE 

);
