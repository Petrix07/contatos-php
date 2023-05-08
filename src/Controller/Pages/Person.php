<?php

namespace App\Controller\Pages;

use App\Utils\View;

/**
 * Controller para a entidade Pessoa
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Person extends Page
{

    /**
     * Retorna a tela de consulta de pessoas
     */
    public static function getPagePeople(): string
    {

        $contentPeople = View::render('pages/person', [
            'name' => 'Luiz',
            'cpf'  => '123',
        ]);

        $sContent = View::render('pages/people', [
            'title'       => 'Consulta de Pessoas',
            'description' => 'Segue abaixo todas as pessoas cadastradas no sistema.',
            'people'      => $contentPeople
        ]);

        return parent::getPage('Home', $sContent);
    }

    /**
     * Retorna a página de cadastro de uma nova pessoa
     */
    public static function getPersonRegistrationPage(): string
    {
        $sContent = View::render('pages/personRegistration', [
            'title'       => 'Cadatrar nova Pessoa',
            'description' => 'Preencha os campos abaixo para gerar um novo registro de pessoa.',
            'nameAction'  => 'Cadastrar',
        ]);

        return parent::getPage('Home', $sContent);
    }
}
