<?php

require_once 'controllers/controller.php';

//delete expired file
auto_delete();

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
    
    echo $twig->render('accueil.twig');

    //when submit button is clicked
    if(isset($_POST['submitBtn'])) {
        if(isset($_POST['name']) && isset($_POST['transmitter_email']) && isset($_POST['receiver_email']) && isset($_POST['message'])) {
            $random_value = random_value();
            $path = $_FILES['new_file']['name'];
            $file_url = move_file($path);

            //insert new transmitter (emetteur)
            new_emetteur($_POST['name'], $_POST['transmitter_email'], $_POST['message'], $random_value);

            // echo $_POST['name'] . ' / ' . $_POST['transmitter_email'] . ' / ' . $_POST['message'] . ' / ' . $random_value;

            // get transmitter id
            $id_emetteur = get_emetteur_id($_POST['name'], $_POST['transmitter_email'], $_POST['message'], $random_value);

            //insert the file
            new_file($file_url, $id_emetteur);

            //insert receiver
            new_receiver($_POST['receiver_email'], $id_emetteur);

            //get file id and receiver id
            $file_id = get_file_id($id_emetteur);
            $receiver_id = get_receiver_id($id_emetteur);

            //insert link between file and receiver
            new_file_receiver_link($file_id, $receiver_id);

            //send mail
            $message_for_transmitter = '
                <html>
                    <head>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                    </head>
                    <body>
                        <div class="text-center">
                            <h3>Aquila</h3>
                            <small>transfert de fichier</small>
                            <h2>Fichiers envoyés à</h2>
                            <h2>' . $_POST['receiver_email'] . '</h2>
                            <p>Les fichiers seront supprimés dans 7 jours</p>
                            <p>Merci d\'avoir utilisé Aquila. Un mail de confirmation vous seras envoyé dés que vos fichiers seront téléchargés.</p>
                        </div>
                    </body>
                </html>
                ';


            send_mail($_POST['transmitter_email'], $message_for_transmitter);


            $message_for_receiver = '
                <html>
                    <head>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                    </head>
                    <body>
                        <div class="text-center">
                            <h3>Aquila</h3>
                            <small>transfert de fichier</small>
                            <h2>' . $_POST['name'] . '</h2>
                            <h4> vous a envoyé un fichier.</h4>
                            <p>Les fichiers seront supprimés dans 7 jours</p>
                            <h4>Message : </h4>
                            <p>' . $_POST['message'] . '</p>
                            <a href="' . $_SERVER['REQUEST_URI'] . 'download?file=' . $file_url . '" target="_blank">
                                <button class="btn btn-primary">Télécharger</button>
                            </a>
                        </div>
                    </body>
                </html>
                ';

            send_mail($_POST['receiver_email'], $message_for_receiver);


            // echo $twig->render('accueil.twig');
            // echo $_FILES['new_file']['name'];

        }
        else {
            echo "Veuillez remplir touts les champs !!!";
        }
    }
   
}

else if($link == 'telecharger') {
    echo $twig->render('download.twig');
}

else {
    echo $twig->render('error.twig', ['link' => $link]);
}

