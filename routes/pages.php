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
        return new Response(200, Pages\Sobre::getAbout  ());
    }
]);

/* Rota dinâmica */
$obRouter->get('/pessoas', [
    function () {
        return new Response(200, 'Página Pessoas');
    }
]);

/* Rota dinâmica */
$obRouter->get('/contatoss', [
    function () {
        return new Response(200, 'Página Contatos');
    }
]);

/* Rota dinâmica */
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página' . $idPagina . $acao);
    }
]);
