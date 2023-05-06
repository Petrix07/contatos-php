<?php

/**
 * Função global responsável por definir qual página deve ser renderizada
 */
function render($sPage)
{
    switch ($sPage) {
        case 'home':
           // return (new App\Controller\ControllerHome)->render();
        case 'pessoa':
          #  return (new App\Controller\ControllerConsultaPessoa)->render();
        case 'contato':
          #  return (new App\Controller\ControllerConsultaContato)->render();
          default:
        #   return (new App\Controller\ControllerPageNotFound)->render();
    }

}