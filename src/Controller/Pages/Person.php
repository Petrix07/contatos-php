<?php

namespace App\Controller\Pages;

use \App\Http\Request,
    \App\Utils\View,
    \App\Config\ConnectionBD,
    \App\Model\Person as EntityPerson,
    Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
                    'id'   => $person->getCpf(),
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
        $personRepo    = $entityManager->getRepository(EntityPerson::class);
        return  $personRepo->findAll();
    }

    /**
     * Retorna a página de cadastro de uma nova person
     */
    public static function  getPersonRegistrationPage(): string
    {
        $sContent = View::render('pages/personRegistration', [
            'title'       => 'Cadastrar uma nova pessoa.',
            'description' => 'Preencha os campos abaixo para gerar um novo registro de pessoa.',
            'nameAction'  => 'Cadastrar',
        ]);

        return parent::getPage('Cadastrar pessoa', $sContent);
    }

    /**
     * Cadastra uma nova entidade de person
     * @param Request $request
     */
    public static function getPageInsertPerson(Request $request): string
    {
        $newPerson = new EntityPerson();
        self::loadPersonInformationByRequest($newPerson, $request);
        $connectiononnection = self::getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $titleMsg            = 'Registro incluído com sucesso!';
        $descriptionAction   = 'Acesse a consulta de pessoas para visualizar o novo registro inserido.';
        $bgType              = 'bg-success';
        try {
            $entityManager->persist($newPerson);
            $entityManager->flush();
        } catch (\Throwable $th) {
            $titleMsg          = 'Ocorreram problemas durante a inclusão do registro.';
            $descriptionAction = $th instanceof UniqueConstraintViolationException ? 'O CPF informado já está cadastrado a outro registro. Tente realizar a inclusão novamente informando outro CPF' : 'Não foi possível realizar a inclusão';
            $bgType            = 'bg-warning';
        }

        $sContent = View::render('pages/message', [
            'title'       => $titleMsg,
            'description' => $descriptionAction,
            'bgCard'      => $bgType,
            'path'        => '/pessoas',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $sContent);
    }

    private static function loadPersonInformationByRequest(EntityPerson $person, $request)
    {
        $postVars = $request->getPostVars();
        $person->setName($postVars['name']);
        $person->setCpf($postVars['cpf']);
    }

    private static function getConnection(): ConnectionBD
    {
        return new ConnectionBD();
    }

    /**
     * Retorna o formulário de edição de pessoas
     * @param Request $request
     * @param int $id
     */
    public static function getEditPersonPage($request, $id) {
        return '';
    }
}
