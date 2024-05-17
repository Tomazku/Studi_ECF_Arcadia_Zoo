<?php

	if(!empty($_POST['typeForm'])){
		
		if($_POST['typeForm'] == "incrementation"){
		
			$nameAnimal = $_POST['nameAnimal'];
				
			$uri_Json = "/noSQL";
			$file_Json = "nview_animal.json";
			
			// on lit l'incrementation en cours
			$file_content = file_get_contents($uri_Json . $file_Json); 						
			// decodage du Json en Array
			$arr_content = json_decode($file_content, true);
			
			// incrementation de la visite de l'animal
			if(!empty($arr_content[$nameAnimal])){
				$arr_content[$nameAnimal] = $arr_content[$nameAnimal]+1;
			}else{
				$arr_content[$nameAnimal] = 1;
			}
			
			// Encodage de l'Array en Json
			$new_content = json_encode($arr_content);
			
			// on ecrit la nouvelle incrementation dans le fichier
			$file_content = file_put_contents($uri_Json . $file_Json, $new_content, LOCK_EX);
			
			// on lit la nouvelle incrementation du fichier
			$file_content_new = file_get_contents($uri_Json . $file_Json); 
			$arr_content_new = json_decode($file_content_new, true);

			// on retour le resulat
			print $arr_content_new[$nameAnimal] . " fois";
		
		}

		
	}else{
		header("location:index.php", 301);
	}

?>