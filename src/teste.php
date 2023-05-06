<?php

namespace App;

# require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\ConexaoBD,
    App\Model\Pessoa;

$c = new ConexaoBD();


//EntityManager do Doctrine
$entityManager = $c->getEntityManager();

//repositório para a entidade desejada
$pessoaRepository = $entityManager->getRepository(Pessoa::class);

//findAll() para buscar todos os registros da tabela
$pessoas = $pessoaRepository->findAll();

// Agora, você pode iterar sobre os pessoas e fazer o que quiser com eles
foreach ($pessoas as $pessoa) {
    echo  var_dump($pessoa);
}
