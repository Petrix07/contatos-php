<?php

namespace App\Http;

/**
 * Classe Request
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Request
{

    /**
     * Método HTTP da requisição
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     * @var string
     */
    private $uri;

    /**
     * Parâmetros da URI ($_GET)
     * @var array
     */
    private $queryParams = [];

    /**
     * Variáveis recebidas pelo POST da requisição
     * @var array
     */
    private $postVars = [];

    /**
     * Cabeçalho da requisição
     * @var array
     */
    private $headers = [];

    /**
     * Construtor da classe
     */
    public function __construct()
    {
        $this->queryParams = $_GET  ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri         = $_SERVER['REQUEST_URI']    ?? '';
    }

    /**
     * Get cabeçalho da requisição
     * @return  array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get variáveis recebidas pelo POST da requisição
     *
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }

    /**
     * Get parâmetros da URI ($_GET)
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Get URI da página
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get método HTTP da requisição
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }
}
