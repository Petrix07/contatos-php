<?php

namespace App\Config;

use \Doctrine\DBAL\Configuration,
    \Doctrine\DBAL\DriverManager,
    \Doctrine\DBAL\Schema\Table,
    \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Tools\Setup;

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
        $this->criaDatabasePlatform();
        $this->createSchemaManager();
        $this->createTabelasSistema();
    }

    public function getEntityManager()
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
        $dbParams        = $this->getConfiguracoesBanco();
        $this->Connection = DriverManager::getConnection($dbParams, $conf);
    }

    /**
     * Retorna um array contendo as informações de configuração para a conexão com o banco de dados
     */
    private function getConfiguracoesBanco(): array
    {
        return [
            'driver'   => 'pdo_pgsql',
            'host'     => 'localhost',
            'port'     => '5432',
            'user'     => 'postgres',
            'password' => 'aluno',
            'dbname'   => 'contatos_php',
        ];
    }

    /**
     * Cria o objeto DataBasePlatform
     */
    private function criaDatabasePlatform(): void
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
    private function createTabelasSistema()
    {
        if (!$this->SchemaManager->tablesExist('person')) {
            $this->createTablePerson();
        }
    }

    /**
     * Cria a tabela para a entidade "Pessoa"
     */
    private function createTablePerson()
    {
        $table = new Table('person');
        $table->addColumn('id',   'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('name', 'string',  ['length'   => 255]);
        $table->addColumn('cpf',  'string',  ['length'   => 14]);
        $table->addUniqueIndex(array('cpf'));
        $table->setPrimaryKey(['id']);
        $sqls = $this->DatabasePlataform->getCreateTableSQL($table);
        foreach ($sqls as $sql) {
            $this->Connection->executeStatement($sql);
        }
    }
}
