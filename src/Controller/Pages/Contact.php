<?php

namespace App\Controller\Pages;

use \App\Http\Request,
    \App\Utils\View,
    \App\Model\Contact as EntityContact,
    App\Interface\IController;

/**
 * Controller para a entidade Contato
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Contact extends Page implements IController
{
    /**
     * @inheritdoc
     * @return EntityContactt
     */
    public static function getModelController()
    {
        return new EntityContact();
    }

    
    /**
     * Retorna a tela de consulta de contatos
     * @return string
     */
    public static function getPageContacts(): string
    {
        $contacts = self::getModelController()->getAll(EntityContact::class);
        $contentContacts = '';

        if (count($contacts)) {
            foreach ($contacts as $contact) {
                $contentContacts .= View::render('pages/contact/contact', [
                    'id'           => $contact->getId(),
                    'type'         => $contact->getType(),
                    'namePerson'   => $contact->getPerson()->getName(),
                    'description'  => $contact->getDescription(),
                ]);
            }
        }

        $content = View::render('pages/contact/contacts', [
            'title'       => 'Consulta de Contatos',
            'description' => 'Página de Contato da aplicação',
            'contacts'    => $contentContacts
        ]);

        return parent::getPage('Consulta de contatos', $content);
    }

    public static function getDetailsContact($id): string
    {
        $contact       = EntityContact::findRegisterById($id, EntityContact::class);
        $content = View::render('pages/contact/details', [
            'title'              => 'Detalhes do contato',
            'description'        => 'Abaixo está presente todos os dados de do contato.',
            'id'                 => $contact->getId(),
            'type'               => $contact->getType(),
            'namePerson'         => $contact->getPerson()->getName(),
            'descriptionContact' => $contact->getDescription(),
            'path'               => '/contatos',
            'nameAction'         => 'Retornar a consulta'
        ]);

        return parent::getPage('Visualizar pessoa', $content);
    }

    /**
     * Retorna a página de cadastro de contato
     * @return string
     */
    public static function getNewContact(): string
    {


        $content = View::render('pages/contact/form', [
            'title'              => 'Detalhes do contato',
            'description'        => 'Abaixo está presente todos os dados de do contato.',
            'id'                 => null,
            'type'               => null,
            'namecontact'        => null,
            'descriptionContact' => null,
            'path'               => '/contatos/cadastrar',
            'nameAction'         => 'Cadastrar'
        ]);

        return parent::getPage('Cadastrar pessoa', $content);
    }


    /**
     * Cadastra uma nova entidade de contact
     * @param Request $request
     * @return string
     */
    public static function insertNewContact(Request $request): string
    {
        $newcontact = new EntityContact();
        self::loadContactInformationByRequest($newcontact, $request);
        $connectiononnection = self::getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $entityManager->persist($newcontact);
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
     * Carrega o objeto Contato com base nos dados presentes no POST da request
     */
    private static function loadContactInformationByRequest(EntityContact $contact, $request): void
    {
        $postVars = $request->getPostVars();
        echo "<pre>";
        print_r($postVars);
        echo "</pre>";
        exit;
        $contact->setType($postVars['name']);
        $contact->setDescription($postVars['descriptionContact']);
    }
}
