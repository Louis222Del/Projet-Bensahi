<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.html");
    exit;
}

// Récupération des champs
$prenom  = htmlspecialchars(trim($_POST["prenom"] ?? ""));
$nom     = htmlspecialchars(trim($_POST["nom"] ?? ""));
$tel     = htmlspecialchars(trim($_POST["telephone"] ?? ""));
$email   = htmlspecialchars(trim($_POST["email"] ?? ""));
$motif   = htmlspecialchars(trim($_POST["motif"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"] ?? ""));

// Validation basique
if (empty($prenom) || empty($nom) || empty($tel) || empty($motif)) {
    header("Location: contact.html?status=erreur");
    exit;
}

// Destinataire
$destinataire = "ilham.bensahi@gmail.com";
$sujet        = "Nouvelle demande de RDV — " . $prenom . " " . $nom;

// Corps du mail
$corps = "
Nouvelle demande de rendez-vous reçue via le site.

--- PATIENT ---
Nom      : $prenom $nom
Téléphone: $tel
Email    : $email

--- DEMANDE ---
Motif    : $motif
Message  : $message
";

// Headers
$headers  = "From: no-reply@cabinet-bensahi.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoi
$envoye = mail($destinataire, $sujet, $corps, $headers);

if ($envoye) {
    header("Location: contact.html?status=succes");
} else {
    header("Location: contact.html?status=erreur");
}
exit;
?>