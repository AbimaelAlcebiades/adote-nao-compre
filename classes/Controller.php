<?php

namespace TrabalhoG2;

/**
* Interface for controllers.
*/
interface Controller
{

	// Define constantes.
	const PATH_VIEW 	= MODULES_PATH . "moduleName" . "\\view\\";
	const PATH_MODEL 	= MODULES_PATH . "moduleName" . "\\model\\";
	const PATH_ASSET 	= "modules\\moduleName\\asset\\";

	/**
	 * Implementação para renderizar um módulo.
	 * @param string $viewName Nome da view.
	 * @param string $templateName Nome do template.
	 */
	public function toRender($viewName, $templateName);
}

?>