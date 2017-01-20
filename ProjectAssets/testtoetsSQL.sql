create database testtoets;
use testtoets;

create table Wachtwoord(
id INT,
wachtwoord VARCHAR(255),
PRIMARY KEY(id)
);
create table Klant(
id INT auto_increment,
wachtwoordid INT,
achternaam VARCHAR(45),
email VARCHAR(45),
PRIMARY KEY (id),
FOREIGN KEY (wachtwoordid) REFERENCES Wachtwoord(id)
);

INSERT INTO Wachtwoord (id, wachtwoord) VALUES (1, '$2y$10$PHzgevzDCsVGSeDHq8xRCuQGb8fGyOOK0ZF6QGgDtxv4BhDsjDkpC');
INSERT INTO Klant (wachtwoordid, achternaam, email) VALUES (1, 'Grooten', 'grootenjeroen@hotmail.com');

create table Restaurant(
id INT,
naam varchar(45),
adres VARCHAR(45),
woonplaats VARCHAR(45),
img VARCHAR(45),
PRIMARY KEY (id)
);

INSERT INTO Restaurant (id, naam, adres, woonplaats, img) VALUES (1, 'McDonalds', 'teststraat', 'testhoven', 'mcdonalds.jpg');
INSERT INTO Restaurant (id, naam, adres, woonplaats, img) VALUES (2, 'Taco Bell', 'Columbuslaan 540', 'Utrecht', 'tacobell.jpg');

create table Kwaliteit_Eten(
id INT, 
beoordeling INT,
PRIMARY KEY (id)
);
create table Ontvangst_en_service(
id INT, 
beoordeling INT,
PRIMARY KEY (id)
);
create table Inrichting_en_Sfeer(
id INT, 
beoordeling INT,
PRIMARY KEY (id)
);
create table Kwaliteit(
id INT, 
beoordeling INT,
PRIMARY KEY (id)
);
create table Zou_Je_Terug_Komen(
id INT, 
beoordeling INT,
PRIMARY KEY (id)
);
SELECT * FROM Kwaliteit_Eten;
create table Beoordeling(
id INT,
restaurant INT,
klant INT,
kwaliteit_eten INT,
ontvangst_en_service INT,
inrichting_en_sfeer INT,
kwaliteit INT,
zou_je_terug_komen INT,
commentaar VARCHAR(255),
cijfer INT,
aantalBeoordeling INT,
totaalCijfer FLOAT,
PRIMARY KEY (id),
FOREIGN KEY (restaurant) REFERENCES Restaurant(id),
-- FOREIGN KEY (klant) REFERENCES Klant(id),
FOREIGN KEY (kwaliteit_eten) REFERENCES Kwaliteit_Eten(id),
FOREIGN KEY (ontvangst_en_service) REFERENCES Ontvangst_en_service(id),
FOREIGN KEY (inrichting_en_sfeer) REFERENCES Inrichting_en_Sfeer(id),
FOREIGN KEY (kwaliteit) REFERENCES Kwaliteit(id),
FOREIGN KEY (zou_je_terug_komen) REFERENCES Zou_Je_Terug_Komen(id)
);

-- INSERT INTO Restaurant (id, naam, adres, woonplaats, img) VALUES (1, 'McDonalds', 'teststraat', 'testhoven', 'mcdonalds.jpg');
-- INSERT INTO Restaurant (id, naam, adres, woonplaats, img) VALUES (2, 'Taco Bell', 'Columbuslaan 540', 'Utrecht', 'tacobell.jpg');
-- SELECT * FROM Beoordeling;
-- SELECT * FROM Klant;
-- INSERT INTO Beoordeling (id, restaurant, klant, kwaliteit_eten, ontvangst_en_service, inrichting_en_sfeer, kwaliteit, zou_je_terug_komen) VALUES (353, 1, 1, 128, 452, 21, 438, 15);
-- SELECT * FROM Kwaliteit_Eten;
-- SELECT * FROM Ontvangst_en_service;
-- SELECT * FROM Inrichting_en_Sfeer;
-- SELECT * FROM Kwaliteit;
-- SELECT * FROM Zou_Je_Terug_Komen;
-- SELECT * FROM Beoordeling;
-- SELECT * FROM Wachtwoord;
-- SELECT * FROM Klant;