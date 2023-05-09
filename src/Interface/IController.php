<?php

namespace App\Interface;

/**
 * Interface para os Controller do sistema
 * @author - Luiz Fernando Petris
 * @since - 08/05/2023
 */
interface IController
{
    /**
     * Retorna o modelo utilizado pela classe controladora
     */
    public static function getModelController();
}
