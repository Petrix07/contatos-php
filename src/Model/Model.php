<?php

namespace App\Model;

use \App\Config\ConnectionBD;

/**
 * Clase base de modelos
 */
abstract class Model
{

    /**
     * Retorna um objeto de conexão com o banco de dados
     * @return ConnectionBD
     */
    public static function getConnection(): ConnectionBD
    {
        return new ConnectionBD();
    }

    /**
     * Retorna todas as registros cadastradas
     * @return array
     */
    public function getAll($class): array
    {
        $connection    = $this->getConnection();
        $entityManager = $connection->getEntityManager();
        $repo          = $entityManager->getRepository($class);

        return $repo->findAll();
    }

    /**
     * Insere o registro informado
     * @param $register
     */
    public function insertNewRegister($register): void
    {
        $connectiononnection = $this->getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $entityManager->persist($register);
        $entityManager->flush();
    }

    /**
     * Retorna a registro que possui o ID informado
     * @param int $id
     * @return object
     */
    public static function findRegisterById(int $id, $class)
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();

        return $entityManager->getRepository($class)->find($id);
    }

    /**
     * Persiste o objeto informado
     * @param object $obj
     */
    public static function persist($obj): void
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $entityManager->persist($obj);
    }

    /**
     * Remove o registro pela chave
     * @param int $id
     * @param $class
     */
    public static function removeRegisterById(int $id, $class): void
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        $entityManager->remove($entityManager->getRepository($class)->find($id));
        $entityManager->flush();
    }

    /**
     * Busca um registro com base em uma condição
     * @param $class
     * @param string $name
     * @param string $value
     * @return obj
     */
    public static function findByCondition($class, string $name, string $value)
    {
        $connection    = self::getConnection();
        $entityManager = $connection->getEntityManager();
        return $entityManager->getRepository($class)->findOneBy([$name => $value]);
    }
}
