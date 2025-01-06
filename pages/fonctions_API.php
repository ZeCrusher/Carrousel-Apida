<?php

/****************************************************************************
*****                       Compositon du code                          *****
*****************************************************************************
* Copyright (c) 2022 - Serge Tsakiropoulos - Office de Tourisme de Martigues
* Dossier apidae-openajenda
		index.php	<- 
		└── fonction /  fonction_API.php	-> Ce fichier ! 


Note dans la lecture des commentaires : 
// INFO ...> 		=> Informations supplémentaire
// WARNING ...> 	=> Cette ligne/bloc nécéssite un peu de maintenance et/ou d'optimisation
// ATTENTON ...> 	=> Le code est potentiellement dangereux et doit être corrigé au plus vite ! 
// TODO ...> 		=> Modifications à apporter ici ou idée suggérée à faire pour une futur version du code
 


*/


function API_Resource($url_source)
{
	$session = curl_init(); /* initialise une nouvelle session et retourne un identifiant de session cURL à utiliser avec les fonctions curl_setopt(), curl_exec() et curl_close(). */
	curl_setopt($session, CURLOPT_POST, 1);
	curl_setopt($session, CURLOPT_URL, $url_source);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	$result = curl_exec($session);
	if (!$result)	{
		die("Il existe une erreur dans votre URL !! ");
	}
	curl_close($session); /* Fermeture de la session */
	
	return $result; 

}
// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction create_localisation_event($accessToken,$Openagenda_data,$agendaUid)│ Version 1  │ 2022-09-06 │  Stable -  @zecrusher       │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 																															  │
// │	       																								                			  │
// │               					     																	                			  │
// │          																								                			  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function create_localisation_event($accessToken,$Openagenda_data,$agendaUid)
{ 
	$URL = 'https://api.openagenda.com/v2/agendas/'.$agendaUid.'/locations';
	$session = curl_init();
	curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($session, CURLOPT_URL, $URL );
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($session, CURLOPT_POST, true);
	curl_setopt($session, CURLOPT_POSTFIELDS, array(
		'access_token' => $accessToken,
		'nonce' => rand(),
		'data' => json_encode($Openagenda_data)
	));
	$received_content = curl_exec($session);
	return $received_content;
}
// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction create_event( $accessToken, $Openagenda_data, $agendaUid)          │ Version 1  │ 2022-08-30 │  Stable -  @zecrusher       │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 																															  │
// │	       																								                			  │
// │               					     																	                			  │
// │          																								                			  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function create_event( $accessToken, $Openagenda_data, $agendaUid) 
{
  
  	$URL = 'https://api.openagenda.com/v2/agendas/'.$agendaUid.'/events';

	// echo "URL =>".$URL."<br>";
	
	$retour_curl = curl_init();

	curl_setopt($retour_curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($retour_curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt( $retour_curl, CURLOPT_URL, $URL );
	curl_setopt($retour_curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($retour_curl, CURLOPT_POST, true);

	curl_setopt($retour_curl, CURLOPT_POSTFIELDS, array(
		'access_token' => $accessToken,
		'nonce' => rand(),
		'data' => json_encode($Openagenda_data)
	));

	$received_content = curl_exec($retour_curl);
	
	if ($received_content->error!="") { /* En cas d'erreur, arrêt du script avec die !  */
		die("Il existe une erreur  ['".$result_loc->error."']");
	}
	write_to_console("- Début de la fonction create_event de EVENT --------------------------------------------------------------------------------------------------------------");
	write_to_console("Create_event >".$received_content);
	write_to_console("- return de EVENT--------------------------------------------------------------------------------------------------------------");
	
	return $received_content;
	
}

// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction update_event($accessToken,$Openagenda_data,$agendaUid,$eventUid)   │ Version 1  │ 2022-08-30 │  Stable -  @zecrusher       │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 																															  │
// │	       																								                			  │
// │               					     																	                			  │
// │          																								                			  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function update_event($accessToken,$Openagenda_data,$agendaUid,$eventUid) 
{
  
  	$URL = 'https://api.openagenda.com/v2/agendas/'.$agendaUid.'/events/'.$eventUid;
	

	write_to_console("URL_update_event >".$URL);
	write_to_console("id à MAJ >".$eventUid);
	
	$retour_curl = curl_init();

	echo "Retour_curl >".$retour_curl."<br>";

	curl_setopt($retour_curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($retour_curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($retour_curl, CURLOPT_URL, $URL );
	curl_setopt($retour_curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($retour_curl, CURLOPT_POST, true);

	curl_setopt($retour_curl, CURLOPT_POSTFIELDS, array(
		'eventUid' 		=>	$eventUid,
		'access_token' 	=> 	$accessToken,
		'nonce' 		=> 	rand(),
		'data' 			=> 	json_encode($Openagenda_data)
	));

	$received_content = curl_exec($retour_curl);
	
	if ($received_content->error!="") { /* En cas d'erreur, arrêt du script avec die !  */
		die("Il existe une erreur  ['".$result_loc->error."']");
	}
	// ecrire_data($received_content);
	
	return $received_content;
}
// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction access_token_get($secret)  										 │ Version 1  │ 2022-09-01 │  Stable -  @zecrusher        │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 	Votre clé secrète sera mise à disposition sur votre compte OA sur demande à support@openagenda.com						  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function access_token_get($secret)
{
  $Url_AccessToken =  'https://api.openagenda.com/v2/requestAccessToken';

  $retour_curl = curl_init(); /* Initialise une session cURL */ 

	/* Initialise une nouvelle session et retourne un identifiant de session cURL à utiliser avec les fonction */
    curl_setopt($retour_curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($retour_curl, CURLOPT_SSL_VERIFYPEER, 0);

	curl_setopt( $retour_curl, CURLOPT_URL, $Url_AccessToken );
	curl_setopt($retour_curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($retour_curl, CURLOPT_POST, true);

	curl_setopt($retour_curl, CURLOPT_POSTFIELDS, array(
		'grant_type' => 'authorization_code',
		'code' => $secret
	));

  $received_content = curl_exec($retour_curl);
  write_to_console("Fonction access_token_get ".$received_content);
  $access_token = json_decode( $received_content, true )["access_token"];

  return $access_token;
}
// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction write_to_console($data)  						 					 │ Version 1  │ 2022-08-30 │  Stable -  @zecrusher        │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 	Affiche dans la console les données pour pouvoir faire un débugage														  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function write_to_console($data) 
{
	$var_dans_console = $data;
		if (is_array($var_dans_console))	{
			$var_dans_console = implode(',', $var_dans_console);
		}
	echo "<script>console.log('Console: " . $var_dans_console . "' );</script>";

}

// ┌─────────────────────────────────────────────────────────────────────────────┬────────────┬────────────┬──────────────────────────────┐
// │ Fonction ecrire_data($data)  						 						 │ Version 1  │ 2022-08-30 │  Stable -  @zecrusher        │
// ├─────────────────────────────────────────────────────────────────────────────┴────────────┴────────────┴──────────────────────────────┤
// │	note : 	Création d'un fichier texte api.txt. Vous pouvez ainsi ajouter le résultat de vos requêtes.								  │
// └──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 
function ecrire_data($data)
{
	$fp = fopen ("api.txt", "a+");
	fwrite ($fp, " ".$data."".PHP_EOL);
	fclose ($fp);
} 

?>