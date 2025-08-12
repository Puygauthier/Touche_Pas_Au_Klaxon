<?php
// Liste des utilisateurs avec mot de passe en clair
$users = [
    ['Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'password'],
    ['Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', 'password'],
    ['Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', 'password'],
    ['Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', 'password'],
    ['Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', 'password'],
    ['Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', 'password'],
    ['Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', 'password'],
    ['Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', 'password'],
    ['Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', 'password'],
    ['Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', 'password'],
    ['Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', 'password'],
    ['Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', 'password'],
    ['Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', 'password'],
    ['Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', 'password'],
    ['Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', 'password'],
    ['Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', 'password'],
    ['Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', 'password'],
    ['Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', 'password'],
    ['Masson', 'Julie', '0733445566', 'julie.masson@email.fr', 'password'],
    ['Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', 'password'],
];

// Génération des lignes INSERT avec password_hash()
foreach ($users as $user) {
    [$nom, $prenom, $tel, $email, $mdp] = $user;
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    echo "INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe) VALUES ('$nom', '$prenom', '$tel', '$email', '$hash');\n";
}
