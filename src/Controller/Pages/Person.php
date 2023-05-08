<?php

namespace App\Controller\Pages;

use \App\Http\Request,
    \App\Utils\View,
    \App\Config\ConnectionBD,
    \App\Model\Person as EntityPerson;

/**
 * Controller para a entidade Person
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Person extends Page
{

    /**
     * Retorna a tela de consulta de people
     * @return string
     */
    public static function getPagePeople(): string
    {
        $people = self::getAllPeople();
        $contentPeople = '';
        if (count($people)) {
            foreach ($people as $person) {
                $contentPeople .= View::render('pages/person/person', [
                    'id'   => $person->getId(),
                    'name' => $person->getName(),
                    'cpf'  => $person->getCpf(),
                ]);
            }
        }

        $content = View::render('pages/person/people', [
            'title'       => 'Consulta de Pessoas',
            'description' => 'Segue abaixo todas as pessoas cadastradas no sistema.',
            'people'      => $contentPeople
        ]);

        return parent::getPage('Consulta de Pessoas', $content);
    }

    /**
     * Retorna todas as pessoas cadastradas
     * @return array
     */
    private static function getAllPeople()
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $personRepo    = $entityManager->getRepository(EntityPerson::class);

        return  $personRepo->findAll();
    }

    /**
     * Retorna a página de cadastro de uma nova pessoa
     * @return string
     */
    public static function getNewPerson(): string
    {
        $content = View::render('pages/person/form', [
            'title'       => 'Cadastrar uma nova pessoa.',
            'description' => 'Preencha os campos abaixo para gerar um novo registro de pessoa.',
            'name'        => null,
            'cpf'         => null,
            'nameAction'  => 'Cadastrar',
        ]);

        return parent::getPage('Cadastrar pessoa', $content);
    }

    /**
     * Cadastra uma nova entidade de person
     * @param Request $request
     * @return string
     */
    public static function getPageInsertPerson(Request $request): string
    {
        $newPerson = new EntityPerson();
        self::loadPersonInformationByRequest($newPerson, $request);
        $connectiononnection = self::getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $entityManager->persist($newPerson);
        $entityManager->flush();

        $content = View::render('pages/message', [
            'title'       => 'Registro incluído com sucesso!',
            'description' => 'Acesse a consulta de pessoas para visualizar o novo registro inserido.',
            'bgCard'      => 'bg-success',
            'path'        => '/pessoas',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $content);
    }

    /**
     * Carrega o objeto Pessoa com base nos dados presentes no POST da request
     */
    private static function loadPersonInformationByRequest(EntityPerson $person, $request)
    {
        $postVars = $request->getPostVars();
        $person->setName($postVars['name']);
        $person->setCpf($postVars['cpf']);
    }

    /**
     * Retorna um objeto de conexão com o banco de dados
     * @return ConnectionBD
     */
    private static function getConnection(): ConnectionBD
    {
        return new ConnectionBD();
    }

    /**
     * Retorna o formulário de edição de pessoas
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditPerson(int $id): string
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $person        = $entityManager->getRepository(EntityPerson::class)->find($id);;
        $content = View::render('pages/person/form', [
            'title'       => 'Alterar informações da pessoa.',
            'description' => 'Preencha os campos abaixo para alterar as informações de pessoa.',
            'name'        => $person->getName(),
            'cpf'         => $person->getCpf(),
            'nameAction'  => 'Editar',
        ]);

        return parent::getPage('Editar pessoa', $content);
    }

    /**
     * Edita a pessoa informada
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditPerson(Request $request, int $id)
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $person        = $entityManager->getRepository(EntityPerson::class)->find($id);;
        self::loadPersonInformationByRequest($person, $request);
        $entityManager->flush();

        $content = View::render('pages/message', [
            'title'       => 'Registro alterado com sucesso!',
            'description' => 'Acesse a consulta de pessoas para visualizar o registro alterado.',
            'bgCard'      => 'bg-success',
            'path'        => '/pessoas',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $content);
    }
}
