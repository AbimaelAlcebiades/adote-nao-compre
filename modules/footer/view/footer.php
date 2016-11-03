<?php

namespace TrabalhoG2;

/**
* View for footer module. 	
*/
class ViewFooter
{
	public function display($templateName)
	{
		include 'templates' . "\\" . $templateName . '.php'; 
	}
}

?>