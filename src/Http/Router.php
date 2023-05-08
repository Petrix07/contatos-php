<?php

namespace App\Http;

use \Closure,
    \Exception,
    \Throwable,
    \ReflectionFunction,
    \App\Http\Response;

/**
 * Classe Router
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Router
{

    /**
     * URL completa do projeto (raíz)
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instância de Request
     * @var Request
     */
    private $request;

    /**
     * Construtor da classe
     * @param string url
     */
    public function __construct(string $url)
    {
        $this->request = new Request();
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * Define o prefixo das rotas
     */
    private function setPrefix(): void
    {
        $parseUrl     = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Adiciona uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     * @return array
     */
    public function addRoute(string $method, string $route, $params = []): array
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];
        /* Padrão de validação das variáveis presentes nas rotas */
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        /* Padrão de validação da IRL */
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        return $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Define uma rota de GET
     * @param string $route
     * @param array $param
     * @return array
     */
    public function get(string $route, $params = []): array
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Define uma rota de POST
     * @param string $route
     * @param array $param
     */
    public function post(string $route, $param = []): array
    {
        return $this->addRoute('POST', $route, $param);
    }

    /**
     * Define uma rota de PUT
     * @param string $route
     * @param array $param
     * @return array
     */
    public function put(string $route, $param = []): array
    {
        return $this->addRoute('PUT', $route, $param);
    }

    /**
     * Define uma rota de DELETE
     * @param string $route
     * @param array $param
     * @return array
     */
    public function delete(string $route, $param = []): array
    {
        return $this->addRoute('DELETE', $route, $param);
    }

    /**
     * Retorna a URI desconsiderando o prefixo
     * @return string 
     */
    private function getUri(): string
    {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        
        return end($xUri);
    }

    /**
     * Retorna os dados da rota atual
     * @return array
     */
    private function getRoute(): array
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri, $matches)) {
                if (isset($methods[$httpMethod])) {
                    unset($matches[0]);
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables']            = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];
                }
                throw new Exception("Método não permitido", 405);
            }
        }
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Executa a rota atual
     * @tutorial - Emite excessõs caso o caminho informado não possua um controlador respectivo
     * @return Response | Exception
     */
    public function run()
    {
        try {
            $route = $this->getRoute();
            if (!isset($route['controller'])) {
                throw new Exception("URL não pôde ser processada.", 500);
            }

            $args       = [];
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name        = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            return call_user_func_array($route['controller'], $args);
        } catch (Throwable $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
