<?php

namespace App\Controller\Pages;

use App\Utils\View;

/**
 * Controller para a entidade Contato
 * @author - Luiz Fernando Petris
 * @since - 06/05/2023
 */
class Contact extends Page
{

    
    public static function getPageContacts(): string
    {
        $sContent = View::render('pages/home', [
            'title'       => 'Consulta de Contatos',
            'description' => 'Página de Contato da aplicação'
        ]);

        return parent::getPage('Home', $sContent);
    }
}
