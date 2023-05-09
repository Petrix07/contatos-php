<?php

namespace App\Controller\Pages;

use \App\Http\Request,
    \App\Utils\View,
    \App\Model\Person as EntityPerson,
    \App\Model\Contact as EntityContact,
    \App\Interface\IController;

/**
 * Controller da entidade Person
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Person extends Page implements IController
{
    /**
     * @inheritdoc
     * @return EntityPerson
     */
    public static function getModelController()
    {
        return new EntityPerson();
    }

    /**
     * Retorna a tela de consulta de pessoas
     * @return string
     */
    public static function getPagePeople(): string
    {
        $people = self::getModelController()->getAll(EntityPerson::class);
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
            'search'      => null,
            'people'      => $contentPeople
        ]);

        return parent::getPage('Consulta de Pessoas', $content);
    }

    /**
     * Retorna a tela de consulta de Pessoas contendo os registros filtrados
     * @param Request $request
     * @return string
     */
    public static function getSeachPeople($request): string
    {
        $search = $request->getPostVars()['search'];
        if (trim($search) == '') {
            return self::getPagePeople();
        }

        $people = array_filter(array_map(function ($person) use ($search) {
            if (strpos(strtolower($person->getName()), strtolower($search)) !== false) {
                return $person;
            }
        },  self::getModelController()->getAll(EntityPerson::class)));

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
            'people'      => $contentPeople,
            'search'      => $search
        ]);

        return parent::getPage('Consulta de Pessoas', $content);
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
     * Cadastra um novo registro de pessoa
     * @param Request $request
     * @return string
     */
    public static function insertNewPerson(Request $request): string
    {
        $newPerson = new EntityPerson();
        self::loadPersonInformationByRequest($newPerson, $request);
        $newPerson->insertNewRegister($newPerson);

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
    private static function loadPersonInformationByRequest(EntityPerson $person, $request): void
    {
        $postVars = $request->getPostVars();
        $person->setName($postVars['name']);
        $person->setCpf($postVars['cpf']);
    }

    /**
     * Retorna o formulário de edição de pessoas
     * @param int $id
     * @return string
     */
    public static function getEditPerson(int $id): string
    {
        $person = EntityPerson::findRegisterById($id, EntityPerson::class);
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
        $connection    = EntityPerson::getConnection();
        $entityManager = $connection->getEntityManager();
        $person        = $entityManager->getRepository(EntityPerson::class)->find($id);
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

    /**
     * Abre o formulário de visualização da pessoa informada
     * @param int $id
     * @return string
     */
    public static function getDetailsPerson(int $id): string
    {
        $person  = EntityPerson::findRegisterById($id, EntityPerson::class);
        $content = View::render('pages/person/details', [
            'title'       => 'Detalhes da pessoa',
            'description' => 'Abaixo está presente todos os dados de pessoa.',
            'name'        => $person->getName(),
            'cpf'         => $person->getCpf(),
            'path'        => '/pessoas',
            'nameAction'  => 'Retornar a consulta',
        ]);

        return parent::getPage('Visualizar pessoa', $content);
    }

    /**
     * Abre a mensagem de confirmação para a exclusão do registro
     * @param int $id
     * @return string
     */
    public static function getConfirmDeletePerson(int $id): string
    {
        $person  = EntityPerson::findRegisterById($id, EntityPerson::class);
        $contact = EntityPerson::findByCondition(EntityContact::class, 'person', $id);

        $content = $contact
            ? View::render('pages/message', [
                'title'       => 'Você não pode apagar o registro pois ele está associado a um contato!',
                'description' => 'Acesse a consulta de contatos e remova o registro associado antes de excluir esta pessoa. Contato associado: ' .  $contact->getDescription(),
                'bgCard'      => 'bg-warning',
                'path'        => '/pessoas',
                'nameAction'  => 'Acessar Consulta',
            ])
            :  View::render('pages/person/delete', [
                'title'       => 'Você realmente deseja excluir este registro?',
                'description' => "Nome da pessoa que será excluída: {$person->getName()}",
            ]);

        return parent::getPage('Excluir pessoa', $content);
    }

    /**
     * Deleta o registro informado
     * @param int $id
     * @return string
     */
    public static function setConfirmDeletePerson(int $id): string
    {
        EntityPerson::removeRegisterById($id, EntityPerson::class);

        $content = View::render('pages/message', [
            'title'       => 'Registro excluído com sucesso!',
            'description' => 'Acesse a consulta de pessoas para visualizar os demais registros.',
            'bgCard'      => 'bg-success',
            'path'        => '/pessoas',
            'nameAction'  => 'Acessar Consulta',
        ]);

        return parent::getPage('Home', $content);
    }
}
