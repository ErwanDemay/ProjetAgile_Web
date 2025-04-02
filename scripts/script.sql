#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        id         Int  Auto_increment  NOT NULL ,
        mail       Varchar (100) NOT NULL ,
        motDePasse Varchar (255) NOT NULL ,
        role       Varchar (25) NOT NULL
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Session
#------------------------------------------------------------

CREATE TABLE Session(
        id          Int  Auto_increment  NOT NULL ,
        nomSession  Varchar (100) NOT NULL ,
        dateSession Date NOT NULL ,
        heureDebut  Time NOT NULL ,
        heureFin    Time NOT NULL ,
        prix        Float NOT NULL ,
        nbPlaces    Int NOT NULL
	,CONSTRAINT Session_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type
#------------------------------------------------------------

CREATE TABLE Type(
        id          Int  Auto_increment  NOT NULL ,
        libelleType Varchar (50) NOT NULL
	,CONSTRAINT Type_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Recette
#------------------------------------------------------------

CREATE TABLE Recette(
        id          Int  Auto_increment  NOT NULL ,
        libelle     Varchar (255) NOT NULL ,
        description Varchar (1000) NOT NULL ,
        uneImage    Varchar (255) NOT NULL ,
        dateAjout   Date NOT NULL ,
        id_Type     Int NOT NULL
	,CONSTRAINT Recette_PK PRIMARY KEY (id)

	,CONSTRAINT Recette_Type_FK FOREIGN KEY (id_Type) REFERENCES Type(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Reserver
#------------------------------------------------------------

CREATE TABLE Reserver(
        id             Int NOT NULL ,
        id_Utilisateur Int NOT NULL
	,CONSTRAINT Reserver_PK PRIMARY KEY (id,id_Utilisateur)

	,CONSTRAINT Reserver_Session_FK FOREIGN KEY (id) REFERENCES Session(id)
	,CONSTRAINT Reserver_Utilisateur0_FK FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Proposer
#------------------------------------------------------------

CREATE TABLE Proposer(
        id         Int NOT NULL ,
        id_Session Int NOT NULL
	,CONSTRAINT Proposer_PK PRIMARY KEY (id,id_Session)

	,CONSTRAINT Proposer_Recette_FK FOREIGN KEY (id) REFERENCES Recette(id)
	,CONSTRAINT Proposer_Session0_FK FOREIGN KEY (id_Session) REFERENCES Session(id)
)ENGINE=InnoDB;

