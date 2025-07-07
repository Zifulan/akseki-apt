<?php

//CHILD THEMING FROM TWENTY NINETEEN


function avi_enqueue() {
    //BOOTSTRAP
	wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
    $dependencies = array('bootstrap');
    wp_enqueue_style( 'bootstrapstarter-style', get_stylesheet_uri(), $dependencies ); 
	
	//jQUERY
    $dependencies = array('jquery');
	wp_register_script( 'gdgt-base', get_stylesheet_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), NULL, false );
    wp_enqueue_script( 'gdgt-base' );
	
	//OWL
	wp_register_style('owl', get_stylesheet_directory_uri() . '/vendor/owlcarousel/assets/owl.carousel.min.css' );	
    wp_enqueue_style( 'owl' ); 
	wp_register_style('owldefaulttheme', get_stylesheet_directory_uri() . '/vendor/owlcarousel/assets/owl.theme.default.min.css' );
	wp_enqueue_style( 'owldefaulttheme' ); 
	wp_register_script( 'owl-js', get_stylesheet_directory_uri() . '/vendor/owlcarousel/owl.carousel.min.js' );
    wp_enqueue_script( 'owl-js' );
	
	//AKSEKI
	wp_register_script( 'akseki-js', get_stylesheet_directory_uri() . '/akseki.js' );
    wp_enqueue_script( 'akseki-js' );
	
}

add_action( 'wp_enqueue_scripts', 'avi_enqueue' );

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_stylesheet_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'akseki-vi' ),
) );

add_theme_support( 'post-thumbnails' );

/*get locations in add new posts*/
add_action('add_meta_boxes', 'wporg_add_custom_box');
add_action('save_post', 'alm_save_postdata');

