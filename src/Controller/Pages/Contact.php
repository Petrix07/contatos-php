<?php

namespace App\Controller\Pages;

use \App\Http\Request,
    \App\Utils\View,
    App\Interface\IController,
    \App\Model\Contact as EntityContact,
    \App\Model\Person as EntityPerson;

/**
 * Controller para a entidade Contato
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Contact extends Page implements IController
{
    /**
     * @inheritdoc
     * @return EntityContact
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

    /**
     * Abre o formulário de visualização do contato informado
     * @param int $id
     * @return string
     */
    public static function getDetailsContact($id): string
    {
        $contact = EntityContact::findRegisterById($id, EntityContact::class);
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

        return parent::getPage('Visualizar contato', $content);
    }

    /**
     * Retorna a página de cadastro de contato
     * @return string
     */
    public static function getNewContact(): string
    {
        $componentPeople = self::getComponentPeople();
        $content = View::render('pages/contact/form', [
            'title'              => 'Cadastro de contato',
            'description'        => 'Preencha as informações de contato.',
            'id'                 => null,
            'componentPerson'    => $componentPeople,
            'selected'           => 'selected',
            'type'               => null,
            'namePerson'         => null,
            'descriptionContact' => null,
            'nameAction'         => 'Cadastrar'
        ]);

        return parent::getPage('Cadastrar contato', $content);
    }

    private static function getComponentPeople()
    {
        $people = self::getModelController()->getAll(EntityPerson::class);
        $componentPeople = '';
        foreach ($people as $person) {
            $componentPeople .= View::render('pages/contact/componentPerson', [
                'idPerson'   => $person->getId(),
                'namePerson' => $person->getName()
            ]);
        }

        return $componentPeople;
    }

    /**
     * Cadastra uma nova entidade de contact
     * @param Request $request
     * @return string
     */
    public static function insertNewContact(Request $request): string
    {
        $newContact = new EntityContact();
        self::loadContactInformationByRequest($newContact, $request);
        $newContact->insertNewContact($newContact, $request->getPostVars()['personId']);

        $content = View::render('pages/message', [
            'title'       => 'Registro incluído com sucesso!',
            'description' => 'Acesse a consulta de contatos para visualizar o novo registro inserido.',
            'bgCard'      => 'bg-success',
            'path'        => '/contatos',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $content);
    }

    /**
     * Carrega o objeto contato com base nos dados presentes no POST da request
     */
    private static function loadContactInformationByRequest(EntityContact $contact, $request): void
    {
        $postVars = $request->getPostVars();
        $contact->setType($postVars['type']);
        $contact->setDescription($postVars['descriptionContact']);
    }

    /**
     * Retorna o formulário de edição de pessoas
     * @param int $id
     * @return string
     */
    public static function getEditContact(int $id): string
    {
        $contact           = EntityContact::findRegisterById($id, EntityContact::class);
        $contentPeopleBase = self::getComponentPeople();
        $componentPeople   = self::setSelectedPerson($contentPeopleBase, $contact);
        $content = View::render('pages/contact/form', [
            'title'              => 'Cadastro de contato',
            'description'        => 'Preencha as informações de contato.',
            'id'                 => $contact->getId(),
            'componentPerson'    => $componentPeople,
            'selected'           => 'selected',
            'type'               => $contact->getType(),
            'namePerson'         => $contact->getPerson()->getName(),
            'descriptionContact' => $contact->getDescription(),
            'nameAction'         => 'Alterar'
        ]);

        return parent::getPage('Editar Contato', $content);
    }

    /**
     * Seleciona o item da lista de acordo com o id presente na pessoa definida no contato
     * @param string $componentPeople
     * @param EntityContact $contact
     * @return string
     */
    private static function setSelectedPerson(string $componentPeople, EntityContact $contact): string
    {
        $str = 'value="' . $contact->getPerson()->getId() . '"';
        return str_replace($str, $str . ' selected', $componentPeople);
    }

    /**
     * Edita a pessoa informada
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditContact(Request $request, int $id)
    {
        $connection    = EntityContact::getConnection();
        $entityManager = $connection->getEntityManager();
        $contact       = $entityManager->getRepository(EntityContact::class)->find($id);

        if ($request->getPostVars()['personId'] != $contact->getPerson()->getId()) {
            $person = $entityManager->getReference(EntityPerson::class, $request->getPostVars()['personId']);
            $contact->setPerson($person);
        }
        self::loadContactInformationByRequest($contact, $request);
        $entityManager->flush();

        $content = View::render('pages/message', [
            'title'       => 'Registro alterado com sucesso!',
            'description' => 'Acesse a consulta de contatos para visualizar o registro alterado.',
            'bgCard'      => 'bg-success',
            'path'        => '/contatos',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $content);
    }
}
