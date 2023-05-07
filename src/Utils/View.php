<?php

namespace App\Utils;

/**
 * Arquivo destinado a renderização de telas
 */
class View
{

    /**
     * Variáveis padrões da View
     * @var array
     */
    private static $vars = [];

    /**
     * Defini os dados da classe
     * @param array $vars
     */
    public static function init($vars = []) {
        self::$vars = $vars;
    }

    /**
     * Retorna o conteúdo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView(string $view): string
    {
        $file = __DIR__ . "/../../resources/view/$view.html";
        return file_exists($file) ? file_get_contents($file) : '<h1> Página não encontrada</h1>';
    }

    /**
     * Retorna o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars
     * @return string
     */
    public static function render($view, array $vars = []): string
    {
        $content = self::getContentView($view);
        $vars    = array_merge(self::$vars, $vars);
        $keys    = array_keys($vars);
        $keys    = array_map(function($sItem) {
            return '{{' . $sItem . '}}';
        }, $keys);


        return str_replace($keys, array_values($vars), $content);
    }
}
