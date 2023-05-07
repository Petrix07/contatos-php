<?php

namespace App\Controller\Pages;

use App\Utils\View;

/**
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Home extends Page
{

    /**
     * Retorna a página de Home
     * @return string 
     */
    public static function getHome(): string
    {
        $content = View::render('pages/home', [
            'title'       => 'Bem vindo!',
            'description' => 'Página inicial da aplicação'
        ]);

        return parent::getPage('Home', $content);
    }
}
