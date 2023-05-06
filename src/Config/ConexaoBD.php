<?php

namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/Pessoa.php';

use \Doctrine\DBAL\Configuration,
    \Doctrine\DBAL\DriverManager,
    \Doctrine\DBAL\Schema\Table,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\Setup;

/**
 * Classe responsável por criar a conexão com o banco de dados 
 * @author - Luiz Fernando Petris
 * @since - 05/04/2023
 */
class ConexaoBD
{
    private $Conexao;
    private $DatabasePlataform;
    private $SchemaManager;

    public function __construct()
    {
        $this->criaConexao();
        $this->criaDatabasePlatform();
        $this->criaSchemaManager();
        $this->criaTabelasSistema();
    }

    public function getEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), true, null, null, false);
        $entityManager = EntityManager::create($this->Conexao, $config);

        return $entityManager;
    }

    /**
     * Cria a conexão com o banco de dados, salvando o objeto Connection retornado no atributo "Conexao"
     */
    private function criaConexao(): void
    {
        $oConfig   = new Configuration();
        $aDbParams = $this->getConfiguracoesBanco();
        $this->Conexao = DriverManager::getConnection($aDbParams, $oConfig);
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
        $this->DatabasePlataform = $this->Conexao->getDatabasePlatform();
    }

    /**
     * Cria o objeto SchemaManager
     */
    private function criaSchemaManager(): void
    {
        $this->SchemaManager = $this->Conexao->createSchemaManager();
    }

    /**
     * Cria as tabelas utilizadas pela aplicação
     */
    private function criaTabelasSistema()
    {
        if (!$this->SchemaManager->tablesExist('pessoa')) {
            $this->criaTabelaPessoa();
        }
    }

    /**
     * Cria a tabela para a entidade "Pessoa"
     */
    private function criaTabelaPessoa()
    {
        $oTabela = new Table('pessoa');
        $oTabela->addColumn('id',   'integer', ['unsigned' => true, 'autoincrement' => true]);
        $oTabela->addColumn('nome', 'string',  ['length'   => 255]);
        $oTabela->addColumn('cpf',  'string',  ['length'   => 14]);
        $oTabela->addUniqueIndex(array('cpf'));
        $oTabela->setPrimaryKey(['id']);
        $aSqls = $this->DatabasePlataform->getCreateTableSQL($oTabela);
        foreach ($aSqls as $sSql) {
            $this->Conexao->executeStatement($sSql);
        }
    }
}
