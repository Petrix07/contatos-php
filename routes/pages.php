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
$obRouter->post('/pessoas', [
    function ($request) {
        return new Response(200, Pages\Person::getSeachPeople($request));
    }
]);

/* Rota que busca o formulário de cadastro de pessoas */
$obRouter->get('/pessoas/cadastrar', [
    function () {
        return new Response(200, Pages\Person::getNewPerson());
    }
]);

/* Rota para cadastrar pessoas */
$obRouter->post('/pessoas/cadastrar', [
    function ($request) {
        return new Response(200, Pages\Person::getPageInsertPerson($request));
    }
]);

/* Rota buscar o formulário de alteração de pessoa  */
$obRouter->get('/pessoas/visualizar/{id}', [
    function ($id) {
        return new Response(200, Pages\Person::getDetailPerson($id));
    }
]);

/* Rota buscar o formulário de alteração de pessoa  */
$obRouter->get('/pessoas/alterar/{id}/edit', [
    function ($id) {
        return new Response(200, Pages\Person::getEditPerson($id));
    }
]);

/* Rota para alterar uma pessoa*/
$obRouter->post('/pessoas/alterar/{id}/edit', [
    function ($request, $id) {
        return new Response(200, Pages\Person::setEditPerson($request, $id));
    }
]);

/* Rota para alterar uma pessoa*/
$obRouter->get('/pessoas/deletar/{id}/delete', [
    function ($id) {
        return new Response(200, Pages\Person::getConfirmDeletePerson($id));
    }
]);

/* Rota para alterar uma pessoa*/
$obRouter->post('/pessoas/deletar/{id}/delete', [
    function ($id) {
        return new Response(200, Pages\Person::setConfirmDeletePerson($id));
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
