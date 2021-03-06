<?php
namespace Popov\ZfcCore\Filter;

use Zend\Filter\AbstractFilter;

class Translit extends AbstractFilter
{
	/**
	 * @param string $value
	 * @return string
	 */
	public function filter($value)
	{
		$letters = array(
			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e",
			"ё" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
			"л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
			"с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c",
			"ч" => "ch", "ш" => "sh", "щ" => "sh", "ы" => "i", "ь" => "", "ъ" => "",
			"э" => "e", "ю" => "yu", "я" => "ya",
			"А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E",
			"Ё" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K",
			"Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
			"С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
			"Ч" => "CH", "Ш" => "SH", "Щ" => "SH", "Ы" => "I", "Ь" => "", "Ъ" => "",
			"Э" => "E", "Ю" => "YU", "Я" => "YA",

		);

		foreach($letters as $letterVal => $letterKey) {
			$value = str_replace($letterVal, $letterKey, $value);
		}

		return $value;
	}
}