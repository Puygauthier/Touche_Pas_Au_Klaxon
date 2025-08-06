CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('utilisateur', 'admin') NOT NULL DEFAULT 'utilisateur'
);

CREATE TABLE agences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id INT NOT NULL,
    agence_arrivee_id INT NOT NULL,
    date_heure_depart DATETIME NOT NULL,
    date_heure_arrivee DATETIME NOT NULL,
    places_total INT NOT NULL CHECK (places_total > 0),
    places_disponibles INT NOT NULL CHECK (places_disponibles >= 0),
    auteur_id INT NOT NULL,

    FOREIGN KEY (agence_depart_id) REFERENCES agences(id),
    FOREIGN KEY (agence_arrivee_id) REFERENCES agences(id),
    FOREIGN KEY (auteur_id) REFERENCES utilisateurs(id),

    CHECK (agence_depart_id != agence_arrivee_id),
    CHECK (date_heure_arrivee > date_heure_depart),
    CHECK (places_disponibles <= places_total)
);
