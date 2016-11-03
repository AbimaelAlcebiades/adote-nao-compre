<?php

namespace TrabalhoG2;

/**
* View for login module. 	
*/
class ViewLogin
{
	public function display($templateName)
	{
		include 'templates' . "\\" . $templateName . '.php'; 
	}
}

?>