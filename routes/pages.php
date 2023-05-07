<?php

use \App\Http\Response,
    \App\Controller\Pages;

/* Rota da página Home */
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

/* Rota da página Sobre */
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\Sobre::getHome());
    }
]);

/* Rota dinâmica */
$obRouter->get('/pagina/{idPagina}', [
    function ($idPagina) {
        return new Response(200, "Página $idPagina");
    }
]);
