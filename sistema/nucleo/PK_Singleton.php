<?php
namespace sistema\nucleo;
trait PK_Singleton
{
	private static $instancia;
	public static function obt_instancia()
	{
		if (!self::$instancia instanceof self) {
			seguir('instanciando '.__CLASS__);
			self::$instancia = new self();
		}
		return self::$instancia;
	}
	public function __clone()
	{
		exit(mostrar_error('PK_Singleton','Clone no se permite en '.__CLASS__));
	}
}