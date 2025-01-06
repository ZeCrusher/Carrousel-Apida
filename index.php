<?php //On demarre les sessions
session_start();

// *****************************************************************************
// *****                       Historique des versions                     *****
// *****************************************************************************
// Copyright (c) 2023 - Serge Tsakiropoulos - Office de Tourisme de Martigues



	// if (!isset($_SESSION['login'])) { /* les agents sont connectés */
		// header ('Location: signin.php');
		// exit();
	// }
	
    // include "pages/connexion.php"; 	/* Fonction pour connexion et récupération des datas */
    // include "pages/fonction.php"; 	/* Fonction pour l'Extranet uniquement */
	
	include "pages/config.php";
	include "pages/fonctions_API.php";
	
	
	
	$boucle=0; /* gestion d'affichage */
	
	$accessToken = access_token_get($keys['secret']);

	$results_API = API_Resource($url_Apidae);
	$results = json_decode($results_API,false);

	// $results_OpenAgenda = API_Resource($url_OpenAgenda);
	// $results_OA = json_decode($results_OpenAgenda,false);
	
	//  65550273 <- Martigues Bouge
	
	// $route = "https://openagenda.com/agendas/".$agendaUid."/events.v2.json?key=".$keys['public'];

	// echo "Route : ".$route."<br>";
	
	$nbmanif=$results->numFound; 

	$retobjetsTouristiques = $results->objetsTouristiques;

	// $obj = json_decode(file_get_contents($route), false);
	// $openagenda_nb_event=$obj->total;
	
	$sizeapidae=0;

	foreach($retobjetsTouristiques as $fiche=>$lesdates)	
	{
		foreach ($lesdates as $retourfiche)	
		{
			$data_apidae[$sizeapidae]=$retourfiche->nom->libelleFr;
			$lecture_arr_id[$sizeapidae]=$retourfiche->id;
			$sizeapidae++;
		}
	}
	$arr_id=array_unique($lecture_arr_id);

	$sizeopenagenda=0;
	do 	{
		
		$data_openagenda	[$sizeopenagenda]=$obj->events[$sizeopenagenda]->title->fr;
		$data_openagenda_uid[$sizeopenagenda]=$obj->events[$sizeopenagenda]->uid;
		$data_openagenda_loc[$sizeopenagenda]=$obj->events[$sizeopenagenda]->location->uid;		
	// echo $data_openagenda_loc[$sizeopenagenda]." ** <br>";
	} 
	while ($obj->events[++$sizeopenagenda]->title->fr!="");
	
	$unique_data_openagenda				= array_unique($data_openagenda);
	$unique_data_openagenda_uid			= array_unique($data_openagenda_uid);	
	$unique_data_openagenda_loc			= array_unique($data_openagenda_loc);
		
	$data_update_apid_open 				= array_intersect($unique_data_openagenda, $titre_unique_data_apidae);
	$data_creat_apid_open 				= array_diff($unique_data_openagenda, $titre_unique_data_apidae);
	
	for($i = 0; $i<$sizeapidae; $i++) 	
	{
		if ($titre_unique_data_apidae[$i]!="") 		
		{
			$liste_apidae[$i]=$titre_unique_data_apidae[$i];
		}
	}

	$nb_maj=0;
	$nb_create=0;
	
	for($i = 0;$i<$sizeopenagenda;$i++) 
	{
		if ($unique_data_openagenda[$i]!="") 		
		{ 
			$liste_openagenda[$i]		=$unique_data_openagenda[$i];
			$liste_openagenda_uid[$i]	=$unique_data_openagenda_uid[$i];   /* IUD de l'annonce */
			$liste_openagenda_loc[$i]	=$unique_data_openagenda_loc[$i];	/* IUD de la localisation - IMPORTANT pour la mise à jour ! */
		}
			// echo "ID >".$unique_data_openagenda[$i]." | LOC >".$liste_openagenda_loc[$i]."<br>";
	}
?>	


<!--FONT AWESOME-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="css/anim.css">
<!--GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Ysabeau+Infant:wght@1;100;200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet" />

