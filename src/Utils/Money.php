<?php

namespace Contributte\GopayInline\Utils;

final class Money
{

	/**
	 * @param float $amout
	 * @return int
	 */
	public static function toCents($amout)
	{
		return (int) ((string) round($amout * 100));
	}

}
