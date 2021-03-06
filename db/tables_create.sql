
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
	description TEXT,
	area VARCHAR(20),
	address VARCHAR(70),
	link VARCHAR(200),
	img VARCHAR(300),
	pets BOOLEAN,
	furn BOOLEAN,
	smoke BOOLEAN,
	bed INTEGER,
	bath INTEGER,
    lat DECIMAL(9,6),
    lng DECIMAL(9,6),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (rID)




);

CREATE TABLE contact (

	rID INTEGER,
	name VARCHAR(30),
	phone VARCHAR(15),
	email VARCHAR(30),
	PRIMARY KEY (rID),
	FOREIGN KEY (rID) REFERENCES rental(rID)
		ON DELETE CASCADE
		ON UPDATE CASCADE

);


CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  password varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  isAdmin tinyint(1),
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*
		Below here not used in release 1 but they seemed easy enough to have in here.
*/


CREATE TABLE savedads (

	id int(10) unsigned,
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

	id int(10) unsigned,
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

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE userfilters (
	id int(10) unsigned,
	pets BOOLEAN,
	furn BOOLEAN,
	smoke BOOLEAN,
	nopets BOOLEAN,
	nofurn BOOLEAN,
	nosmoke BOOLEAN,
	bed INTEGER,
	bath INTEGER,
	price DECIMAL(7,2),
	PRIMARY KEY (id),
	FOREIGN KEY (id) REFERENCES users(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

CREATE TABLE history (
	id int(10) unsigned,
	rID INTEGER,
	ts DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id, rID),
	FOREIGN KEY (rID) REFERENCES rental(rID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (id) REFERENCES users(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
