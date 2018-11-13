<?php

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


//routing system

if($link == 'accueil' || $link == '/') {
    echo $twig->render('accueil.twig');
}

else {
    echo $twig->render('error.twig', ['lien' => $link]);
}

