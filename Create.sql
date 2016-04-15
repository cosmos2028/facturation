
create TABLE LIGUE
	(numCompte INT(4) NOT NULL ,
    nomlig VARCHAR(25),
    nomtres VARCHAR(25),
    rue VARCHAR(25),
    cp INT(5),
    ville VARCHAR(25),
    CONSTRAINT PK_LIG PRIMARY KEY(numCompte)
    )ENGINE=innodb;


create table PRESTATION
	(codePresta VARCHAR(25) NOT NULL,
	nomPresta VARCHAR(25),
	puPresta DECIMAL(6,3),
	CONSTRAINT PK_PRESTA PRIMARY KEY(codePresta)
	)ENGINE=innodb;


create table FACTURE
	(numFact VARCHAR(25) NOT NULL ,
	dateFact VARCHAR(25) NOT NULL,
	echeance VARCHAR(25) NOT NULL,
	numCompte INT(4) NOT NULL,
	CONSTRAINT PK_FACT PRIMARY KEY(numFact)
	)ENGINE=innodb;
    

create table LIGNE_FACTURE
    (numFact VARCHAR(25) NOT NULL ,
     codePresta VARCHAR(25) NOT NULL,
     qte INT(4),
     CONSTRAINT PK_LIGNE_FACT_FACT_PRESTA PRIMARY KEY (numFact,codePresta)
    )ENGINE=innodb;

    select numFact 
	from LIGUE,FACTURE
	where LIGUE.numCompte=FACTURE.numCompte
	and LIGUE.nomlig = isset($_POST['nomlig'];