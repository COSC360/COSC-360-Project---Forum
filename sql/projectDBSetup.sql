DROP TABLE IF EXISTS LikedBy;
DROP TABLE IF EXISTS CommentsLikedBy;
DROP TABLE IF EXISTS CommentsLikedBy;
DROP TABLE IF EXISTS Commments;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Boards;
DROP TABLE IF EXISTS Users;



CREATE TABLE Users (
	userID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL,
	firstName VARCHAR(255) NOT NULL,
	lastName VARCHAR (255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password CHAR(32) NOT NULL,
	birthdate DATE,
	role VARCHAR(5) NOT NULL,
	dateJoined TIMESTAMP,
	profilePic VARCHAR(255) DEFAULT "profile_pic.png",
	PRIMARY KEY(userID),
	UNIQUE(username)
);

CREATE TABLE Boards (
	name VARCHAR(10) NOT NULL,
	PRIMARY KEY(name)
);

CREATE TABLE Posts (
	likes INT NOT NULL DEFAULT 0,
	usernameFK VARCHAR(20) NOT NULL,
	title VARCHAR(20) NOT NULL,
	postText TEXT NOT NULL,
	image TEXT DEFAULT NULL,
	postDate DATETIME NOT NULL,
	id INT NOT NULL AUTO_INCREMENT,
	boardFK VARCHAR(10) NOT NULL,
	PRIMARY KEY(id),
	KEY boardFK (boardFK),
	KEY usernameFK (usernameFK),
	FOREIGN KEY(boardFK) REFERENCES Boards(name) 
								ON DELETE CASCADE
								ON UPDATE CASCADE,
	FOREIGN KEY(usernameFK) REFERENCES Users(username)
								ON DELETE CASCADE
								ON UPDATE CASCADE
);

CREATE TABLE Comments (
	commentText TEXT NOT NULL,
	usernameFK VARCHAR(20) NOT NULL,
	postDate DATETIME NOT NULL,
	likes INT NOT NULL,
	postIDFK INT NOT NULL,
	commentID INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(commentID),
	KEY usernameFK (usernameFK),
	KEY postIDFK (postIDFK),
	FOREIGN KEY(postIDFK) REFERENCES Posts(id)
								ON DELETE CASCADE
								ON UPDATE CASCADE,
	FOREIGN KEY(usernameFK) REFERENCES Users(username)
								ON DELETE CASCADE
								ON UPDATE CASCADE
);
	
CREATE TABLE CommentsLikedBy (
	usernameFK VARCHAR(20) NOT NULL,
	commentIDFK INT NOT NULL,
	KEY usernameFK (usernameFK),
	KEY commentIDFK (commentIDFK),
	FOREIGN KEY(commentIDFK) REFERENCES Comments(commentID)
								ON DELETE CASCADE
								ON UPDATE CASCADE,
	FOREIGN KEY(usernameFK) REFERENCES Users(username)
								ON DELETE CASCADE
								ON UPDATE CASCADE
);	

CREATE TABLE LikedBy (
	postIDFK INT NOT NULL,
	usernameFK VARCHAR(20) NOT NULL,
	KEY postIDFK (postIDFK),
	KEY usernameFK (usernameFK),
	FOREIGN KEY(usernameFK) REFERENCES Users(username)
								ON DELETE CASCADE
								ON UPDATE CASCADE,
	FOREIGN KEY(postIDFK) REFERENCES Posts(id)
								ON DELETE CASCADE
								ON UPDATE CASCADE
);

INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('johndoe', 'John', 'Doe', 'john.doe@gmail.com', MD5('pa$$w0rd1'), '2005-07-12', 'user', '2022-08-01 13:25:40');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('janebirch', 'Jane', 'Birch', 'jane.birch@yahoo.com', MD5('pass123'), '1999-02-28', 'user', '2022-11-15 06:45:10');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('topAdmin2023', 'Bob', 'Smith', 'bob.smith@hotmail.com', MD5('adminpass'), '2000-04-01', 'admin', '2018-10-31 19:35:25');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('alicejohnson34', 'Alice', 'Johnson', 'alice.johnson@icloud.com', MD5('cosc360passwrd'), '2007-01-17', 'user', '2021-04-10 22:30:15');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('tombarishe', 'Tom', 'Barishe', 'tom.barishe@gmail.com', MD5('hardp@ssc0de'), '2003-08-30', 'user', '2021-06-27 11:50:05');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('sarahwilson', 'Sarah', 'Wilson', 'sarah.wilson@yahoo.com', MD5('tennisFan22'), '2002-11-22', 'user', '2023-01-17 09:15:28');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('PDub2000', 'Peter', 'Watterson', 'peter.watterson@hotmail.com', MD5('gumballWrld'), '1998-12-08', 'user', '2019-11-05 14:23:44');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('jessBrown!!', 'Jessica', 'Brown', 'jessica.brown@icloud.com', MD5('dcmarvel214'), '2006-06-10', 'user', '2020-01-02 09:15:20');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('liltommyNguyen', 'Tommy', 'Nguyen', 'tommy.nguyen@outlook.com', MD5('rugrat99'), '2004-03-19', 'user', '2019-03-20 16:40:45');
INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES ('lisajackson', 'Lisa', 'Jackson', 'lisa.jackson@outlook.com', MD5('outkast2000'), '2001-09-05', 'user', '2023-02-24 18:20:30');

