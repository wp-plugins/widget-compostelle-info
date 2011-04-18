<?php
/*
Plugin Name: Widget Compostelle Info
Plugin URI: http://www.villemagne.net/site_fr/compostelle-info-integration.php#020
Description: Ajoute une fen&ecirc;tre (iFrame) &agrave; la barre lat&eacute;rale pour afficher le flux d&rsquo;articles 'Compostelle Info'
Version: 1.0
Author: Pedibus
Author URI: http://www.villemagne.net

-----------------------------------------------------
Copyright 2011  Fran&ccedil;ois-Xavier de Villemagne — Tous droits réservés

Ce programme est un logiciel libre ; vous pouvez la redistribuer ou
la modifier suivant les termes de la Licence Générale Publique Limitée
GNU telle que publiée par la Free Software Foundation ; soit la
version 2.1 de la License, soit (à votre gré) toute version ultérieure.

Ce programme est distribué dans l’espoir qu’il sera utile, mais
SANS AUCUNE GARANTIE : sans même la garantie implicite de
COMMERCIALISABILITÉ ou d’ADÉQUATION À UN OBJECTIF PARTICULIER. Consultez
la Licence Générale Publique Limitée pour plus de détails.

Vous devriez avoir re&ccedil;u une copie de la Licence Générale Publique Limitée
GNU avec ce programme ; si ce n’est pas le cas, écrivez à la :
Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
MA 02110-1301, USA.
-----------------------------------------------------

Voir le fichier readme.txt pour la liste des changements.
*/


function compostelle_info_iframe_init() {
	
	// Vérifier les fonctions API requises
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ){
		return;	
	}

	// Cette fonction sauvegarde les options et affiche l'écran de configuration du widget
	function compostelle_info_iframe_control() {
		$options = $newoptions = get_option('compostelle_info_iframe');
		if ( $_POST['iframe-submit'] ) {
			$newoptions['width'] = (int) $_POST['iframe-width'];
			$newoptions['height'] = (int) $_POST['iframe-height'];
			$newoptions['nb-articles'] = $_POST['iframe-nb-articles'];
		}

		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('compostelle_info_iframe', $options);
		}
		?>
		<div style="text-align:right">
		    <p style="text-align:left;"><label for="iframe-intro">Afficher le flux d'articles <em>Compostelle Info</em> dans une fen&ecirc;tre (<em>iFrame</em>)</label></p>
			<label for="iframe-width" style="line-height:35px;display:block;">Largeur (px) : <input type="text" id="iframe-width" name="iframe-width" value="<?php if($options['width'] == "") echo "200"; else echo($options['width']); ?>" size="1" /></label>
			<label for="iframe-height" style="line-height:35px;display:block;">Hauteur (px) : <input type="text" id="iframe-height" name="iframe-height" value="<?php if($options['height'] == "") echo "320"; else echo ($options['height']); ?>" size="1" /></label>
			<label for="iframe-nb-articles" style="line-height:35px;display:block;">Nombre d&rsquo;articles (max=5) : <input type="text" id="iframe-nb-articles" name="iframe-nb-articles" value="<?php if($options['nb-articles'] == "") echo "5"; else  echo ($options['nb-articles']); ?>" size="1" /></label>
			<input type="hidden" name="iframe-submit" id="iframe-submit" value="1" />
		</div>
		<?php
	}

	// Affichage du widget
	function compostelle_info_iframe($args) {	
		extract($args);
		$defaults = array('width' => 200, 'height' => 320, 'nb-articles' => 5);
		$options = (array) get_option('compostelle_info_iframe');

		// Si l'utilisateur n'a pas encore spécifié les options ou si les champs sont vides, prendre les options par défaut
		foreach ( $defaults as $key => $value ){
			if ( !isset($options[$key]) || $options[$key] == ""){
				$options[$key] = $defaults[$key];	
			}
		}
		
		$width = $options['width'];
		$height = $options['height'];
		$url = 'http://www.villemagne.net/site_fr/compostelle-une-actualites.php?i=1&n=' .  $options['nb-articles'];		
		?>
		<iFrame src="<?php echo $url; ?>" width="<?php echo $width; ?>px" height="<?php echo $height; ?>px" scrolling=auto style="border: 2px solid #cdcdcd">Votre navigateur ne permet pas d&rquo;afficher  les iFrames.</iFrame><br /><br />
		<?php echo $after_widget; ?>
		<?php
	}

	// Avertir la barre latérale dynamique de la présence du nouveau widget et de ses paramètres
	register_sidebar_widget('Widget Compostelle Info', 'compostelle_info_iframe');
	register_widget_control('Widget Compostelle Info', 'compostelle_info_iframe_control');
}


// Retarder l'exécution de l'extension pour donner le temps à la barre latérale dynamique de s'afficher
add_action('plugins_loaded', 'compostelle_info_iframe_init');
?>