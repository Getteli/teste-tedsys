<?php

namespace App\Enum;

/**
 * Classe abstrata enumeration usada para verificar o status de diversas classes
 */
abstract class Status
{
	const NaoFeito = 0;
	const Feito = 1;

	const Inativo = 0;
	const Ativo = 1;
}