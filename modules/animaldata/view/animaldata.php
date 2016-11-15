<?php

namespace TrabalhoG2;

/**
* View for highlight_home module. 	
*/
class ViewAnimalData
{
	public function display($templateName)
	{
		include 'templates' . "\\" . $templateName . '.php'; 
	}
}

?>