<?php

namespace App\Controller\Pages;

use \App\Utils\View,
    \App\Config\ConnectionBD;

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

    /**
     * Retorna um objeto de conexão com o banco de dados
     * @return ConnectionBD
     */
    protected static function getConnection(): ConnectionBD
    {
        return new ConnectionBD();
    }
}
