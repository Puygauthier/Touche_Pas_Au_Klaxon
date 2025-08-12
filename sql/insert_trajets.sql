USE covoiturage;

-- Réinitialise uniquement la table trajets
TRUNCATE TABLE trajets;

-- 10 trajets de démo (dates futures), IDs résolus par nom pour éviter les décalages
INSERT INTO trajets (
  agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee,
  places_total, places_disponibles, auteur_id
) VALUES
(
  (SELECT id FROM agences WHERE nom='Paris'      LIMIT 1),
  (SELECT id FROM agences WHERE nom='Lyon'       LIMIT 1),
  '2025-08-15 08:00:00','2025-08-15 11:00:00', 4, 4,
  (SELECT id FROM utilisateurs WHERE email='alexandre.martin@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Marseille'  LIMIT 1),
  (SELECT id FROM agences WHERE nom='Paris'      LIMIT 1),
  '2025-08-16 09:30:00','2025-08-16 12:30:00', 3, 2,
  (SELECT id FROM utilisateurs WHERE email='sophie.dubois@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Toulouse'   LIMIT 1),
  (SELECT id FROM agences WHERE nom='Nice'       LIMIT 1),
  '2025-08-17 07:45:00','2025-08-17 10:00:00', 5, 5,
  (SELECT id FROM utilisateurs WHERE email='julien.bernard@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Nantes'     LIMIT 1),
  (SELECT id FROM agences WHERE nom='Strasbourg' LIMIT 1),
  '2025-08-18 13:00:00','2025-08-18 16:00:00', 2, 1,
  (SELECT id FROM utilisateurs WHERE email='camille.moreau@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Montpellier' LIMIT 1),
  (SELECT id FROM agences WHERE nom='Bordeaux'    LIMIT 1),
  '2025-08-19 15:30:00','2025-08-19 18:00:00', 6, 6,
  (SELECT id FROM utilisateurs WHERE email='lucie.lefevre@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Lille'      LIMIT 1),
  (SELECT id FROM agences WHERE nom='Rennes'     LIMIT 1),
  '2025-08-20 10:00:00','2025-08-20 13:00:00', 4, 3,
  (SELECT id FROM utilisateurs WHERE email='thomas.leroy@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Reims'      LIMIT 1),
  (SELECT id FROM agences WHERE nom='Paris'      LIMIT 1),
  '2025-08-21 08:30:00','2025-08-21 11:30:00', 3, 3,
  (SELECT id FROM utilisateurs WHERE email='chloe.roux@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Lyon'       LIMIT 1),
  (SELECT id FROM agences WHERE nom='Marseille'  LIMIT 1),
  '2025-08-22 09:00:00','2025-08-22 12:00:00', 5, 4,
  (SELECT id FROM utilisateurs WHERE email='maxime.petit@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Nice'       LIMIT 1),
  (SELECT id FROM agences WHERE nom='Toulouse'   LIMIT 1),
  '2025-08-23 07:15:00','2025-08-23 10:15:00', 2, 2,
  (SELECT id FROM utilisateurs WHERE email='laura.garnier@email.fr' LIMIT 1)
),
(
  (SELECT id FROM agences WHERE nom='Strasbourg' LIMIT 1),
  (SELECT id FROM agences WHERE nom='Nantes'     LIMIT 1),
  '2025-08-24 14:00:00','2025-08-24 17:00:00', 4, 4,
  (SELECT id FROM utilisateurs WHERE email='antoine.dupuis@email.fr' LIMIT 1)
);
