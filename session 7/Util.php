<?php
/* Static methods */

class Util {

	public static $var = "My Var";

	public function __construct() {
		/* So much logic implemented here ... */
	}

	public static function calculate($x, $y) {
		return $x * $y;
	}

	public function show100() {
		echo "Calculated value: " . self::calculate(10, 10); // Статично извикване на метод в обекта, в който е дефиниран
	}
}

$util = new Util(); // Инстанциране на Util обект

echo $util->show100(); // Извикване на инстанциран метдо не статично
echo "<hr/>";
echo Util::$var; // Достъпване на статичен параметър, забележете $ - за разлика от инстанцитаното достъпване. Статичните параметри не могата да се достъпват не статично.
echo "<hr/>";
echo $util->calculate(5, 6); // За разлика от статичните методи.
echo "<hr/>";
echo Util::calculate(3, 4); // Извикване на статичен метод без инстанция класа. Това работи 30% по-бързо от инстанцираното извикване.
echo "<hr/>";
var_dump($util);