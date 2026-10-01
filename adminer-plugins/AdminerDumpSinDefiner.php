<?php

/** Omite la cláusula DEFINER de vistas, rutinas y eventos al exportar
* Adminer solo la quita si es la cuenta conectada; con la casilla marcada se quita siempre.
* El filtro se abre en dumpDatabase(), por dentro de la compresión de dump-zip y dump-bz2,
* así que trabaja sobre el SQL en texto plano.
*/
class AdminerDumpSinDefiner extends Adminer\Plugin {
	private $activo = false;
	private $resto = "";

	function dumpPrint() {
		echo "<p><label><input type='checkbox' name='omitir_definer' value='1' checked> Omitir DEFINER</label>\n";
		return null;
	}

	function dumpDatabase($db) {
		if (!empty($_POST["omitir_definer"]) && !$this->activo) {
			ob_start(array($this, 'filtrar'));
			$this->activo = true;
		}
		return null;
	}

	/** Manejador de ob_start: procesa solo líneas completas y guarda el resto para el siguiente trozo */
	function filtrar(string $buffer, int $phase): string {
		$texto = $this->resto . $buffer;
		if ($phase & PHP_OUTPUT_HANDLER_FINAL) {
			$this->resto = "";
			return self::quitarDefiner($texto);
		}
		$corte = strrpos($texto, "\n");
		if ($corte === false) {
			$this->resto = $texto;
			return "";
		}
		$this->resto = substr($texto, $corte + 1);
		return self::quitarDefiner(substr($texto, 0, $corte + 1));
	}

	/** Quita DEFINER=usuario@host de las sentencias CREATE que empiezan una línea */
	static function quitarDefiner(string $sql): string {
		$nombre = "(?:`(?:[^`]|``)*`|'(?:[^'\\\\]|\\\\.)*'";
		return preg_replace(
			"~^(CREATE(?:\\s+OR\\s+REPLACE)?(?:\\s+ALGORITHM\\s*=\\s*\\w+)?)\\s+DEFINER\\s*=\\s*$nombre|[^\\s@]+)@$nombre|\\S+)~m",
			'$1',
			$sql
		);
	}
}
