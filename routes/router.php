<?php

require_once 'controllers/controller.php';


//twig config
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, [
    'cache' => false,
]);
//end twig


//get url basename
$link = basename($_SERVER['REQUEST_URI']);


//replace project name by /
if($link == 'file_transfert') {
    $link = '/';
}


if($link == 'accueil' || $link == '/') {
    
    //when submit button is clicked
    if(isset($_POST['submitBtn'])) {
        if(isset($_POST['name']) && isset($_POST['transmitter_email']) && isset($_POST['receiver_email']) && isset($_POST['message']) && $_FILES['file']['name'] != "") {
            $random_value = random_value();
            $path = $path = $_FILES['file']['name'];
            $file_url = move_file($path);

            //insert new transmitter (emetteur)
            new_emetteur($_POST['name'], $_POST['transmitter_email'], $_POST['message'], $random_value);

            // get transmitter id
            $id_emetteur = get_emetteur_id($_POST['name'], $_POST['transmitter_email'], $_POST['message'], $random_value);

            //insert the file
            new_file()($file_url, $id_emetteur);

            //insert receiver
            new_receiver($_POST[''], $id_emetteur);

            //get file id and receiver id
            $file_id = get_file_id($id_emetteur);
            $receiver_id = get_receiver_id($id_emetteur);

            //insert link between file and receiver
            new_file_receiver_link($file_id, $receiver_id);

            //send mail
            $message_for_transmitter = '
                <html>
                    <head>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
                    </head>
                    <body>
                        <div class="text-center">
                            <h3>Aquila</h3>
                            <small>transfert de fichier</small>
                            <h2>Fichiers envoyés à</h2>
                            <h2>' . $_POST['receiver_email'] . '</h2>
                            <p>Merci d\'avoir utilisé Aquila. Un mail de confirmation vous seras envoyé dés que vos fichiers seront téléchargés.</p>
                        </div>
                    </body>
                </html>
                ';


            send_mail($_POST['transmitter_email'], $message_for_transmitter);


            $message_for_receiver = '
                <html>
                    <head>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
                    </head>
                    <body>
                        <div class="text-center">
                            <h3>Aquila</h3>
                            <small>transfert de fichier</small>
                            <h2>' . $_POST['name'] . '</h2>
                            <h4> vous a envoyé un fichier.</h4>
                            <a href="download?file=' . $file_url . '" target="_blank">
                                <button class="btn btn-primary">Télécharger</button>
                            </a>
                        </div>
                    </body>
                </html>
                ';

            send_mail($_POST['receiver_email'], $message_for_receiver);


            echo $twig->render('accueil.twig');

        }
    }
    else {
        echo $twig->render('accueil.twig');
    }
   
}


// else if($link == 'test') {
//     if(isset($_POST['btnTest'])) {
//         $test = $_POST['test'];
//     }
//     echo $twig->render('accueil.twig', ['saisi' => $test]);
// }


else {
    echo $twig->render('error.twig');
}

