<?php

namespace App\Controller\Pages;

use \App\Utils\View,
    \App\Model\Contact as EntityContact;

/**
 * Controller para a entidade Contato
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Contact extends Page
{

    public static function getPageContacts(): string
    {
        $contacts = self::getAllContacts();
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

    /**
     * Retorna todas as pessoas cadastradas
     * @return array
     */
    private static function getAllContacts()
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $contactRepo    = $entityManager->getRepository(EntityContact::class);

        return  $contactRepo->findAll();
    }

    public static function getDetailsContact($id): string
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $contact        = $entityManager->getRepository(EntityContact::class)->find($id);
        $content = View::render('pages/contact/details', [
            'title'       => 'Detalhes do contato',
            'description' => 'Abaixo está presente todos os dados de do contato.',
            'id'           => $contact->getId(),
            'type'         => $contact->getType(),
            'namePerson'   => $contact->getPerson()->getName(),
            'descriptionContact'  => $contact->getDescription(),
        ]);

        return parent::getPage('Visualizar pessoa', $content);
    }
}
