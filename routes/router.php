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
    if(isset($_POST['btnTest'])) {
        if(isset($_POST['']) && isset($_POST['']) && isset($_POST['']) && $_FILES['file']['name'] != "") {
            $random_value = random_value();
            $file_url = move_file();

            //insert new transmitter (emetteur)
            new_emetteur($_POST[''], $_POST[''], $_POST[''], $random_value);

            // get transmitter id
            $id_emetteur = get_emetteur_id($_POST[''], $_POST[''], $_POST[''], $random_value);

            //insert the file
            new_file()($file_url, $id_emetteur);

            //insert receiver
            new_receiver($_POST[''], $id_emetteur);

            //get file id and receiver id
            $file_id = get_file_id($id_emetteur);
            $receiver_id = get_receiver_id($id_emetteur);

            //insert link between file and receiver
            new_file_receiver_link($file_id, $receiver_id);

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

