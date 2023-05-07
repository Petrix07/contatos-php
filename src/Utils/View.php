<?php

namespace App\Utils;

/**
 * Arquivo destinado a renderização de telas
 */
class View
{
    /**
     * Retorna o conteúdo de uma view
     * @param string $sView
     * @return string
     */
    private static function getContentView($sView): string
    {
        $sFile = __DIR__ . "/../../resources/view/$sView.html";
        return file_exists($sFile) ? file_get_contents($sFile) : '<h1> Página não encontrada</h1>';
    }

    /**
     * Retorna o conteúdo renderizado de uma view
     * @param string $sView
     * @param array $aVars
     * @return string
     */
    public static function render($sView, array $aVars = []): string
    {

        $aKeys = array_keys($aVars);
        $aKeys = array_map(function($sItem) {
            return '{{' . $sItem . '}}';
        }, $aKeys);

        $sContentView = self::getContentView($sView);

        return str_replace($aKeys, array_values($aVars), $sContentView);
    }
}
