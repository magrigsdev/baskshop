
CREATE TABLE marques(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE roles(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE utilisateur(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   prenom VARCHAR(200),
   mot_de_passe VARCHAR(200) NOT NULL,
   adresse VARCHAR(200) NOT NULL,
   roles_id INT NOT NULL,
   type_utilisateur VARCHAR(200) NOT NULL,
   image VARCHAR(200),
   statut VARCHAR(200) NOT NULL,
   telephone VARCHAR(200),
   PRIMARY KEY(id),
   FOREIGN KEY(roles_id) REFERENCES roles(id)
);

CREATE TABLE fournisseur(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   contact VARCHAR(200) NOT NULL,
   adresse VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE reduction(
   id INT AUTOINCREMENT,
   pourcentage VARCHAR(200) NOT NULL,
   date_debut DATE,
   date_fin DATE,
   PRIMARY KEY(id)
);

CREATE TABLE Categorie(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE Paiement(
   id INT AUTOINCREMENT,
   commande_id INT NOT NULL,
   montant DECIMAL(15,2) NOT NULL,
   date_paiement DATE NOT NULL,
   moyen_paiement VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE produit(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   description VARCHAR(200),
   prix DECIMAL(15,2) NOT NULL,
   categorie_id INT NOT NULL,
   taille INT NOT NULL,
   couleur VARCHAR(50),
   marque_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(marque_id) REFERENCES marques(id),
   FOREIGN KEY(categorie_id) REFERENCES Categorie(id)
);

CREATE TABLE client(
   id INT AUTOINCREMENT,
   nom VARCHAR(200) NOT NULL,
   prenom VARCHAR(200),
   mote_de_passe VARCHAR(50) NOT NULL,
   telephone VARCHAR(200) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE emplacement(
   id INT AUTOINCREMENT,
   nom VARCHAR(20) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE avis(
   id INT AUTOINCREMENT
   client_id INT AUTOINCREMENT,
   commentaire VARCHAR(200),
   produit_id INT,
   note DECIMAL(15,2),
   date_avis DATE NOT NULL,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE Image_Produit(
   id INT AUTOINCREMENT,
   produit_id INT,
   url VARCHAR(200) NOT NULL,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE sous_categorie(
   id INT AUTOINCREMENT,
   categorie_id INT,
   nom VARCHAR(50) NOT NULL,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Categorie(id)
);

CREATE TABLE adresse(
   id INT AUTOINCREMENT,
   client_id INT,
   rue VARCHAR(200),
   ville VARCHAR(200),
   code_postal VARCHAR(200) NOT NULL,
   autre_type_adresse VARCHAR(200),
   pays VARCHAR(200),
   PRIMARY KEY(id),
   FOREIGN KEY(client_id) REFERENCES client(id)
);

CREATE TABLE commande(
   id VARCHAR(50),
   client_id INT NOT NULL,
   date_commande DATE NOT NULL,
   statut VARCHAR(200) NOT NULL,
   paiement_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(client_id) REFERENCES client(id)
);

CREATE TABLE panier(
   id INT AUTOINCREMENT,
   client_id INT NOT NULL,
   date_creation DATE NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(client_id) REFERENCES client(id)
);

CREATE TABLE livraison(
   id INT AUTOINCREMENT,
   commande_id INT NOT NULL,
   adresse_livraison_id INT NOT NULL,
   date_livraison DATE,
   statut_livraison VARCHAR(200) NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(commande_id) REFERENCES commande(id)
);

CREATE TABLE facture(
   id INT AUTOINCREMENT,
   commande_id INT NOT NULL,
   client_id INT NOT NULL,
   montant_total DECIMAL(15,2) NOT NULL,
   date_facture DATE NOT NULL,
   id_1 INT NOT NULL,
   id_2 VARCHAR(50) NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Paiement(id),
   FOREIGN KEY(id_2) REFERENCES commande(id)
);

CREATE TABLE beneficier(
   id INT,
   id_1 INT,
   taux VARCHAR(50) NOT NULL,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES reduction(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE Fournir(
   id INT,
   id_1 INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES fournisseur(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE stocker(
   id INT,
   id_1 INT,
   quantite INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES produit(id),
   FOREIGN KEY(id_1) REFERENCES emplacement(id)
);

CREATE TABLE ligne_livraison(
   id INT,
   id_1 INT,
   quantite INT NOT NULL,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES livraison(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE ligne_panier(
   id INT,
   id_1 INT,
   quantite INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES produit(id),
   FOREIGN KEY(id_1) REFERENCES panier(id)
);

CREATE TABLE ligne_facture(
   id INT,
   id_1 INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES facture(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);

CREATE TABLE ligne_cmmande(
   id VARCHAR(50),
   id_1 INT,
   commade_id INT,
   produit_id INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES commande(id),
   FOREIGN KEY(id_1) REFERENCES produit(id)
);
