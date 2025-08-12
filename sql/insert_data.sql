USE covoiturage;

-- Remise à zéro douce
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE trajets;
TRUNCATE TABLE agences;
TRUNCATE TABLE utilisateurs;
SET FOREIGN_KEY_CHECKS=1;

-- Agences
INSERT INTO agences (nom) VALUES
('Paris'),('Lyon'),('Marseille'),('Toulouse'),('Nice'),('Nantes'),
('Strasbourg'),('Montpellier'),('Bordeaux'),('Lille'),('Rennes'),('Reims');

-- Hash bcrypt standard de "password" (compatible password_verify)
SET @PWD := '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

-- Utilisateurs (ordre conservé pour que les IDs soient stables)
INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe, role) VALUES
('Martin',    'Alexandre', '0612345678', 'alexandre.martin@email.fr', @PWD, 'utilisateur'),
('Dubois',    'Sophie',    '0698765432', 'sophie.dubois@email.fr',    @PWD, 'utilisateur'),
('Bernard',   'Julien',    '0622446688', 'julien.bernard@email.fr',   @PWD, 'utilisateur'),
('Moreau',    'Camille',   '0611223344', 'camille.moreau@email.fr',   @PWD, 'utilisateur'),
('Lefèvre',   'Lucie',     '0777889900', 'lucie.lefevre@email.fr',    @PWD, 'utilisateur'),
('Leroy',     'Thomas',    '0655443322', 'thomas.leroy@email.fr',     @PWD, 'utilisateur'),
('Roux',      'Chloé',     '0633221199', 'chloe.roux@email.fr',       @PWD, 'utilisateur'),
('Petit',     'Maxime',    '0766778899', 'maxime.petit@email.fr',     @PWD, 'utilisateur'),
('Garnier',   'Laura',     '0688776655', 'laura.garnier@email.fr',    @PWD, 'utilisateur'),
('Dupuis',    'Antoine',   '0744556677', 'antoine.dupuis@email.fr',   @PWD, 'utilisateur'),
('Lefebvre',  'Emma',      '0699887766', 'emma.lefebvre@email.fr',    @PWD, 'utilisateur'),
('Fontaine',  'Louis',     '0655667788', 'louis.fontaine@email.fr',   @PWD, 'utilisateur'),
('Chevalier', 'Clara',     '0788990011', 'clara.chevalier@email.fr',  @PWD, 'utilisateur'),
('Robin',     'Nicolas',   '0644332211', 'nicolas.robin@email.fr',    @PWD, 'utilisateur'),
('Gauthier',  'Marine',    '0677889922', 'marine.gauthier@email.fr',  @PWD, 'utilisateur'),
('Fournier',  'Pierre',    '0722334455', 'pierre.fournier@email.fr',  @PWD, 'utilisateur'),
('Girard',    'Sarah',     '0688665544', 'sarah.girard@email.fr',     @PWD, 'utilisateur'),
('Lambert',   'Hugo',      '0611223366', 'hugo.lambert@email.fr',     @PWD, 'utilisateur'),
('Masson',    'Julie',     '0733445566', 'julie.masson@email.fr',     @PWD, 'utilisateur'),
('Henry',     'Arthur',    '0666554433', 'arthur.henry@email.fr',     @PWD, 'utilisateur');

-- (Facultatif) pour tester l’admin :
-- UPDATE utilisateurs SET role='admin' WHERE email='alexandre.martin@email.fr';
