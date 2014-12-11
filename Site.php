<?php
error_reporting(E_ALL);
require('captcha.php');

CLASS Site{
	function __construct() {
		
	
		$Design			=	new Design();
		global $page;
		//if(isset($_GET['getA']) && $_GET['getA']=='ficheBien') $page	=	new Page('site_fiche') ;
		//else
		$page	=	new Page('site') ;
		$this->req = new RequeteBien();
		
		if (isset($_GET['getA'])) {
			$getA = $_GET['getA'] ;
			
			if ($getA == 'accueil')$this->accueil();
			elseif ($getA == 'agence')$this->agence();
			elseif ($getA == 'gestion')$this->gestion();
			elseif ($getA == 'etranger')$this->etranger();
			elseif ($getA == 'contact')$this->contact();
			elseif ($getA == 'nm_location')$this->nm_location();
			elseif ($getA == 'nm_garanties')$this->nm_garanties();
			elseif ($getA == 'nm_grl')$this->nm_grl();
			elseif ($getA == 'nm_transaction')$this->nm_transaction();
			elseif ($getA == 'location')$this->location();
			elseif ($getA == 'vente')$this->vente();
			elseif ($getA == 'prestige')$this->prestige();
			elseif ($getA == 'villegiature')$this->villegiature();
			elseif ($getA == 'localisation')$this->localisation();
			elseif ($getA == 'contacter')$this->contacter();
			elseif ($getA == 'deco')$this->deco();
			elseif ($getA == 'ml')$this->ml();
			elseif ($getA == 'nos_metiers')$this->nos_metiers();
			elseif ($getA == 'partenaires')$this->partenaires();
			elseif ($getA == 'developpement_durable')$this->developpement_durable();
			elseif ($getA == 'decoration')$this->decoration();
			elseif ($getA == 'charte')$this->charte();
			elseif ($getA == 'gestion')$this->gestion();
			elseif ($getA == 'alerte_mail')$this->alerte_mail();
			elseif ($getA == 'supprAlert')$this->supprAlert();
			elseif ($getA == 'recherche'){
				if (isset($_GET['bien'])){
					$this->recherchebien($_GET['bien']);
				}else{
					$this->recherche();
				}
			}
			elseif ($getA == 'verifIdent')$this->verifIdent();
			elseif ($getA == 'documents')$this->documents();
			elseif (isset($_GET['getB'])) {
				$getB = $_GET['getB'] ;
				if($getA == 'recherchebien') $this->recherchebien($getB);
				elseif($getA == 'ficheBien') $this->ficheBien($getB);
				elseif($getA == 'mail_annonce') $this->mail_annonce($getB);
				elseif($getA == 'envoi_mail_annonce') $this->envoi_mail_annonce($getB);
				elseif($getA == 'envoi_mail_agence') $this->envoi_mail_agence($getB);
				elseif($getA == 'editer_pdf') $this->editer_PDF($getB);
				elseif($getA == 'fiche_vitrine') $this->fiche_vitrine($getB);
				elseif($getA == 'desinscrAlert' && isset($_GET['verif'])) $this->desinscrAlert($getB, $_GET['verif']);
			}
			$page->page = str_replace('=IMG_ACCUEIL=', '', $page->page);
		} else {
			$this->accueil();
		}
	}
	
	function moteur($page, $fiche=''){
		
		if($fiche=='')
			$sortie = $page->RenvoiPage('moteur');
		elseif($fiche=='2')
			$sortie = $page->RenvoiPage('moteur_fiche');
		else
			$sortie = $page->RenvoiPage('moteur_horiz');	
		
		if (isset($_SESSION['RECHERCHE']['tri']))
			$sortie = str_replace('name="tri" value=""', 'name="tri" value="'.$_SESSION['RECHERCHE']['tri'].'"', $sortie);
		if (isset($_SESSION['RECHERCHE']['libelle_categorie_bien']))
			$sortie = str_replace('option value="'.$_SESSION['RECHERCHE']['libelle_categorie_bien'].'"', 'option value="'.$_SESSION['RECHERCHE']['libelle_categorie_bien'].'" selected="selected"', $sortie);
		if (isset($_SESSION['RECHERCHE']['BudgetMin']))
			$sortie = str_replace('name="BudgetMin" value=""', 'name="BudgetMin" value="'.$_SESSION['RECHERCHE']['BudgetMin'].'"', $sortie);
		if (isset($_SESSION['RECHERCHE']['BudgetMax']))
			$sortie = str_replace('name="BudgetMax" value=""', 'name="BudgetMax" value="'.$_SESSION['RECHERCHE']['BudgetMax'].'"', $sortie);
		if (isset($_SESSION['RECHERCHE']['libelle_type_transaction']))
			$sortie = str_replace('<option value="'.$_SESSION['RECHERCHE']['libelle_type_transaction'].'">', '<option value="'.$_SESSION['RECHERCHE']['libelle_type_transaction'].'" selected="selected">', $sortie);
		
		return $sortie;
	}
	
	function disp($page, $fiche=''){
		$page->page	= str_replace('=MOTEUR=',$this->moteur($page, $fiche),$page->page);
		$this->liste_type_bien();
	}
	
	function liste_type_bien(){
	
		global $page;
		
		$req = new RequeteBien();
		$types = $req->liste_type_bien();
		$bloc='<option value="">Tous</option>';
		foreach ($types as $t){
			$bloc .= '<option value="'.$t['libelle_categorie_bien'].'">'.ucfirst($t['libelle_categorie_bien']).'</option>'."\n";
		}
		
		if (isset($_SESSION['RECHERCHE']['libelle_categorie_bien']))
			$bloc = str_replace('<option value="'.$_SESSION['RECHERCHE']['libelle_categorie_bien'].'">', '<option value="'.$_SESSION['RECHERCHE']['libelle_categorie_bien'].'" selected="selected">', $bloc);
		$page->page	= str_replace('=types_bien=',$bloc,$page->page);
	}
	
	// OK
	function accueil() {
		
		global $page;
		
		$page->page	= str_replace('=PAGE=',$page->RenvoiPage('accueil'),$page->page);
		$page->page = str_replace('=IMG_ACCUEIL=', '<div id="ban_top"><img src="images/image_accueil.png" /></div>', $page->page);
		
		// $rnd = rand(0,2);
		// if($rnd<=1){
		// 	//$offre=$this->req->getAnnonceAvant('location');
		// }else{
		// 	//$offre=$this->req->getAnnonceAvant('vente');
		// }
		
		$offre=$this->req->annonce_vente_random('vente');
		$page->page = str_replace('=img=', 'http://easyannonce.com/img_users/'.$offre['photo_1'], $page->page);
		$page->page = str_replace('=ville=', $offre['libelle_ville'], $page->page);
		$page->page = str_replace('=prix=', $offre['prix_bien'], $page->page);
		$page->page = str_replace('=description=', $offre['descriptif_bien'], $page->page);
		$page->page = str_replace('=id_ann=', $offre['numero_bien'], $page->page);
		
		$this->disp($page);
		$page->page = str_replace('=TITLE=', 'Gestion - Location - Transaction de biens immobiliers', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Depuis 1976, entreprise familiale, exp�rience... Connaissance intime du march� local... que se soit pour donner une estimation fiable de votre bien, vendre, acheter ou louer au meilleur prix, g�rer, s�curiser vos revenus locatifs.', $page->page);
	
	}
	
	function ficheBien($id) {
		
		global $page;
		
		$bien = new AffichageBiens();
		//$page->page	= str_replace('=ESPACE_PERSO=',$this->espace_perso(),$page->page);
		$page->page = str_replace('=TITLE=', 'Annonce sur le site de '.NOM_SITE.' à =VILLE= (=CP=), T=NB_PIECES=, =TAILLE=', $page->page);
		$page->page = str_replace('id="footer"', 'id="footer3"', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Annonce sur le site de '.NOM_SITE.' à =VILLE= (=CP=), T=NB_PIECES=, =TAILLE=', $page->page);
		$page->page	= str_replace('=PAGE=',$bien->ficheBien($id),$page->page);
		$this->disp($page, '2');
	}
	
	function ml() {
		
		global $page;
		
		//$page->page	= str_replace('=ESPACE_PERSO=',$this->espace_perso(),$page->page);
		$page->page	= str_replace('=PAGE=',$page->RenvoiPage('ml'),$page->page);
		$page->page = str_replace('=TITLE=', 'Mentions légales', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Mentions légales de '.NOM_SITE.'.', $page->page);
		$this->disp($page);
	
	}
	
	function agence() {
		
		global $page;
		
		//$page->page	= str_replace('=ESPACE_PERSO=',$this->espace_perso(),$page->page);
		$page->page	= str_replace('=PAGE=',$page->RenvoiPage('agence'),$page->page);
		$page->page = str_replace('id="footer"', 'id="footer4"', $page->page);
		$page->page = str_replace('=IMG_ACCUEIL=', '<div id="ban_top"><img src="images/image_accueil.png" /></div>', $page->page);
		$page->page = str_replace('=TITLE=', 'Agence immobili�re '.NOM_SITE, $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Mentions l�gales de '.NOM_SITE.'.', $page->page);
		$this->disp($page);
	
	}
	
	// OK
	function gestion() {
		
		global $page;
		
		$page->page	= str_replace('=PAGE=',$page->RenvoiPage('gestion'),$page->page);
		$page->page = str_replace('=TITLE=', 'Gestion locative', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Transparence, rigueur, conseil, nous nous engageons à votre service pour valoriser et rentabiliser votre investissement locatif. Sécurit grâce à notre assurance loyers impayés (sans franchise et sans plafond). Nous vérifions la solvabilité des locataires et intervenons dès la survenance d\'un sinistre (impayé, travaux d\'urgence).', $page->page);
		$this->disp($page);
	
	}
	
	function contact() {
		
		global $page;
                $captcha = new Captcha();
                $captcha->random_word(6);
               // $captcha->flou_gaussien(1);
                $captcha->save_img();
		
		if (isset($_GET['getB'])) $id_ann = $_GET['getB'];
		else $id_ann = '';
		$u = new EspacePerso();
		$page->page = str_replace('id="footer"', 'id="footer2"', $page->page);
		$page->page	= str_replace('=PAGE=',$u->contact($id_ann),$page->page);
		$page->page = str_replace('=TITLE=', 'Contactez-nous', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Contactez nous pour vos questions concernant votre patrimoine immobilier, sa gestion, les transactions, les locations, le développement durable, la décoration, le home staging, les chasseurs d\'appartements, le financement de vos projets immobiliers, les assurances, nos partenaires, ...', $page->page);
                $this->disp($page);
	
	}
	
	function location() {
		global $page;
		
		$_SESSION['RECHERCHE']['libelle_categorie_bien'] = "";
		$_SESSION['RECHERCHE']['libelle_type_transaction'] = "Offre de Location";
		if(!isset($_SESSION['RECHERCHE']['tri']) || $_SESSION['RECHERCHE']['tri'] != 2) $_SESSION['RECHERCHE']['tri']=1;
		
		$AffichageBiens= new AffichageBiens();
		$annonce=$AffichageBiens->rechercher();
		$page->page = str_replace('zonecentre', 'zonecentre2', $page->page);
				
		$page->page	= str_replace('=PAGE=',$AffichageBiens->location(),$page->page);
		
		$page->page = str_replace('=TITLE=', 'Nos biens immobiliers à la location', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Offres de location à Bordeaux, Bazas, Langon, CUB et plus g�n�ralement en Gironde. Vous chercher à louer un appartement  �tudiant seul ou en colocation, un appartement pour votre famille une maison, un meubl� : regarder nos offres et faites votre s�lection en fonction du type (T1, T2, T3, T4, T5 ou plus) ou du loyer.', $page->page);
		
		$page->page	= str_replace('=annonce=',$annonce,$page->page);
		$this->disp($page, 1);
	
	}
	
	function vente() {
		global $page;
			
		$_SESSION['RECHERCHE']['libelle_categorie_bien'] = "";
		$_SESSION['RECHERCHE']['libelle_type_transaction'] = "Offre de Vente";
		if(!isset($_SESSION['RECHERCHE']['tri']) || $_SESSION['RECHERCHE']['tri'] != 2) $_SESSION['RECHERCHE']['tri']=1;
			
		$page->page = str_replace('zonecentre', 'zonecentre2', $page->page);
		$AffichageBiens= new AffichageBiens();
		$annonce=$AffichageBiens->rechercher();
		
		$page->page	= str_replace('=PAGE=',$AffichageBiens->vente(),$page->page);
		
		$page->page = str_replace('=TITLE=', 'Nos biens immobiliers � la vente', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Vente de biens immobiliers sur '.NOM_SITE, $page->page);
		
		$page->page	= str_replace('=annonce=',$annonce,$page->page);
		$this->disp($page, 1);
	
	}
	
	function contacter(){
		global $page;
		
		$Mail= new Mail();
		$page->page = str_replace('id="footer"', 'id="footer2"', $page->page);
		$page->page	= str_replace('=PAGE=',$Mail->contacter(),$page->page);
		$page->page = str_replace('=TITLE=', 'Contactez-nous', $page->page);
		$page->page = str_replace('<meta name="description" content="=DESCRIPTION=" />', '<META NAME="robots" CONTENT="noindex">', $page->page);
		$this->disp($page);
	}
	
	
	
	function recherche() {
		global $page;
		
		//$page->page = str_replace('zonecentre', 'zonecentre2', $page->page);
		$AffichageBiens= new AffichageBiens();
		$annonce=$AffichageBiens->rechercher();
		$page->page	= str_replace('=PAGE=',$AffichageBiens->transaction(),$page->page);
		$page->page	= str_replace('=annonce=',$annonce,$page->page);
		$page->page = str_replace('=TITLE=', 'Recherche de biens immobiliers', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Recherchez le bien immobilier qui correspond à vos critères : prix, département, ville, type de bien (maison, appartement, ...), à la vente ou en location.', $page->page);
		$this->disp($page, 1);
		
	}
	
	function recherchebien($bien) {
		global $page;
		
		$page->page = str_replace('zonecentre', 'zonecentre2', $page->page);
		$AffichageBiens= new AffichageBiens();
		$trans = $page->RenvoiPage('transaction');
		$trans = str_replace('=nb_pages=', '', $trans);
		$trans = str_replace('=tri=', 'Trier par : '.$AffichageBiens->FormTri(), $trans);
		$page->page = str_replace('=PAGE=', $trans, $page->page);

		$page->page	= str_replace('=annonce=',$AffichageBiens->transactionbien($bien),$page->page);
		$page->page = str_replace('=TITLE=', '', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Recherche d\'un bien immobilier.', $page->page);
		$this->disp($page);
		
	}
		
	function mail_annonce($num_annonce){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->mail_annonce($num_annonce),$page->page);
		$page->page = str_replace('=TITLE=', '', $page->page);
		$page->page = str_replace('<meta name="description" content="=DESCRIPTION=" />', '<META NAME="robots" CONTENT="noindex">', $page->page);
		$this->disp($page);
	}
	
	function envoi_mail_annonce($num_annonce){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->envoi_mail_annonce($num_annonce),$page->page);
		$this->disp($page, 2);
		$page->page = str_replace('=TITLE=', '', $page->page);
		$page->page = str_replace('id="footer"', 'id="footer3"', $page->page);
		$page->page = str_replace('<meta name="description" content="=DESCRIPTION=" />', '<META NAME="robots" CONTENT="noindex">', $page->page);
	}
	function envoi_mail_agence($num_annonce){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->envoi_mail_agence($num_annonce),$page->page);
		$this->disp($page, 2);
		$page->page = str_replace('=TITLE=', '', $page->page);
		$page->page = str_replace('id="footer"', 'id="footer3"', $page->page);
		$page->page = str_replace('<meta name="description" content="=DESCRIPTION=" />', '<META NAME="robots" CONTENT="noindex">', $page->page);
	}
	
	function editer_PDF($num_annonce){
		$pdf = new PDF();
		$pdf->edition_pdf($num_annonce);
	}
	
	function fiche_vitrine($num_annonce){
		$pdf = new PDF();
		$pdf->fiche_vitrine($num_annonce);
	}
	
	function espace_perso(){
		global $page;
	
		if (isset($_SESSION['util']) && $_SESSION['util']==1){
			return ($page->RenvoiPage('espace_perso2'));
		}else{
			return ($page->RenvoiPage('espace_perso'));
		}
	}
	
	function alerte_mail(){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->alerte_mail(),$page->page);
		$page->page = str_replace('=TITLE=', NOM_SITE.' - Recevez une alerte mail pour �tre s�r de ne manquer aucune annonce !', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Recevoir une alerte mail', $page->page);
		$this->disp($page);
	}
	
	function desinscrAlert($id_alert, $code_verif){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->desinscrAlert($id_alert, $code_verif),$page->page);
		$page->page = str_replace('=TITLE=', NOM_SITE.' - Recevez une alerte mail pour �tre s�r de ne manquer aucune annonce !', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Se désinscrire d\'une alerte mail', $page->page);
		$this->disp($page);
	}
	
	function supprAlert(){
		global $page;
		
		$Mail= new Mail();
		$page->page	= str_replace('=PAGE=',$Mail->supprAlert(),$page->page);
		$page->page = str_replace('=TITLE=', NOM_SITE.' - Recevez une alerte mail pour être sûr de ne manquer aucune annonce !', $page->page);
		$page->page = str_replace('=DESCRIPTION=', 'Se désinscrire d\'une alerte mail', $page->page);
		$this->disp($page);
	}
	
}	
	

?>