<!--PLUGIN-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<?php 
	$mois = array('','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
	$icar=0;
?>

<style>
<?php
			$results_API = API_Resource($url_Apidae);
			$results = json_decode($results_API,false);
					
			/* ******************************************************************************************************************************************************************************* */
					
				// $results_OpenAgenda = API_Resource($url_OpenAgenda);
				// $results_OA = json_decode($results_OpenAgenda,false);
				// $route = "https://openagenda.com/agendas/".$agendaUid."/events.v2.json?key=".$keys['public'];

				
				$nbmanif=$results->numFound; 
					if ($nbmanif=="") { 
						echo '<div class="alert alert-danger alert-icon">';
						echo 'ERREUR APIDAE > ';
						echo $results->message; 
						echo ' - Message de retour > ';
						echo $results->errorType.'<i class="icon"></i></div>'; 
						
					}	
					if ($accessToken=="") { 
						echo '<div class="alert alert-danger alert-icon">Erreur sur votre TOKEN OPENAGENDA - Il faut vérifier vos clefs dans le fichier config.php <i class="icon"></i></div>';
					}
		
					
					if ($_GET['test']=="oui") { 
						echo '<div class="alert alert-warning alert-icon">Le mode <b>test</b> de l\'API apparaît lorsque vous testez la création d\'un événement dans OPENAGENDA - Network Test <i class="icon"></i></div>';
					}
							
					// $obj = json_decode(file_get_contents($route), false);
					
					$openagenda_nb_event=$obj->total;	
					$retobjetsTouristiques = $results->objetsTouristiques;
					
					// $openagenda_id_event=$obj->events[0]->uid;	
				
					
					$liste_affichage=0;
					
					foreach($retobjetsTouristiques as $fiche=>$lesdates)
					{
						foreach ($lesdates as $retourfiche) 
						{
							
							if ($retourfiche->id==$arr_id[$liste_affichage]) 
							{	

								$arr_id[$liste_affichage]=""; 		
								$liste_affichage++;	
							
								$json_event_date_ouverture = $retourfiche->ouverture;
								$event_heure_ouverture = array();
								
								$event_tarif=array();
								$event_illustrations=array();

								$nb_tarif=0;
								$nb_periode=0;
								$nb_illustrations=0;
								$modele_commercial	=$retourfiche->descriptionTarif->indicationTarif;		
								$tarifsEnClair		=$retourfiche->descriptionTarif->tarifsEnClair->libelleFr;	
								$event_adresse 		= $retourfiche->localisation;
								$event_adresse = ""; // init l'adresse
					
	/* GESTION DES ADRESSES */	

								if (isset($retourfiche->localisation->adresse->nomDuLieu)) 		{	$event_adresse.= $retourfiche->localisation->adresse->nomDuLieu.", ";	}
								if (isset($retourfiche->localisation->adresse->adresse1)) 		{	$event_adresse.= $retourfiche->localisation->adresse->adresse1.", ";	}
								if (isset($retourfiche->localisation->adresse->adresse2)) 		{	$event_adresse.= $retourfiche->localisation->adresse->adresse2.", ";	}
								if (isset($retourfiche->localisation->adresse->codePostal)) 	{	$event_adresse.= $retourfiche->localisation->adresse->codePostal." ";	}
								if (isset($retourfiche->localisation->adresse->commune->nom))	{	$event_adresse.= $retourfiche->localisation->adresse->commune->nom;		}
								
								if (isset($retourfiche->localisation->adresse->commune->pays->libelleFr))	{
									$event_adresse.=", ".$retourfiche->localisation->adresse->commune->pays->libelleFr." ";
								}
							 
								if ($retourfiche->localisation->geolocalisation->valide=="true") 			
								{
									$geolocalisation_long		=$retourfiche->localisation->geolocalisation->geoJson->coordinates['0'];
									$geolocalisation_lat		=$retourfiche->localisation->geolocalisation->geoJson->coordinates['1'];
									$complement_geolocalisation	=$retourfiche->localisation->geolocalisation->complement->libelleFr;
								}
								
								$nomDuLieu 	= $retourfiche->localisation->adresse->nomDuLieu;
								$codePostal = $retourfiche->localisation->adresse->codePostal;
								$ville		= $retourfiche->localisation->adresse->commune->nom;
								
												
	/* CREATION DE L'ADRESSE */
					
								$Openagenda_event_adresse = array(
									'name' 			=> 	$nomDuLieu,
									'address' 		=> 	$event_adresse,
									'postalCode'	=> 	$codePostal,
									'city'			=> 	$ville,
									'department'	=>	$department,				/* Dans config.php car non présent dans le json d'APIDAE */
									'timezone'		=>	$timezone,					/* config.php */
									'countryCode' 	=>	$countryCode,				/* config.php */
									'latitude'		=> 	$geolocalisation_lat,
									'longitude'		=> 	$geolocalisation_long,
									'test'			=> 	$etat_test
								);

	/*---------------------------------------------------------------
	* Création du lieu dans OPENAGENDA
	*---------------------------------------------------------------*/
					
								if ($_GET['id_create']==$retourfiche->id) {
									ecrire_data(" Dans le if create ".$result_loc);									
									$received_content_id_adresse = create_localisation_event($accessToken,$Openagenda_event_adresse,$agendaUid);
									$result_loc=json_decode($received_content_id_adresse,false);
								}
				
								$result_loc=json_decode($received_content_id_adresse,false);
								// ecrire_data(" result_loc> ".$result_loc);
								
								// if ($result_loc->error!="") { /* En cas d'erreur, arrêt du script avec die !  */
									// die("Il existe une erreur dans la création de la Localisation.  ['".$result_loc->error."']");
								// }
								
								$result_uid_location=$result_loc->location->uid;
								
								

	/* GESTION DES DATES */			
								$nb_date_ouverture=0;
								do 
								{ // 2022-10-26T12:00:00+0200
									/* Recherche des horaires - Ouvertures et fermetures ainsi que la date en cours  */
									$begin			=$json_event_date_ouverture->periodesOuvertures[$nb_date_ouverture]->dateDebut."T".$json_event_date_ouverture->periodesOuvertures[$nb_date_ouverture]->horaireOuverture;
									$end			=$json_event_date_ouverture->periodesOuvertures[$nb_date_ouverture]->dateFin  ."T".$json_event_date_ouverture->periodesOuvertures[$nb_date_ouverture]->horaireFermeture;
									$date_ouverture	=$json_event_date_ouverture->periodesOuvertures[$nb_date_ouverture]->dateDebut;
									

	/* GESTION DES ERREURS DE DATE */	
									sscanf($begin, 	"%4s-%2s-%2sT%2s:%2s:%2s"	,$annee_begin	, $mois_begin	, $jour_begin	, $heure_begin	, $minute_begin	, $seconde_begin);
									sscanf($end, 	"%4s-%2s-%2sT%2s:%2s:%2s"	, $annee_end	, $mois_end		, $jour_end		, $heure_end	, $minute_end	, $seconde_end);
									
									if ($jour_begin!=$jour_end)  {
										$erreur_jour_different_id[$nb_date_ouverture]="OUI";
										$erreur_jour_different_begin[$nb_date_ouverture]=$begin;
										$erreur_jour_different="OUI";
										$end=$annee_end.'-'.$mois_end.'-'.$jour_begin.'T'.$heure_end.':'.$minute_end.':'.$seconde_end;
									}
									
									if ($mois_begin!=$mois_end)  {
										$erreur_mois_different_id[$nb_date_ouverture]="OUI";
										$erreur_mois_different_end[$nb_date_ouverture]=$end; /* AVANT LA CORRECTION */
										$erreur_mois_different="OUI";
										$end=$annee_end.'-'.$mois_begin.'-'.$jour_end.'T'.$heure_end.':'.$minute_end.':'.$seconde_end;
									}
									
									$event_heure_ouverture[] = array('begin' => $begin."+0200", 'end' => $end."+0200");
								} 
								while ($json_event_date_ouverture->periodesOuvertures[++$nb_date_ouverture]->dateDebut!="");
								
								
								$testdebut=substr(substr($begin, 0, 10), -2);

	/* GESTION DU HANDICAP  */		

	/* GESTION DU PUBLIC  */		

					// echo "Type de Public :"				.$retourfiche->prestations->typesClientele[0]->libelleFr."<hr>";
					// echo "Type de animauxAcceptes :	"	.$retourfiche->prestations->animauxAcceptes."<hr>";
					// echo "Type de complementAccueil :"	.$retourfiche->prestations->complementAccueil->libelleFr."<hr>";
					// echo "Type de modesPaiement :"		.$retourfiche->descriptionTarif->modesPaiement[0]->libelleFr."<hr>";
					
					// echo "Type de modesPaiement :"		.$retourfiche->descriptionTarif->modesPaiement[0]->libelleFr."<hr>";				
					
	/* GESTION DES TARIFS  */			
			


					
	/* GESTION DES DONNEES DE BASE */	



								$descriptifCourt	= $retourfiche->presentation->descriptifCourt->libelleFr;
								$descriptifDetaille	= $retourfiche->presentation->descriptifDetaille->libelleFr;
								
								$reservation_registration=$retourfiche->reservation->organismes[0]->moyensCommunication[0]->coordonnees->fr;
								
								$letterslug = array("'", " ");	 /* 1 - Construction de slug ... la menace de Namek ? */ 
								$letterslug = array(",", " ");
								$search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
								//Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
								$replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
								$titre_replace = str_replace($search, $replace, $titre);
								$slug = str_replace($letterslug, "-", strtolower($titre_replace));

	/* GESTION DES PHOTOS */		
								$nb_illustrations=0;
								do 
								{
									/* Taille d'origine de la photo avec traductionFichiers[0]->url*/ 
									//	$photo_url	= $retourfiche->illustrations[$nb_illustrations]->traductionFichiers[0]->url;
									/* Taille de la photo réduite avec traductionFichiers[0]->urlDiaporama */ 
									$photo_url			= $retourfiche		->illustrations[$nb_illustrations]->traductionFichiers[0]->urlDiaporama;
									$photo_copyright 	= $retourfiche		->illustrations[$nb_illustrations]->copyright->libelleFr;
									$photo_fileName		= $retourfiche		->illustrations[$nb_illustrations]->traductionFichiers[0]->fileName;
									$photo_libelleFr	= $retourfiche		->illustrations[$nb_illustrations]->traductionFichiers[0]->nom->libelleFr;
									
									// 	Il existe plusieurs méthodes pour extraire le nom d'un fichier d'un chemin complet.
									// $file = basename($photo_url);
									// echo "<hr>".$file."<br>";
									$event_illustrations[$nb_illustrations] = array('photo_url'	=> $photo_url, 'photo_copyright' => $photo_copyright,'photo_fileName'=> $photo_fileName,'photo_libelleFr'=> $photo_libelleFr);
								} 
								while ($retourfiche->illustrations[++$nb_illustrations]->traductionFichiers[0]->url!="");
								
	/* GESTION DES DONNEES DE BASE */	

								if (isset($retourfiche->nom->libelleFr) && !empty($retourfiche->nom->libelleFr))	
								{
									$titre = $retourfiche->nom->libelleFr;
								} 
								else	
								{
									continue;
								}

								$descriptifCourt	= $retourfiche->presentation->descriptifCourt->libelleFr;
								$descriptifDetaille	= $retourfiche->presentation->descriptifDetaille->libelleFr;
								
								$reservation_registration=$retourfiche->reservation->organismes[0]->moyensCommunication[0]->coordonnees->fr;
								
								$letterslug = array("'", " ");	 /* 1 - Construction de slug ... la menace de Namek ? */ 
								$letterslug = array(",", " ");
								$search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
								//Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
								$replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
								$titre_replace = str_replace($search, $replace, $titre);
								$slug = str_replace($letterslug, "-", strtolower($titre_replace));								
																
				
								
								$dejafait=0;
								$i=0;
								do 
								{
									// echo "Titre : ".$titre." id Loc :".$unique_data_openagenda_loc[$i]."<br>";
									if ($titre==$unique_data_openagenda[$i]) { 
										$dejafait=1;
										$id_update=$unique_data_openagenda_uid[$i];
										$result_uid_location=$unique_data_openagenda_loc[$i];
									}
									$i++;
								}
								while ($i<$sizeapidae);								
								

								
								for  ($j=0;$j<$nb_tarif;$j++) {
									$result_event_tarif.="Tarif mini : ".$event_tarif[$j]['tarifs_minimum']." €, maxi ".$event_tarif[$j]['tarifs_maximum']." € - Cible :".$event_tarif[$j]['tarif_cible']." ";
								}
								
								if ($tarifsEnClair=="Gratuit.") {
									$result_event_tarif="Gratuit";
								}
								
								$b=0;$keywords="";
								do 	{ /* la virgule permet de couper les mots pas OpenAgenda */
									$keywords.=$retourfiche->informationsFeteEtManifestation->themes[$b]->libelleFr.", ";
								}	
								while ($retourfiche->informationsFeteEtManifestation->themes[++$b]->libelleFr!="");
								
								$keywords=substr($keywords, 0, -2); /* Pour supprimer la virgule en fin de chaine et l'espace ", " */

/* detection et correction des erreurs */

								$erreur_date=0;
								for ($i=0;$i<$nb_date_ouverture;$i++)
									if (substr($event_heure_ouverture[$i]['begin'], -6)=="T+0200") 	{
										$erreur_date++;
										$begin_erreur[$i]=$event_heure_ouverture[$i]['begin'];
										$event_heure_ouverture[$i]['begin']=substr($event_heure_ouverture[$i]['begin'],0, 11)."12:00:00+0200";
									}
								for ($i=0;$i<$nb_date_ouverture;$i++)
									if (substr($event_heure_ouverture[$i]['end'], -6)=="T+0200") { 
										$erreur_date++;
										$end_erreur[$i]=$event_heure_ouverture[$i]['end'];
										
										$event_heure_ouverture[$i]['end']=substr($event_heure_ouverture[$i]['end'],0, 11)."20:00:00+0200";
									}
								
								if ($reservation_registration=="") 	$erreur_reservation_registration="OUI"; 

									
								$ds=json_encode($Openagenda_event_data);
								// ecrire_data("***************************************************************************************************");
								// ecrire_data("ds >".$ds);
								// ecrire_data("***************************************************************************************************");
					

								
								$result_event_tarif=""; // remise à zéro des tarifs pour la futur fiche à charger.
								$tarifsEnClair="";
								$boucle++; 

	
								$photo_carousel[$icar]=$event_illustrations[0]['photo_url'];
								// echo "***".$photo_carousel[$icar];
								// echo $titre_carousel[$icar]=$titre;
								
								?>

							.slider li:nth-child(<?php echo $icar+1; ?>){
							background:linear-gradient(to right, rgba(1,1,1,1) 10%, rgba(1,1,1,0.8) 40%, rgba(1,1,1,0.2) 100%), url("<?php echo $event_illustrations[0]['photo_url']; ?>");
							object-fit: cover;
							background-size: cover;
							background-position:top left;
							}
						
								
							<?php								

								$titre_icar[$icar]=$titre;
								$date_en_clair_icar[$icar]="En ". $mois[intval($mois_begin)];

								$descriptifCourt_icar[$icar]=$descriptifCourt;
								// sscanf($begin, 	"%4s-%2s-%2sT%2s:%2s:%2s"	,$annee_begin	, $mois_begin	, $jour_begin	, $heure_begin	, $minute_begin	, $seconde_begin);
								$icar++;
					
							}		
							else 
							{
								 // echo "(".$liste_affichage." ) - Retour ".$retourfiche->id." | Arr ".$arr_id[$liste_affichage]."<br>";
								$liste_affichage++;
							}
				
						}
								
					}
				
				
?>	

.slider article{
    width:60%;
    margin-top:4rem;
    color: #fff;
    z-index:11;
}

.slider h3 + p {
    display: inline-block;
    color: var(--lite);
    font-weight:300;
}

.slider h3, .slider h3 + p, .slider p + .btn, li:after{
    opacity: 0;
    transition: opacity .7s 0s, transform .5s .2s;
    transform: translate3d(0, 50%, 0);
}

li.current h3, li.current h3 + p, li.current p + .btn, li.current:after {
    opacity: 1;
    transition-delay: 1s;
    transform: translate3d(0, 0, 0);
}

.slider li:before{
    transition: 0.5s;
    top:-250px !important;
}

li.current:before{
    transition-delay: 1s;
    transform: rotate(-90deg);
    top:-20px !important;
}

li.current {
    z-index: 1;
    clip: rect(0, 100vw, 100vh, 0);
}

li.prev {
    clip: rect(0, 0, 100vh, 0);
}

.slider aside {
    position: absolute;
    bottom: 2rem;
    left: 2rem;
    text-align: center;
    z-index: 10;
}

.slider aside a {
    display: inline-block;
    width: 8px;
    height: 8px;
    min-width: 8px;
    min-height: 8px;
    background-color: var(--white);
    margin: 0 0.2rem;
    transition: transform .3s;
}

.slider em{
    background: var(--primary);
    -webkit-text-fill-color: transparent;
    -webkit-background-clip: text;
}

a.current_dot {
    transform: scale(1.4);
    background:var(--primary) !important;
}

@media screen and (max-width: 920px) {
    header{
        height:70vh;
        position:relative;
    }
    
    .cs-down{
        display:none;
    }

    .slider{
        height:70vh;
    }
    
    .slider article{
        width:100%;
        margin-top:2rem;
    }
    
    .slider li:nth-child(2){
        background-position:top center;
    }
    
    .slider li:nth-child(3){
        background-position:top center;
    }
    
    li.current:before{
        top:-30px;
        right:-10px;
    }

}		
	</style>

<header>
    <section class="slider">
        <ul>

<?php 

	for ($i=0;$i<$icar;$i++) {
      echo'<li>';
      echo '<article class="center-y padding_2x">';
		echo '<h3 class="big title"><em>'.$titre_icar[$i].'</em> <br>'.$date_en_clair_icar[$i].'</h3>';
        echo '<p>'.$descriptifCourt_icar[$i].'</p>	';
        // echo '<a href="#about" class="btn btn_3">More about us</a>';
        echo '</article>';
        echo '</li>';
	}
?>	
            <aside>
               <?php for ($i=0;$i<$icar;$i++) 
				echo '<a href="#"></a>';
				?>
			</aside>
        </ul>
    </section>
    <a href="#services" class="cs-down"></a>
</header>

<script type="text/javascript">	
{
	  class SliderClip {
		constructor(el) {
		  this.el = el;
		  this.Slides = Array.from(this.el.querySelectorAll('li'));
		  this.Nav = Array.from(this.el.querySelectorAll('aside a'));
		  this.totalSlides = this.Slides.length;
		  this.current = 0;
		  this.autoPlay = true; //true or false
		  this.timeTrans = 10000; // Temps en millisecondes
		  this.IndexElements = [];

		  for (let i = 0; i < this.totalSlides; i++) {
			this.IndexElements.push(i);
		  }

		  this.setCurret();
		  this.initEvents();
		}
		setCurret() {
		  this.Slides[this.current].classList.add('current');
		  this.Nav[this.current].classList.add('current_dot');
		}
		initEvents() {
		  const self = this;

		  this.Nav.forEach(dot => {
			dot.addEventListener('click', ele => {
			  ele.preventDefault();
			  this.changeSlide(this.Nav.indexOf(dot));
			});
		  });

		  this.el.addEventListener('mouseenter', () => self.autoPlay = false);
		  this.el.addEventListener('mouseleave', () => self.autoPlay = true);

		  setInterval(function () {
			if (self.autoPlay) {
			  self.current = self.current < self.Slides.length - 1 ? self.current + 1 : 0;
			  self.changeSlide(self.current);
			}
		  }, this.timeTrans);

		}
		changeSlide(index) {

		  this.Nav.forEach(allDot => allDot.classList.remove('current_dot'));

		  this.Slides.forEach(allSlides => allSlides.classList.remove('prev', 'current'));

		  const getAllPrev = value => value < index;

		  const prevElements = this.IndexElements.filter(getAllPrev);

		  prevElements.forEach(indexPrevEle => this.Slides[indexPrevEle].classList.add('prev'));

		  this.Slides[index].classList.add('current');
		  this.Nav[index].classList.add('current_dot');
		}}


	const slider = new SliderClip(document.querySelector('.slider'));
}
</script>	