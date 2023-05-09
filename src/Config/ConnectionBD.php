<?php

namespace App\Config;

use \Doctrine\DBAL\Configuration,
    \Doctrine\DBAL\DriverManager,
    \Doctrine\DBAL\Schema\Table,
    \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\Entity;

/**
 * Classe responsável por criar a conexão com o banco de dados 
 * @author - Luiz Fernando Petris
 * @since - 05/04/2023
 */
class ConnectionBD
{
    private $Connection;
    private $DatabasePlataform;
    private $SchemaManager;

    public function __construct()
    {
        $this->createConnection();
        $this->createDatabasePlatform();
        $this->createSchemaManager();
        $this->createTabelasSistema();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), true, null, null, false);
        $entityManager = EntityManager::create($this->Connection, $config);

        return $entityManager;
    }

    /**
     * Cria a conexão com o banco de dados, salvando o objeto Connection retornado no atributo "Connection"
     */
    private function createConnection(): void
    {
        $conf             = new Configuration();
        $dbParams         = $this->getConfiguracoesBanco();
        $this->Connection = DriverManager::getConnection($dbParams, $conf);
    }

    /**
     * Retorna um array contendo as informações de configuração para a conexão com o banco de dados
     */
    private function getConfiguracoesBanco(): array
    {
        return [
            'driver'   => getenv('DB_DRIV'),
            'host'     => getenv('DB_HOST'),
            'port'     => getenv('DB_PORT'),
            'user'     => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'dbname'   => getenv('DB_NAME'),
        ];
    }

    /**
     * Cria o objeto DataBasePlatform
     */
    private function createDatabasePlatform(): void
    {
        $this->DatabasePlataform = $this->Connection->getDatabasePlatform();
    }

    /**
     * Cria o objeto SchemaManager
     */
    private function createSchemaManager(): void
    {
        $this->SchemaManager = $this->Connection->createSchemaManager();
    }

    /**
     * Cria as tabelas utilizadas pela aplicação
     */
    private function createTabelasSistema(): void
    {
        if (!$this->SchemaManager->tablesExist('person')) {
            $this->createTablePerson();
        }
        if (!$this->SchemaManager->tablesExist('contact')) {
            $this->createTableContact();
        }
    }

    /**
     * Cria a tabela para a entidade "Person"
     */
    private function createTablePerson(): void
    {
        $table = new Table('person');
        $table->addColumn('id',   'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('name', 'string',  ['length'   => 255]);
        $table->addColumn('cpf',  'string',  ['length'   => 14]);
        $table->setPrimaryKey(['id']);
        $sqls = $this->DatabasePlataform->getCreateTableSQL($table);
        foreach ($sqls as $sql) {
            $this->Connection->executeStatement($sql);
        }
    }

    /**
     * Cria a tabela para a entidade "Contact"
     */
    private function createTableContact(): void
    {
        $table = new Table('contact');
        $table->addColumn('id',          'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('type',        'integer');
        $table->addColumn('description', 'string',  ['length'   => 255]);
        $table->addColumn('person_id',   'integer', ['unsigned' => true]);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('person', ['person_id'], ['id'], ['onDelete' => 'CASCADE']);
        $sqls = $this->DatabasePlataform->getCreateTableSQL($table);
        foreach ($sqls as $sql) {
            $this->Connection->executeStatement($sql);
        }
    }
}
