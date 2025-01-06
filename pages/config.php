<?php
	session_start();

	$_SESSION['last_version'] ="2025-01-06-TSK"; 

        /* Les clés API permettent de lire et écrire des données sur OpenAgenda via l'API. */
	$keys = array(
	  "public"=>"laclefpublic84442a87432cf0f94c93a", /* Pour OpenAgenda en lecture */
	  "secret"=>"maclefsecrete4d6c8c849fb1f0223f4e"  /* Pour OpenAgenda en mode écriture et autres*/
	);

	$agendaUid=65630513; /* <uid:65630513> */
	// 	 $territoireIds=array("5693912"); /* Conseil de territoire : Pays de Martigues */ 
	//	 $selectionIds=array("133484");

	$selectionIds=array("130723","133484","138205"); 
	
	$data_openagenda =array(); /* tableau qui va temporairement sauvegarder les données lu sur OpenAgenda 	*/
	$data_apidae	 =array(); /* tableau qui va également sauvegarder les données d'Apidae 				*/


	// $apiDomain = "https://api.apidae-tourisme.com/api/"; <- sans le httpS - il y a une erreur dans la console.
	
	$apiDomain = "http://api.apidae-tourisme.com/api/";
	
	$apiKey="xxxxxx"; /* xxxxxx <- OK | xxxxxx */
	$projetId="6775"; /*  	6556 Martigues - OpenAgenda */ 
	$nbResult = '5000';
	// $dureemax = "50";

	$requete = array();
	// $requete['territoireIds'] = $territoireIds;
	$requete['selectionIds'] = $selectionIds;
	$requete['identifiants'] = $identifiants;
	$requete['apiKey'] = $apiKey;
	
	$requete['count']= "1000";
	
	$requete['projetId'] = $projetId;
	// $requete['dateDebut'] = date("Y-m-d");   
	$requete['dateDebut']="2023-01-01";

//	$requete["responseFields"] = array("@all");
	// $requete["responseFields"] = array("@default");

 
	 $requete["responseFields"] = array("id",
										"nom",
										"theme",
										"localisation",
										"descriptionTarif",
										"presentation",
										"reservation",
										"prestations",
										"illustrations",
										"aspects",
										"informations",
										"datesOuverture",
										"ouverture",
										"@informationsObjetTouristique");

	
	$url_Apidae = $apiDomain."v002/agenda/detaille/list-objets-touristiques/";

	$url_Apidae .= '?';
	$url_Apidae .= 'query='.urlencode(json_encode($requete));

	$url_OpenAgenda="https://openagenda.com/agendas/".$agendaUid."/events.v2.json?key=".$keys['public'];
	
	$department		= 	"Bouches-du-Rhône";
	$timezone		=	"Europe/Paris";
	$countryCode 	= 	"FR";
	
?>