function wporg_add_custom_box()
{
    $screens = ['post', 'wporg_cpt'];
    foreach ($screens as $screen) {
        add_meta_box(
            'akseki_location_meta',           // Unique ID
            'Location Meta',  // Box title
            'alm_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
function alm_custom_box_html($post)
{
	$locations = get_terms('mec_location', array('orderby'=>'name', 'hide_empty'=>'0'));
	$location_id = get_post_meta($post->ID, 'mec_location', true);
    ?>
	
    <label for="alm_field">Select City (Country will be programatically generated)</label>
    <select name="alm_field" id="alm_field" class="postbox">
        <?php foreach($locations as $location): ?>
			<option <?php if($location_id == $location->name) echo 'selected="selected"'; ?> value="<?php echo $location->term_id; ?>"><?php echo $location->name; ?></option>
		<?php endforeach; ?>
    </select>
    <?php
}
function alm_save_postdata($post_id)
{
    if (array_key_exists('alm_field', $_POST)) {
        update_post_meta(
            $post_id,
            'mec_location',
            $_POST['alm_field']
        );
    }	
}

//load svg
function load_flags_svg( $filename ) {
    $svg_path = "/img/flags/".strtolower($filename).".svg";	
    if ( file_exists( get_stylesheet_directory() . $svg_path  ) ) {       
		//echo("found");
		return file_get_contents( get_stylesheet_directory() . $svg_path );
		//return include get_stylesheet_directory().$svg_path;
    }else{
		//echo("ng: ".get_stylesheet_directory() . $svg_path );
		return '';
    }	    
}
function load_logo_svg() {
    $svg_path = "/img/aptlogo3.svg";	
    if ( file_exists( get_stylesheet_directory() . $svg_path ) ) {       
		//echo("found");
		return file_get_contents( get_stylesheet_directory() . $svg_path );
    }else{
		//echo("ng");
		return '';
    }	    
}

//display country name and flag
function get_the_country($city){
	
	switch ($city) {
	case "Bandar Seri Begawan":
	case "Jerudong":
	case "Brunei Darussalam":
        $country="Brunei Darussalam";
		$flag="br";
        break;
    case "Phnom Penh":
	case "Siem Reap":
	case "Cambodia":
        $country="Cambodia";
		$flag="kh";
        break;
	case "Jakarta":
	case "Medan":
	case "Yogyakarta":
	case "Bali":
	case "Mataram":
	case "Manado":
	case "Indonesia":
        $country="Indonesia";
		$flag="id";
        break;
	case "Vientiane":
	case "Luang Prabang":
	case "Laos":
        $country="Laos";
		$flag="la";
        break;	
    case "Kuala Lumpur":
    case "Langkawi":
    case "Kuching":
    case "Selangor":
	case "Malaysia":
        $country="Malaysia";
		$flag="ml";
        break;
	case "Yangon":
	case "Naypyitaw":
	case "Nay Pyi Taw":
	case "Mandalay":
	case "Myanmar":
        $country="Myanmar";
		$flag="mm";
        break;
	case "Manila":
	case "Metro Manila":
	case "Makati":
	case "Makati City":
	case "Tagaytay":
	case "Davao":
	case "Cebu":
	case "Pampanga":
	case "Pasay City":
	case "Philippines":
        $country="Philippines";
		$flag="ph";
        break;
	case "Singapore":
        $country="Singapore";
		$flag="sg";
        break;
    case "Bangkok":	
    case "Chiang Mai":	
    case "Phuket":	
    case "Cha-am Hua Hin":	
	case "Thailand":
        $country="Thailand";
		$flag="th";
        break;
    case "Ha Noi":
    case "Ho Chi Minh":
    case "Da Lat":
    case "Da Nan":
    case "Hue City":
	case "Vietnam":
        $country="Vietnam";
		$flag="vn";
        break;
	case "Shanghai":
	case "Beijing":
        $country="China";
		$flag="ch";
        break;
	case "Tokyo":
	case "Yokohama":
        $country="Japan";
		$flag="jp";
        break;
	case "Seoul":
	case "Jeju":
        $country="Korea";
		$flag="kr";
        break;
	case "Honolulu":
        $country="USA";
		$flag="us";
        break;
	case "Istanbul":
        $country="Turkey";
		$flag="tr";
        break;
	case "Madrid":
        $country="Spain";
		$flag="es";
        break;
	case "Tashkent":
        $country="Uzbekistan";
		$flag="uz";
        break;
	case "Delhi":
        $country="India";
		$flag="in";
        break;	
	case "Astana":
        $country="Kazakhstan";
		$flag="kz";
        break;	
	case "Baku":
        $country="Azerbaijan";
		$flag="az";
        break;	
	case "Frankfurt":
        $country="Germany";
		$flag="de";
        break;
	case "Online Conference":
        $country="Online Conference";
		$flag="";
        break;
    default:
        $country="";
		$flag="";
	}
	$return = ['country'=>$country, 'flag'=>$flag];
	
	return ($return);
}

function akseki_get_the_meta($postID){
	$mec_location = get_post_meta($postID, 'mec_location', true);		
	$return = '<span class="meta-location">';
	if($mec_location){
		if(is_numeric($mec_location)){
			$mec_city = get_term($mec_location)->name;
		}else{
			$mec_city = $mec_location;
		}
		//if the city is the country no need to display both		
		$mec_country = get_the_country($mec_city);		
		if($mec_country['country'] !== $mec_city){
			$return .= '<span class="meta-city">'.$mec_city.'</span>, ';
		}		
		$return .= '<span class="meta-country">'.$mec_country['country'].'</span>&nbsp;';
		//get_template_part("img/flags/".strtolower($mec_country).".svg");
		$return .= '<span class="roundflag">'.load_flags_svg($mec_country['flag']).'</span>';
		$return .= '</span>';
	}													
	$return .= '<span class="meta-comma"> </span>';
	$return .= '<span class="meta-date">'.get_the_date().'</span>';
	return $return;
}

function akseki_get_the_flag($postID){
	$mec_location = get_post_meta($postID, 'mec_location', true);
	if($mec_location){
		if(is_numeric($mec_location)){
			$mec_city = get_term($mec_location)->name;
		}else{
			$mec_city = $mec_location;
		}
		$mec_country = get_the_country($mec_city);
		$return = '<span class="roundflag">'.load_flags_svg($mec_country['flag']).'</span>';
		return $return;
	}
}

function akseki_get_shortname($longname, $post_ID){
	$longtitle = strip_tags($longname);
	$display_output = "";
	$shorttitle3 = '';
	$fixedtitle = '';
	$noshorttitle = false;
	preg_match('/\d\d*(:?st|nd|rd|th)/', $longtitle, $shorttitle);
	if(!empty($shorttitle)){
		$shorttitle3 = trim(strtolower($shorttitle[0]));		
	}else{
		preg_match('/(:?first|second|third|fourth|fifth|sixth|seventh|eighth|ninth|tenth)/i', $longtitle, $shorttitle2);
		if(!empty($shorttitle2)){
			$shorttitle3 = trim(strtolower($shorttitle2[0]));
		}else{
			$shorttitle3 = $longtitle;
			$noshorttitle = true;
		}
	}
	if($noshorttitle == false) :
	switch ($shorttitle3) {
		case "1st":
		case "first":
			$fixedtitle="1st";			
			break;
		case "2nd":
		case "second":
			$fixedtitle="2nd";
			break;
		case "3rd":
		case "third":
			$fixedtitle="3rd";
			break;
		case "4th":
		case "fourth":
			$fixedtitle="4th";
			break;	
		case "5th":
		case "fifth":
			$fixedtitle="5th";
			break;
		case "6th":
		case "sixth":
			$fixedtitle="6th";
			break;
		case "7th":
		case "seventh":
			$fixedtitle="7th";
			break;
		case "8th":
		case "eighth":
			$fixedtitle="8th";
			break;
		case "9th":	
		case "ninth":	
			$fixedtitle="9th";
			break;
		case "10th":
		case "tenth":
			$fixedtitle="10th";
			break;
		default:
			$fixedtitle=$shorttitle3;
		}
	endif;
	if($noshorttitle==false){
		$display_output .= '<span class="numberer">';
		$display_output .= preg_replace('/(st|nd|rd|th)/', '<sup>$1</sup>', $fixedtitle);
		$display_output .= "</span>";
	
		$view_list = akseki_get_ministrial_categories();
		$current_categories = get_the_category($post_ID);
		foreach($current_categories as $cat){
			if(in_array($cat->slug, $view_list)){
				$display_output .= ' '.$cat->name;
			}
		}
	}
	
	return $display_output;
}

//list of ministrial level categories slug
function akseki_get_ministrial_categories(){
	$appear = ['apt-foreign-ministers-meeting','ammtc3','aem3','afmgm3','m-atm3','amaf3','amem3','amme3-emm','ammswd3','ammy3','accsm3','almm3','amca3','amri3','aptemm','ahmm3'];
	return $appear;
}
function akseki_get_sectoral_categories(){
	$appear = ['economic-cooperations','political-cooperations','socio-cultural-cooperations'];
	return $appear;
}
function akseki_get_commision_categories(){
	$appear = ['ministerial-level-statements','summit-level-statements'];
	return $appear;
}

//shortcode to display list of categories
function akseki_aoc($atts){
	$cats = get_categories( array(        
					'parent' => $atts['parent'],
				) );	
	$return = '';
	foreach($cats as $index=>$cat){
		switch($cat->term_id){
			//find 	ASEAN Plus Three Ministerial Meeting on
			case 42:
				$area = 'Political';
				break;
			case 46:
			case 51:			
			case 52:			
			case 55:			
			case 56:			
			case 57:			
			case 59:			
				$exploded = explode(' on ', $cat->description);
				$area = $exploded[1];
				break;
			case 48:
			case 49:
			case 50:
			case 58:
			case 61:
			case 62:
				$exploded = explode(' Ministers', $cat->description);
				$exploded2 = explode(' ', $exploded[0]);
				$area = end($exploded2);
				break;
			default:
				$area = $cat->term_id;
		}
				
		$return .= '<tr>';
		//the area column
		$return .= '<td class="w-25">';
		$return .= $area;		
		$return .= '</td>';
		//the summit collapsible, only call on first iteration		
		if($index == 0){
			$return .= '<td rowspan='.count($cats).' class="collapse show collapseLeader" data-parent="#accordionLevel">';
			$return .= '<a href="'.get_category_link(41).'">ASEAN Plus Three Summit (APT Summit)</a>';
			$return .= '</td>';
		}
		
		//the ministerial collapsible
		$return .= '<td class="collapse collapseMinisterial" data-parent="#accordionLevel">';
		$return .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->description .' ('.$cat->name.')</a>';
		$return .= '</td>';
		$return .= '</tr>';
		
	}
	return '<table class="w-100">'.$return.'</table>';	
}
add_shortcode('akseki_aoc','akseki_aoc');

// Remove pagination on listing per category index page
// may need to enable / disable for certain category later
function no_nopaging($query) {
    if (is_category() && $query->is_main_query()) {
        $query->set('nopaging', 1);
    }
}
add_action('parse_query', 'no_nopaging');
?>