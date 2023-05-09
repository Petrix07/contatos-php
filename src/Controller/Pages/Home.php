<?php

namespace App\Controller\Pages;

use App\Utils\View;

/**
 * Controller da página inicial da aplicação
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
            'description' => 'Para acessar as rotinas, utilize as ações presentes no cabeçalho do sistema.'
        ]);

        return parent::getPage('Home', $content);
    }
}
