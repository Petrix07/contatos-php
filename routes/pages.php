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
        return new Response(200, Pages\Person::insertNewPerson($request));
    }
]);

/* Rota buscar o formulário de alteração de pessoa  */
$obRouter->get('/pessoas/visualizar/{id}', [
    function ($id) {
        return new Response(200, Pages\Person::getDetailsPerson($id));
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

/* Rota da consulta contatos */
$obRouter->get('/contatos', [
    function () {
        return new Response(200, Pages\Contact::getPageContacts());
    }
]);

/* Rota da visualização do contato */
$obRouter->get('/contatos/visualizar/{id}', [
    function ($id) {
        return new Response(200, Pages\Contact::getDetailsContact($id));
    }
]);


/* Rota para obter o formulário de cadastro de contato */
$obRouter->get('/contatos/cadastrar', [
    function ($request) {
        return new Response(200, Pages\Contact::getNewContact($request));
    }
]);

/* Rota para cadastrar um novo contato */
$obRouter->post('/contatos/cadastrar', [
    function ($request) {
        return new Response(200, Pages\Contact::insertNewContact($request));
    }
]);

/* Rota buscar o formulário de alteração de pessoa  */
$obRouter->get('/contatos/alterar/{id}/edit', [
    function ($id) {
        return new Response(200, Pages\Contact::getEditContact($id));
    }
]);

/* Rota para alterar uma pessoa*/
$obRouter->post('/contatos/alterar/{id}/edit', [
    function ($request, $id) {
        return new Response(200, Pages\Contact::setEditContact($request, $id));
    }
]);