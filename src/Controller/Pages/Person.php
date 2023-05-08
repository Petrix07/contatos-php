<?php

namespace App\Controller\Pages;

use App\Http\Request;
use \App\Utils\View,
    \App\Config\ConnectionBD,
    \App\Model\Person as ModelPerson;

/**
 * Controller para a entidade Person
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Person extends Page
{

    /**
     * Retorna a tela de consulta de people
     */
    public static function getPagePeople(): string
    {
        $people = self::getAllPeople();
        $contentPeople = '';
        if (count($people)) {
            foreach ($people as $person) {
                $contentPeople .= View::render('pages/person', [
                    'name' => $person->getName(),
                    'cpf'  => $person->getCpf(),
                ]);
            }
        }

        $sContent = View::render('pages/people', [
            'title'       => 'Consulta de Pessoas',
            'description' => 'Segue abaixo todas as pessoas cadastradas no sistema.',
            'people'      => $contentPeople
        ]);

        return parent::getPage('Consulta de Pessoas', $sContent);
    }

    private static function getAllPeople()
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $personRepo    = $entityManager->getRepository(ModelPerson::class);
        return  $personRepo->findAll();
    }

    /**
     * Retorna a página de cadastro de uma nova person
     */
    public static function getPersonRegistrationPage(): string
    {
        $sContent = View::render('pages/personRegistration', [
            'title'       => 'Cadastrar uma nova pessoa.',
            'description' => 'Preencha os campos abaixo para gerar um novo registro de pessoa.',
            'nameAction'  => 'Cadastrar',
        ]);

        return parent::getPage('Home', $sContent);
    }

    /**
     * Cadastra uma nova entidade de person
     * @param Request $request
     */
    public static function insertPerson(Request $request): string
    {
        $newPerson = new ModelPerson();
        self::loadPersonInformationByRequest($newPerson, $request);
        $connectiononnection = self::getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $entityManager->persist($newPerson);
        $entityManager->flush();

        $sContent = View::render('pages/message', [
            'title'       => 'Registro incluído com sucesso!',
            'description' => 'Acesse a consulta de pessoas para visualizar o novo registro inserido.',
            'bgCard'      => 'bg-success',
            'path'        => '/pessoas',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $sContent);
    }

    private static function loadPersonInformationByRequest(ModelPerson $person, $request)
    {
        $postVars = $request->getPostVars();
        $person->setName($postVars['name']);
        $person->setCpf($postVars['cpf']);
    }

    private static function getConnection(): ConnectionBD
    {
        return new ConnectionBD();
    }
}
