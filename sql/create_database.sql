-- Réinitialisation propre
DROP DATABASE IF EXISTS covoiturage;
CREATE DATABASE covoiturage CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE covoiturage;

SET NAMES utf8mb4;

-- Sécurité : on supprime les tables si elles existent (ordre FK)
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS trajets;
DROP TABLE IF EXISTS agences;
DROP TABLE IF EXISTS utilisateurs;
SET FOREIGN_KEY_CHECKS=1;

-- Utilisateurs (import RH : pas de CRUD employé côté app)
CREATE TABLE utilisateurs (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nom          VARCHAR(100)      NOT NULL,
  prenom       VARCHAR(100)      NOT NULL,
  email        VARCHAR(190)      NOT NULL UNIQUE,
  telephone    VARCHAR(20)       NOT NULL,
  mot_de_passe VARCHAR(255)      NOT NULL,
  role         ENUM('utilisateur','admin') NOT NULL DEFAULT 'utilisateur',
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Agences (gérées par l’admin)
CREATE TABLE agences (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  nom  VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Trajets
CREATE TABLE trajets (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  agence_depart_id     INT NOT NULL,
  agence_arrivee_id    INT NOT NULL,
  date_heure_depart    DATETIME NOT NULL,
  date_heure_arrivee   DATETIME NOT NULL,
  places_total         INT NOT NULL,
  places_disponibles   INT NOT NULL,
  auteur_id            INT NOT NULL,

  CONSTRAINT fk_trajet_dep  FOREIGN KEY (agence_depart_id)  REFERENCES agences(id)      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_trajet_arr  FOREIGN KEY (agence_arrivee_id) REFERENCES agences(id)      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_trajet_auth FOREIGN KEY (auteur_id)         REFERENCES utilisateurs(id) ON UPDATE CASCADE ON DELETE RESTRICT,

  -- Garde-fous (MySQL/MariaDB 10.4+/8.0+)
  CONSTRAINT chk_agences_diff    CHECK (agence_depart_id <> agence_arrivee_id),
  CONSTRAINT chk_places_totales  CHECK (places_total >= 1),
  CONSTRAINT chk_places_dispo    CHECK (places_disponibles >= 0 AND places_disponibles <= places_total),
  CONSTRAINT chk_chronologie     CHECK (date_heure_arrivee > date_heure_depart)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Index utiles
CREATE INDEX idx_trajets_depart  ON trajets (date_heure_depart);
CREATE INDEX idx_trajets_arrivee ON trajets (date_heure_arrivee);
