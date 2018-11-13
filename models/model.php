<?php

/**
 * database connexion function
 * @return pdo object 
 */

 function database_connexion() {
    try {
        $connexion = new PDO('mysql:host=localhost;dbname=file_transfert;charset=utf8','root','');

        return $connexion;
    }
    catch(Exception $ex) {
        die('Erreur de connexion à la base de données => ' . $ex->getMessage());
    }
}



/**
 * insert new user (transmitter)
 * @param string nom
 * @param string email_emetteur
 * @param string message
 */
function insert_emetteur($nom, $email_emetteur, $message) {
    $con = database_connexion();
    $query = 'INSERT INTO emetteurs(nom_emetteur, email_emetteur, file_message) VALUES (?, ?, ?)';
    $request = $con->prepare($query);
    $request->execute(array($nom, $email_emetteur, $message));
}


/**
 * insert file url
 * @param string file url
 * @param string date inserting file
 * @param integer id transmitter (emetteur)
 */
function insert_file($url, $date, $id_emetteur) {
    $con = database_connexion();
    $query = 'INSERT INTO fichiers(file_url, date_transfert, id_emetteur) VALUES (?, ?, ?)';
    $request = $con->prepare($query);
    $request->execute(array($url, $date, $id_emetteur));
}



/**
 * insert receiver (destinataire)
 * @param string receiver email
 */
function insert_receiver($email_recepteur) {
    $con = database_connexion();
    $query = 'INSERT INTO recepteurs(email_recepteur) VALUES (?)';
    $request = $con->prepare($query);
    $request->execute(array($email_recepteur));
}



/**
 * insert link between file and receiver
 * @param integer id file
 * @param integer id receiver
 */
function file_receiver_link($id_file, $id_receiver) {
    $con = database_connexion();
    $query = 'INSERT INTO fichier_recepteur(id_fichier, id_recepteur) VALUES (?, ?)';
    $request = $con->prepare($query);
    $request->execute(array($id_file, $id_receiver));
}
