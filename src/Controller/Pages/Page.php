<?php

namespace App\Controller\Pages;

use \App\Utils\View;

abstract class Page
{

    /**
     * Retorna o header da aplicação
     */
    public static function getHeader(): string {
        return View::render('pages/header');
    }

    /**
     * Retorna o conteúdo da view
     */
    public static function getPage(string $sTitle, string $sContent): string {
        return View::render('pages/page', [
            'title'   => $sTitle,
            'header'  => self::getHeader(),
            'content' => $sContent
        ]);
    }
}
