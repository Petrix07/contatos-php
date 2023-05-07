<?php

namespace App\Controller\Pages;

use App\Utils\View;

/**
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Sobre extends Page
{

    public static function getHome(): string
    {
        $sContent = View::render('pages/home', [
            'title'       => 'Bem vindo!',
            'description' => 'Página SOBRE da aplicação'
        ]);

        return parent::getPage('Home', $sContent);
    }
}