<?php
/*
Plugin Name: Widget Compostelle Info
Plugin URI: http://www.compostelleinfo.fr/integration.php#020
Description: Ajoute une fen&ecirc;tre (iFrame) &agrave; la barre lat&eacute;rale pour afficher le flux d&rsquo;articles 'Compostelle Info'
Version: 1.1
Author: Pedibus
Author URI: http://www.compostelleinfo.fr/

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
			$newoptions['frameScroll'] = $_POST['iframeScroll'];
			$newoptions['frameBackgroundColor'] = $_POST['iframeBackgroundColor'];
			$newoptions['frameBorder'] = $_POST['iframeBorder'];
			$newoptions['frameBorderColor'] = $_POST['iframeBorderColor'];
			$newoptions['frameFont'] = $_POST['iframeFont'];
			$newoptions['frameFontSize'] = $_POST['iframeFontSize'];
			$newoptions['frameFontColor'] = $_POST['iframeFontColor'];
	
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
			<label for="iframe-nb-articles" style="line-height:35px;display:block;">Nombre d&rsquo;articles (max=5)&nbsp;: <input type="text" id="iframe-nb-articles" name="iframe-nb-articles" value="<?php if($options['nb-articles'] == "") echo "5"; else  echo ($options['nb-articles']); ?>" size="1" /></label>
			
			<label for="iframeScroll" style="line-height:35px;display:block;">Barre de d&eacute;filement vertical&nbsp;: <select name="iframeScroll"><option <?php if($options['frameScroll'] == "" || $options['frameScroll'] == "auto") echo "selected "; ?> value="auto">auto</option><option <?php if($options['frameScroll'] == "yes") echo "selected "; ?> value="yes">oui</option><option <?php if($options['frameScroll'] == "no") echo "selected "; ?> value="no">non</option></select></label>
			
			<label for="iframeBackgroundColor" style="line-height:35px;display:block;">Couleur de fond&nbsp;: <input type="text" id="iframeBackgroundColor" name="iframeBackgroundColor" size="5" value="<?php if($options['frameBackgroundColor'] == "") echo "fafaf5"; else echo ($options['frameBackgroundColor']); ?>"></label>
			
			<label for="iframeBorder" style="line-height:35px;display:block;">&Eacute;paisseur de la bordure (px)&nbsp;: <select name="iframeBorder"><option <?php if($options['frameBorder'] == 3) echo "selected "; ?> value="3">3</option><option <?php if($options['frameBorder'] == "" || $options['frameBorder'] == 2) echo "selected "; ?> value="2">2</option><option <?php if($options['frameBorder'] == 1) echo "selected "; ?> value="1">1</option><option <?php if($options['frameBorder'] == '-') echo "selected "; ?> value="-">0</option></select></label>
			
			<label for="iframeBorderColor" style="line-height:35px;display:block;">Couleur de la bordure&nbsp;: <input type="text" id="iframeBorderColor" name="iframeBorderColor" size="5" value="<?php if($options['frameBorderColor'] == "") echo "cdcdcd"; else echo ($options['frameBorderColor']); ?>"></label>
			
			<label for="iframeFont" style="line-height:35px;display:block;">Police&nbsp;: <select name="iframeFont" cols=3><option <?php if($options['frameFont'] == 0) echo "selected "; ?> value="0">Trebuchet MS, sans-serif</option><option <?php if($options['frameFont'] == 1) echo "selected "; ?> value="1">Times New Roman, Times, serif</option><option <?php if($options['frameFont'] == 2) echo "selected "; ?> value="2">Verdana, Geneva, sans-serif</option><option <?php if($options['frameFont'] == 3) echo "selected "; ?> value="3">Tahoma, Geneva, sans-serif</option><option <?php if($options['frameFont'] == 4) echo "selected "; ?> value="4">MS Sans Serif, Geneva, sans-serif</option><option <?php if($options['frameFont'] == 5) echo "selected "; ?> value="5">MS Serif, New York, serif</option><option <?php if($options['frameFont'] == 6) echo "selected "; ?> value="6">Arial,  Helvetica, sans-serif</option><option <?php if($options['frameFont'] == 7) echo "selected "; ?> value="7">Arial Black, Gadget, sans-serif</option><option <?php if($options['frameFont'] == 8) echo "selected "; ?> value="8">Comic Sans MS, cursive</option><option <?php if($options['frameFont'] == 9) echo "selected "; ?> value="9">Georgia, serif</option><option <?php if($options['frameFont'] == "" || $options['frameFont'] == 10) echo "selected "; ?> value="10">Palatino Linotype, Book Antiqua, Palatino, serif</option><option <?php if($options['frameFont'] == 11) echo "selected "; ?> value="11">Courier New, monospace</option></select></label>
			
			<label for="iframeFontSize" style="line-height:35px;display:block;">Taille de la police (pt)&nbsp;: <select name="iframeFontSize"><option <?php if($options['frameFontSize'] == 13) echo "selected "; ?> value="13">13</option><option <?php if($options['frameFontSize'] == 12) echo "selected "; ?> value="12">12</option><option <?php if($options['frameFontSize'] == 11) echo "selected "; ?> value="11">11</option><option <?php if($options['frameFontSize'] == "" || $options['frameFontSize'] == 10) echo "selected "; ?>  value="10">10</option><option value="9">9</option><option <?php if($options['frameFontSize'] == 8) echo "selected "; ?> value="8">8</option><option <?php if($options['frameFontSize'] == 7) echo "selected "; ?> value="7">7</option></select></label>
			
			<label for="iframeFontColor" style="line-height:35px;display:block;">Couleur de la police&nbsp;: <input type="text" id="iframeFontColor" name="iframeFontColor" size="5" value="<?php if($options['frameFontColor'] == "") echo "1f4865"; else echo ($options['frameFontColor']); ?>" /></label>


			<input type="hidden" name="iframe-submit" id="iframe-submit" value="1" />
		</div>
		<?php
	}

	// Affichage du widget
	function compostelle_info_iframe($args) {	
		extract($args);
		$defaults = array('width' => 200, 'height' => 320, 'nb-articles' => 5, 'iframeScroll' => "auto", 'iframeBackgroundColor' => "fafaf5", 'iframeBorder' => 2, 'iframeBorderColor' => "cdcdcd", 'iframeFont' => 10, 'iframeFontSize' => 11, 'iframeFontColor' => "1f4865") ;
		$options = (array) get_option('compostelle_info_iframe');

		// Si l'utilisateur n'a pas encore spécifié les options ou si les champs sont vides, prendre les options par défaut
		foreach ( $defaults as $key => $value ){
			if ( !isset($options[$key]) || $options[$key] == ""){
				$options[$key] = $defaults[$key];	
			}
		}
		
		$width = $options['width'];
		$height = $options['height'];
		$url = 'http://www.compostelleinfo.fr/une-actualites.php?i=1&n=' .  $options['nb-articles'] . '&bc=' . $options['frameBackgroundColor'] . '&ff=' . $options['frameFont'] . '&fs=' . $options['frameFontSize'] . '&fc=' . $options['frameFontColor'];		
		if ($options['frameBorder'] <> 0 && $options['frameBorderColor']<>"") $style = '"border: ' . $options['frameBorder'] . 'px solid #' . $options['frameBorderColor'] . '"';
		?>
		<iFrame src="<?php echo $url; ?>" width="<?php echo $width; ?>px" height="<?php echo $height; ?>px" scrolling=<?php echo $options['frameScroll']; ?> style=<?php echo $style ?>>Votre navigateur ne permet pas d&rquo;afficher  les iFrames.</iFrame><br /><br />
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