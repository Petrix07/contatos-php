<?php

use \App\Http\Response,
    \App\Controller\Pages;

/* Rota da página Home */

$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

/* Rota de pessoas */
$obRouter->get('/pessoas', [
    function () {
        return new Response(200, Pages\Person::getPagePeople());
    }
]);

/* Rota de pessoas */
$obRouter->get('/pessoas/cadastrar', [
    function () {
        return new Response(200, Pages\Person::getFormPerson());
    }
]);

/* Rota de pessoas */
$obRouter->post('/pessoas/cadastrar', [
    function ($request) {
        return new Response(200, Pages\Person::getPageInsertPerson($request));
    }
]);

/* Rota de pessoas */
$obRouter->post('/pessoas/alterar/{$id}', [
    function ($request, $id) {
        return new Response(200, Pages\Person::getEditPersonPage($request, $id));
    }
]);

/* Rota de contatos */
$obRouter->get('/contatos', [
    function () {
        return new Response(200, Pages\Contact::getPageContacts());
    }
]);

/* Rota dinâmica */
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página' . $idPagina . $acao);
    }
]);
