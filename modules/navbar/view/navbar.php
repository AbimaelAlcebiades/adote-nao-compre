<?php

namespace TrabalhoG2;

/**
* View for navbar module. 	
*/
class ViewNavbar
{
	public function display($templateName)
	{
		include 'templates' . "\\" . $templateName . '.php'; 
	}
}

?>