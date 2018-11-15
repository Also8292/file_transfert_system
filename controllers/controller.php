<?php

require_once 'models/model.php';

/**
 * new sending file
 */

/**
 * insert emetteur
 */
function new_emetteur($nom_emetteur, $email_emetteur, $message, $random_value) {
    insert_emetteur($nom_emetteur, $email_emetteur, $message, $random_value);
}


/**
 * insert file
 */
function new_file($file_url, $id_emetteur) {
    insert_file($file_url, $id_emetteur);
}



/**
 * insert receiver
 */
function new_receiver($email_recepteur, $id_emetteur) {
    insert_receiver($email_recepteur, $id_emetteur);
}



/**
 * insert link between receiver and file
 */
function new_file_receiver_link($idfile, $idreceiver) {
    file_receiver_link($idfile, $idreceiver);
}




/**
 * get id emetteur
 * @return emetteur id
 */
function get_emetteur_id($nom_emetteur, $email_emetteur, $message, $random_value) {
    $request =  get_emetteur($nom_emetteur, $email_emetteur, $message, $random_value);

    $id = '';

    while($result = $request->fetch()) {
        $id = $result['id_emetteur'];
    }

    return $id;
}



/**
 * get file id
 * @return file id
 */
function get_file_id($id_emetteur) {
    $request = get_file($id_emetteur);

    $file_id = '';

    while($result = $request->fetch()) {
        $file_id = $result['id_fichier'];
    }

    return $file_id;
}


/**
 * get receiver id
 * @return receiver id
 */
function get_receiver_id($id_emetteur) {
    $request = get_receiver($id_emetteur);

    $receiver_id = '';

    while($result = $request->fetch()) {
        $receiver_id = $result['id_recepteur'];
    }

    return $receiver_id;
}



/**
 * Moves uploaded file to our upload folder
 */
function move_file() {
    $path = $_FILES['file']['name'];
    $pathto = 'upload/'.$path;
    move_uploaded_file( $_FILES['file']['tmp_name'], $pathto) or 
    die( "Could not copy file!");
    // }
    // else
    // {
    //     die("No file specified!");
    // }
    return $pathto;
}


/**
 * send mail from transmitter to receiver
 */
function send_mail($mail, $emetteur_id, $emetteur_name) {
    $file_url = get_file_downloaded_url($emetteur_id);

    $header = "MIME-Version: 1.0\r\n";
    $header .= 'From:"fiiw"<support@fiiw.com>'."\n";
    $header .= 'Content-Type:text/html; charset="utf-8"'."\n";
    $header .= 'Content-Transfert-Encoding: 8bit';

    $message = '
    <html>
        <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="text-center">
                <h3>Fiiw</h3>
                <small>transfert de fichier</small>
                <h2>' . $emetteur_name . '</h2>
                <h4> vous a envoyé un fichier.</h4>
                <a href="download?file=' . $file_url . '" target="_blank">
                    <button class="btn btn-primary">Télécharger</button>
                </a>
            </div>
        </body>
    </html>
    ';

    mail($mail,"Confimation de votre adresse mail", $message, $header);
}


/**
 * get emetteur name
 * @return emetteur name
 */
function get_emetteur_name($nom_emetteur, $email_emetteur, $message, $random_value) {
    $request =  get_emetteur($nom_emetteur, $email_emetteur, $message, $random_value);

    $name = '';

    while($result = $request->fetch()) {
        $name = $result['nom_emetteur'];
    }

    return $name;
}




/**
 * get file downloaded url
 */
function get_file_downloaded_url($id_emetteur) {
    $request = get_file_downloaded($id_emetteur);

    $file_url = '';

    while($result = $request->fetch()) {
        $file_url = $result['file_url'];
    }

    return $file_url;
}




/**
 * generate random value
 * @return random with 20 characters
 */
function random_value() {
    $rand = '';
    for($i = 0 ; $i < 20 ; $i++) {
        $rand .= mt_rand(0, 9);
    }
    return $rand;
}
