<?php

namespace App\Controller\Pages;

use \App\Utils\View;

/**
 * Classe abstrata responsável por disponibilizar os métodos comuns aos controladores de páginas
 */
abstract class Page
{
    /**
     * Retorna o header da aplicação
     * @return string 
     */
    public static function getHeader(): string
    {
        return View::render('pages/header');
    }

    /**
     * Retorna o conteúdo da view
     * @param string $title
     * @param string $content
     * @return string 
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render('pages/page', [
            'title'   => $title,
            'header'  => self::getHeader(),
            'content' => $content
        ]);
    }
}
