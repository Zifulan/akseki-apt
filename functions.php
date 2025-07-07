<?php

//CHILD THEMING FROM TWENTY NINETEEN


function avi_enqueue() {
    //BOOTSTRAP
	wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
    $dependencies = array('bootstrap');
    $theme = wp_get_theme();
	$ver = $theme->Version; //gets version written in your style.css
    wp_enqueue_style( 'bootstrapstarter-style', get_stylesheet_uri(), $dependencies, $ver ); 
	
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

/*MEC LOCATION CUSTOM TAXONOMY*/
/*get locations in add new posts*/
add_action( 'init', 'add_custom_taxonomies', 0 );
function add_custom_taxonomies() {
	register_taxonomy('mec_location', 'post', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
	'public'       => true,
    'show_in_rest' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Locations', 'taxonomy general name' ),
      'singular_name' => _x( 'Location', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Locations' ),
      'all_items' => __( 'All Locations' ),
      'parent_item' => __( 'Parent Location' ),
      'parent_item_colon' => __( 'Parent Location:' ),
      'edit_item' => __( 'Edit Location' ),
      'update_item' => __( 'Update Location' ),
      'add_new_item' => __( 'Add New Location' ),
      'new_item_name' => __( 'New Location Name' ),
      'menu_name' => __( 'Locations' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'mec_location', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}

/*add_action('add_meta_boxes', 'wporg_add_custom_box');
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
}*/

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
	case "Kuala Belait":
	case "Brunei Darussalam":
        $country="Brunei Darussalam";
		$flag="br";
        break;
    case "Phnom Penh":
	case "Siem Reap":
    case "Sihanoukville":
	case "Cambodia":
        $country="Cambodia";
		$flag="kh";
        break;
	case "Jakarta":
	case "Bogor":
	case "Medan":
	case "Yogyakarta":
	case "Surabaya":
	case "Bali":
	case "Bandung":
	case "Lombok":
	case "Mataram":
	case "Manado":
	case "Labuan Bajo":
	case "Jayapura":
	case "Semarang":
	case "Serpong":
	case "Indonesia":
        $country="Indonesia";
		$flag="id";
        break;
	case "Vientiane":
	case "Vang Vieng":
	case "Luang Prabang":
	case "Laos":
        $country="Laos";
		$flag="la";
        break;	
    case "Kuala Lumpur":
    case "Langkawi":
    case "Putrajaya":
    case "Kedah":
    case "Kuching":
    case "Penang":
    case "Selangor":
	case "Malaysia":
	case "Johor":
        $country="Malaysia";
		$flag="ml";
        break;
	case "Yangon":
	case "Naypyitaw":
	case "Nay Pyi Taw":
	case "Mandalay":
    case "Bagan":
	case "Myanmar":
        $country="Myanmar";
		$flag="mm";
        break;
	case "Manila":
	case "Metro Manila":
	case "Makati":
	case "Lapu-lapu City":
	case "Makati City":
	case "Laguna":
	case "Legazpi City":
	case "Los Baños":
	case "Paranaque City":
	case "Tagaytay":
	case "Davao":
	case "Bohol":
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
    case "Buriram":
    case "Chiang Mai":
    case "Khlong Luang":
    case "Nonthaburi":
    case "Phuket":
    case "Pattaya":
    case "Cha-am Hua Hin":	
	case "Thailand":
        $country="Thailand";
		$flag="th";
        break;
    case "Hanoi":
    case "Ha Noi":
    case "Ha Long City":
    case "Ho Chi Minh":
    case "Da Lat":
    case "Vinh Phuc":
    case "Da Nan":
    case "Da Nang":
    case "Hue City":
    case "Nha Trang":
	case "Vietnam":
        $country="Vietnam";
		$flag="vn";
        break;
	case "Shanghai":
	case "Changsa":
	case "Chengdu":
	case "Yunnan":
	case "Guiyang":
	case "Hainan":
	case "Beijing":
    case "Nanning":
    case "Xiamen":
    case "Xian":
    case "Sichuan":
    case "Shenzen":
    case "Hong Kong":
	case "China":
        $country="China";
		$flag="ch";
        break;
	case "Tokyo":
	case "Yokohama":
	case "Kyoto":
    case "Kanazawa":
    case "Fukuoka":
    case "Sendai":
    case "Nara":
    case "Niigata":
    case "Odawara":
    case "Osaka":
	case "Japan":
        $country="Japan";
		$flag="jp";
        break;
	case "Seoul":
	case "Busan":
	case "Changwon":
	case "Gyeongnam":
	case "Seongnam":
	case "Jeju":
	case "Daejeon":
	case "ROK":
	case "Incheon":
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
	case "Hyderabad":
        $country="India";
		$flag="in";
        break;	
	case "Astana":
        $country="Kazakhstan";
		$flag="kz";
        break;
    case "Tbilisi":
        $country="Georgia";
		$flag="ge";
        break;
	case "Baku":
        $country="Azerbaijan";
		$flag="az";
        break;	
	case "Frankfurt":
        $country="Germany";
		$flag="de";
        break;
	case "Nacka":
        $country="Sweden";
		$flag="sw";
        break;
	case "Nadi":
		$country="Fiji";
		$flag="fj";
		break;
	case "Colombo":
		$country="Sri Lanka";
		$flag="sl";
		break;
	case "Online Conference":
        $country="Online Conference";
		$flag="asean";
        break;
    default:
        $country="";
		$flag="";
	}
	$return = ['country'=>$country, 'flag'=>$flag];
	return ($return);
}
function akseki_get_mec_location($postID){
	
	if(!empty(get_the_terms( $postID, 'mec_location' ))){
	    $mec_location_obj = get_the_terms( $postID, 'mec_location' )[0];
	}else{
	    $mec_location_obj = get_the_terms( $postID, 'mec_location' );
	}
	if(!empty($mec_location_obj)){
		$mec_location = get_the_terms( $postID, 'mec_location' )[0]->name;
	}else{
		$mec_location = get_post_meta($postID, 'mec_location', true);	
	}
	return $mec_location;
}
function akseki_get_the_meta($postID){
	//$mec_location = get_post_meta($postID, 'mec_location', true);
	$mec_location = akseki_get_mec_location($postID);
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
		$return .= '<span class="meta-country">'.$mec_country['country'].'</span>&ensp;';
		//get_template_part("img/flags/".strtolower($mec_country).".svg");
		$return .= '<span class="roundflag">'.load_flags_svg($mec_country['flag']).'</span>';
		$return .= '</span>';
	}													
	$return .= '<span class="meta-comma"> </span>';
	//$return .= '<span class="meta-date">'.get_the_date().'</span>';
	//if article is future, look for SC. if not, just get the date
	$articledate = get_the_date('Y-m-d',$postID);
	$nowdate =  date('Y-m-d');
	$futurearticle = true;
	if($articledate < $nowdate){
		$futurearticle = false;
	}
	if($futurearticle == true){
		$return .= '<span class="meta-date">'.akseki_get_sc_noclass($postID).'</span>';
	}else{
		//$return .= '<span class="meta-date">'.get_the_date('j F Y',$postID).'</span>';
		$return .= '<span class="meta-date">'.akseki_get_sc($postID).'</span>';
	}
	return $return;
}
function akseki_get_the_flag($postID){
	//$mec_location = get_post_meta($postID, 'mec_location', true);
	$mec_location = akseki_get_mec_location($postID);
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

function akseki_get_shortname($longname, $post_ID, $limit=3){
	$longtitle = strip_tags($longname);
	$display_output = "";
	$shorttitle3 = '';
	$fixedtitle = '';
	$noshorttitle = false;
	preg_match('/\d\d*(:?st|nd|rd|th)/', $longtitle, $shorttitle);
	if(!empty($shorttitle)){
		$shorttitle3 = trim(strtolower($shorttitle[0]));		
	}else{
		preg_match('/(:?first|second|third|fourth|fifth|sixth|seventh|eighth|ninth|tenth|eleventh|twelfth|thirteenth|fourteenth|fifteenth|sixteenth|seventeenth|eighteenth|nineteenth|twentieth)/i', $longtitle, $shorttitle2);
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
		case "11th":
		case "eleventh":
			$fixedtitle="11th";
			break;
		case "12th":
		case "twelfth":
			$fixedtitle="12th";
			break;
		case "13th":
		case "thirteenth":
			$fixedtitle="13th";
			break;
		case "14th":
		case "fourteenth":
			$fixedtitle="14th";
			break;
		case "15th":
		case "fifteenth":
			$fixedtitle="15th";
			break;
		case "16th":
		case "sixteenth":
			$fixedtitle="16th";
			break;
		case "17th":
		case "seventeenth":
			$fixedtitle="17th";
			break;
		case "18th":
		case "eighteenth":
			$fixedtitle="18th";
			break;
		case "19th":
		case "nineteenth":
			$fixedtitle="19th";
			break;
		case "20th":
		case "twentieth":
			$fixedtitle="20th";
			break;
		default:
			$fixedtitle=$shorttitle3;
		}
	endif;
	if($noshorttitle==false){
		$display_output .= '<span class="numberer">';
		$display_output .= preg_replace('/(st|nd|rd|th)/', '<sup>$1</sup>', $fixedtitle);
		$display_output .= "</span>";
	    
	    /*$descats = get_categories(array('child_of' => 7));
		$view_list =  wp_list_pluck($descats, 'slug');*/
		$min_list = akseki_get_ministrial_categories();
		$dg_list = akseki_get_dg_categories();
		$som_list = akseki_get_som_categories();
		$wg_list = akseki_get_wg_categories();
		$otl_list = akseki_get_othlev_categories();
		$ott_list = akseki_get_ott_categories();
		$sumcpr = ['summit-level-statements','cpr-level'];
		$merge_list = array_merge($min_list,$dg_list,$som_list,$wg_list,$otl_list,$ott_list,$sumcpr);
		$curcats = get_the_category($post_ID);
		$curslugs = wp_list_pluck($curcats,'slug');
		$current_categories = array_intersect($merge_list,$curslugs);
		/*foreach($current_categories as $cat){
			if(in_array($cat->slug, $view_list)){
				$display_output .= ' '.$cat->name;
			}elseif(in_array($cat->slug, $som_list)){
				$display_output .= ' '.$cat->name;
			}elseif(in_array($cat->slug, $otl_list)){
				$display_output .= ' '.$cat->name;
			}elseif(in_array($cat->slug, $oth_list)){
				$display_output .= ' '.$cat->name;
			}elseif($cat->slug === 'summit-level-statements'){
				$display_output .= ' APT Summit';
			}elseif($cat->slug === 'cpr-level'){
				$display_output .= ' CPR+3';
			}elseif($cat->slug === 'aptwg'){
				$display_output .= ' CPRWG';
			}
		}*/
		$sm = akseki_get_sm($post_ID);
		foreach($current_categories as $cat){
			if($cat === 'summit-level-statements'){
				$display_output .= ' APT Summit';
			}elseif($cat === 'cpr-level'){
				$display_output .= ' CPR+3';
			}elseif($cat === 'asean3-student-camp' && !empty($sm)){
				// fix ordinal				
				$int_var = (int)filter_var($sm, FILTER_SANITIZE_NUMBER_INT); 
				if(!empty($int_var)){
					$display_output .= ' '.preg_replace('/(st|nd|rd|th)/', '<sup>$1</sup>', $sm);
				}else{
					$display_output .= ' '.$sm;
				}
			}else{
				$catobj = get_category_by_slug($cat);
				$display_output .= ' '.$catobj->name;
			}
		}
	}else{
		//special case for APT SOM
		$current_categories = get_the_category($post_ID);
		//insert preparatory text if exist
		preg_match('/(:?preparatory|preparation)/i', $longtitle, $prep);
		if(!empty($prep)){
			$prep = 'Prep ';		
		}else{
			$prep = '';
		}
		if(in_array("apt-som",wp_list_pluck($current_categories,'slug'))){
			$text = "APT SOM ".$prep."<span class='aptsom_month'>".get_the_date( 'F' )."</span>";
		}else{
			$text = $longname;
			if ($limit > 0 && str_word_count($text, 0) > $limit && has_tag("noshorttitle",$post_ID)==false) {
				//if has tag SM_
				$sm = akseki_get_sm($post_ID);
				if(!empty($sm)){
					$text = $sm;
				}else{
					$words = str_word_count($text, 2);
					$pos   = array_keys($words);
					$text  = substr($text, 0, $pos[$limit]) . '&hellip;';
				}
			}
		}
		$display_output .= $text;
	}
	
	return $display_output;
}

//list of ministrial level categories slug
/*function akseki_get_ministrial_categories(){
	$appear = ['dgicm3','apt-foreign-ministers-meeting','ammtc3','aem3','afmgm3','m-atm3','amaf3','amem3','amme3-emm','ammswd3','ammy3','accsm3','almm3','amca3','amri3','aptemm','ahmm3'];
	return $appear;
}
function akseki_get_som_categories(){
	$somcatid = 280;//cat id of som categories
	$appear = [];
	$children = get_categories(array('parent'=>$somcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_othlev_categories(){
	$otlcatid = 295;//cat id of som categories
	$appear = [];
	$children = get_categories(array('parent'=>$otlcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}*/
function akseki_get_ministrial_categories(){
	$somcatid = 43;//cat id of ministrial categories
	$appear = [];
	$children = get_categories(array('parent'=>$somcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_dg_categories(){
	$somcatid = 377;//cat id of dg categories
	$appear = [];
	$children = get_categories(array('parent'=>$somcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_som_categories(){
	$somcatid = 280;//cat id of som categories
	$appear = [];
	$children = get_categories(array('parent'=>$somcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_wg_categories(){
	$somcatid = 373;//cat id of wg ctegories
	$appear = [];
	$children = get_categories(array('parent'=>$somcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_othlev_categories(){
	$otlcatid = 295;//cat id of other levels categories
	$appear = [];
	$children = get_categories(array('parent'=>$otlcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_ott_categories(){
	$otlcatid = 399;//cat id of other trecks categories
	$appear = [];
	$children = get_categories(array('parent'=>$otlcatid));
	foreach($children as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		foreach($grandchildren as $grandchild){
			$appear[] = $grandchild->slug;
		}		
	}	
	return $appear;
}
function akseki_get_sectoral_categories(){
	$appear = ['economic-cooperations','political-cooperations','socio-cultural-cooperations'];
	return $appear;
}
function akseki_get_commision_categories(){
	$appear = ['ministerial-level-statements','summit-level-statements'];
	//$appear = ['ministerial-level-statements'];
	return $appear;
}
function akseki_post_is_in_a_subcategory( $categories, $_post = null ) {
    foreach ( (array) $categories as $category ) {
        // get_term_children() only accepts integer ID
        $subcats = get_term_children( (int) $category, 'category' );
        if ( $subcats && in_category( $subcats, $_post ) )
            return true;
    }
    return false;
}
function akseki_get_other_categories(){
	$othcatid = 45;//cat id of other categories
	$appear = [];
	$children = get_categories(array('parent'=>$othcatid));
	foreach($children as $child){
		$appear[] = $child->slug;
	}	
	return $appear;
}

//get category descendents of statements category
function akseki_get_descat($curcatidarr){
	$descats = get_categories(array('child_of' => 7));
	$descatspluck =  wp_list_pluck($descats, 'term_id');//print_r($curcatidarr);print_r($descatspluck);
	$current_cat = array_intersect($curcatidarr, $descatspluck);//print_r($current_cat);
	if(!empty($current_cat)){
		$return = $current_cat[0];
	}else{
		$return = '';
	}
	//return the id of the found category
	return $return;
}

//get theme of a post in a category, return id of page of the theme
function akseki_get_theme_from_id($id,$idtype){
	if($idtype=="post"){
		$ftn_categories = get_the_category($id);
		/*$descats = get_categories(array('child_of' => 7));
		$cats = wp_list_pluck($descats, 'slug');
		foreach($ftn_categories as $cat){
			$aa[] = $cat->slug;
		}		
		$current_slug = array_intersect($aa, $cats);
		if(empty($current_slug)){
			$return = '';
		}		
		$target_slug = $current_slug[0];*/
		$sumcat = array("summit-level-statements");
		$mincat = akseki_get_ministrial_categories();
		$dgcat = akseki_get_dg_categories();
		$cprcat = array("cpr-level");
		$somcat = akseki_get_som_categories();
		$wgcat = akseki_get_wg_categories();
		$otlcat = akseki_get_othlev_categories();
		$ottcat = akseki_get_ott_categories();
		$descats = array_merge($sumcat,$mincat,$dgcat,$cprcat,$somcat,$wgcat,$otlcat,$ottcat);
		foreach($ftn_categories as $cat){
			$aa[] = $cat->slug;
		}		
		$current_slug = array_intersect($aa, $descats);
		$current_slug = reset($current_slug);
		if(empty($current_slug)){
			$return = '';
		}		
		$target_slug = $current_slug;//print_r($current_slug);
	}elseif($idtype=="category"){
		$targetcat = get_category($id);
		$target_slug = $targetcat->slug;
	}else{
		$target_slug = "";
	}
	$themes = get_children(5733);
	$topics_arr = [];	
	foreach($themes as $theme){		
		$tpc_topics = get_post_custom_values( "tpc_topics", $theme->ID);
		$extos = explode(",",$tpc_topics[0]);
		foreach($extos as $exto){
			//$topics_arr[$exto] = $theme->post_title;
			$topics_arr[$exto] = $theme->ID;
		}		
	}	
	if(array_key_exists($target_slug, $topics_arr)) {
		$return = $topics_arr[$target_slug];
	} else {
		$return = '';
	}	//echo("<pre>");print_r($topics_arr);print_r($target_slug);print_r($return);echo("</pre>");
	return $return;
}

//get theme/topic of a post in a category, return id of the category
function akseki_get_level_from_id($id,$idtype,$pillarorlevel="level"){
	//get the category objects
	if($idtype=="post"){
		$descats = get_categories(array('child_of' => 7));
		$cats = wp_list_pluck($descats, 'slug');
		
		$ftn_categories = get_the_category($id);
		/*$cats = akseki_get_ministrial_categories();
		$cats[] = akseki_get_som_categories();
		$cats[] = akseki_get_othlev_categories();
		$cats[] = 'summit-level-statements';*/
		foreach($ftn_categories as $cat){
			$aa[] = $cat->slug;
		}		
		$current_slug = array_intersect($aa, $cats);
		if(empty($current_slug)){
			$return = '';
		}
		$gpa = get_category_by_slug($current_slug[0]);
		
		//echo("<pre>");print_r($levname);echo("</pre>");
	}elseif($idtype=="category"){
		$gpa = get_category($id);
	}else{
		$return = '';
	}

	$gpa_anc = get_ancestors($gpa->term_id,'category');
	//for non multivelvel, add its original category
	if($gpa->term_id == 41){//41 is summit level statements
		$gpa_anc[] = 41;
	}
	
	if($pillarorlevel=="pillar"){
		$parent = get_category($gpa->parent);
		$pn = $parent->slug;
		if(str_contains($pn,"political")){
			$levid=63;
		}elseif(str_contains($pn,"economic")){
			$levid=47;
		}elseif(str_contains($pn,"socio")){
			$levid=54;
		}
	}else{
		if(in_array(41,$gpa_anc)){//summit
			$levid=41;
		}elseif(in_array(43,$gpa_anc)){//ministerial
			$levid=43;
		}elseif(in_array(280,$gpa_anc)){//som
			$levid=280;
		}elseif(in_array(295,$gpa_anc)){//other
			$levid=295;
		}
		
		if(in_array(41,$gpa_anc)){//summit
			$levid=41;
		}elseif(in_array(43,$gpa_anc)){//ministerial
			$levid=43;
		}elseif(in_array(377,$gpa_anc)){//dg
			$levid=377;
		}elseif(in_array(409,$gpa_anc)){//cpr
			$levid=409;
		}elseif(in_array(280,$gpa_anc)){//som
			$levid=280;
		}elseif(in_array(373,$gpa_anc)){//wg
			$levid=373;
		}elseif(in_array(295,$gpa_anc)){//other
			$levid=295;
		}elseif(in_array(399,$gpa_anc)){//other tracks
			$levid=399;
		}
		
	}
	$return = '';
	if(isset($levid)){
		$return=$levid;
	}
	return $return;
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
				$area = 'Political Security';
				break;
			case 46:
			    $area = 'Transnational Crime';
				break;
		    case 48:
		        $area = 'Economic Ministers';
				break;
			case 49:
			    $area = 'Finance Ministers and Central Bank Governors';
				break;
			case 50:
			    $area = 'Tourism';
				break;
			case 51:			
			case 52:
			case 53:
			case 55:			
			case 56:			
			case 57:
			case 59:			
				$exploded = explode(' on ', $cat->description);
				$area = $exploded[1];
				break;
			case 58:
			    $area = 'Labour';
				break;
		    case 60:
		        $area = 'Information';
				break;
			case 61:
			    $area = 'Education';
				break;
			case 62:
				$exploded = explode(' Ministers', $cat->description);
				$exploded2 = explode(' ', $exploded[0]);
				$area = end($exploded2);
				break;
			case 259:
			    $area = 'Immigration';
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
		/*if($index == 0){
			$return .= '<td rowspan='.count($cats).' class="collapse show collapseLeader" data-parent="#accordionLevel">';
			$return .= '<a href="'.get_category_link(41).'">ASEAN Plus Three Summit (APT Summit)</a>';
			$return .= '</td>';
		}*/
		
		//the ministerial collapsible
		$return .= '<td class="" data-parent="#accordionLevel">';
		$return .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->description .' ('.$cat->name.')</a>';
		$return .= '</td>';
		$return .= '</tr>';
		
	}
	return '<table class="w-100">'.$return.'</table>';	
}
add_shortcode('akseki_aoc','akseki_aoc');

//handle special meetings
function akseki_get_sm($id){
	$thetags = get_the_tags($id);
	$SM = '';
	if(!empty($thetags)){
		foreach($thetags as $thetag){
			if(preg_match('/^SM_.+/',$thetag->name)){
				$SM = $thetag->name;
			}
		}
	}
	return substr($SM,3);
}

//handle dates in agenda (future posts)
function akseki_get_sc_raw($id){
	$thetags = get_the_tags($id);
	$SC = '';
	if(!empty($thetags)){
		foreach($thetags as $thetag){
			if(preg_match('/^SC_.+/',$thetag->name)){
				$SC = $thetag->name;
			}
		}
	}
	return $SC;
}

function akseki_get_sc($id){
	$SC = akseki_get_sc_raw($id);
	$thedate = '';
	if($SC=="SC_year"){
		$thedate .= '<span class="">'.get_the_date('Y', $id).'</span>';	
	}elseif($SC=="SC_month"){
		$thedate .= '<span class="">'.get_the_date('F', $id).'</span>&nbsp;';
		$thedate .= '<span class="">'.get_the_date('Y', $id).'</span>';
	}elseif($SC=="SC_nodate"){
		$thedate .= '<span class="align-self-center">tbd</span>';
	}else{
		$thedate .= '<span class="">'.get_the_date('j', $id).'</span>&nbsp;';
		$thedate .= '<span class="">'.get_the_date('F', $id).'</span>&nbsp;';
		$thedate .= '<span class="">'.get_the_date('Y', $id).'</span>';
	}
	return $thedate;
}
function akseki_get_sc_noclass($id){
	$SC = akseki_get_sc_raw($id);
	$thedate = '';
	if($SC=="SC_year"){
		$thedate .= '<span>'.get_the_date('Y', $id).'</span>';	
	}elseif($SC=="SC_month"){
		$thedate .= '<span>'.get_the_date('F', $id).'</span>&nbsp;';
		$thedate .= '<span>'.get_the_date('Y', $id).'</span>';
	}elseif($SC=="SC_nodate"){
		$thedate .= '<span>tbd</span>';
	}else{
		$thedate .= '<span>'.get_the_date('j', $id).'</span>&nbsp;';
		$thedate .= '<span>'.get_the_date('F', $id).'</span>&nbsp;';
		$thedate .= '<span>'.get_the_date('Y', $id).'</span>';
	}
	return $thedate;
}
//get future post in the category
function akseki_get_future_post_in_category($catid){
	$query = new WP_Query(array(
		'cat'=> $catid,
		'post_status' => 'future',
		'orderby'           => 'date',
		'order'             => 'ASC'
		)
	);
	$return = [];
	if( $query->have_posts() ) :
		while ( $query->have_posts() ):
			$query->the_post();
			array_push($return, get_the_ID());
		endwhile;
	endif;
	return $return;
}

// Remove pagination on listing per category index page
// may need to enable / disable for certain category later
function no_nopaging($query) {
    if (is_category() && $query->is_main_query()) {
        $query->set('nopaging', 1);
    }
}
add_action('parse_query', 'no_nopaging');

//akseki shortcodes
function akseki_cat_children($atts){
	$atts = shortcode_atts(array(
        'parent' => 0,
		'style' => 'card-group',
    ), $atts);
    $return = '';
	$categories=get_categories(
		array( 'parent' => $atts['parent'] )
	);
	if($atts['style'] == 'card-group'){
		$return .= '<div class="card bg-light"><div class="card-body">';
		$return .= '<h4 class="card-title mb-0">'.get_cat_name($atts['parent']).'</h4></div>';
		$return .= '<ul class="list-group list-group-flush">';
		foreach($categories as $cat){
			$return .= '<li class="list-group-item btn btn-light text-left"><a href="'.get_category_link($cat->term_id).'">&raquo; '.$cat->name.'</a></li>';
		}
		$return .= '</ul></div>';
	}elseif($atts['style'] == 'buttons'){
		$return .= '<div class="row mr-0 mb-2">';
		foreach($categories as $cat){
			$return .= '<a href="'.get_category_link($cat->term_id).'" class="btn btn-secondary col m-1" style="width:49%"><h5>'.$cat->name.'</h5><hr class="mt-0 mb-2">'.$cat->description.'</a>';
		}
		$return .= '</div>';
	}elseif($atts['style'] == 'withlatestpost-economic'){
		$return .= '<div class="m-0 w-100">';
		foreach($categories as $cat){
			$latpos = get_posts(array('category' => $cat->term_id, 'numberposts' => 1));
			//print_r($latpos);
			foreach($latpos as $latpo){
				if(has_post_thumbnail($latpo->ID)){
					$thethumb = get_the_post_thumbnail_url( $latpo->ID, "medium-large" );
				}else{
					$thethumb = wp_get_attachment_image_url( 1007, "medium-large" );
				}
			}
			$return .= '<img src="'.$thethumb.'" class="rounded m-1 w-100">';
			$return .= '<a href="'.get_category_link($cat->term_id).'" class="btn btn-secondary m-1 w-100"><h5>'.$cat->name.'</h5><hr class="mt-0 mb-2">'.$cat->description.'</a>';
		}
		$return .= '</div>';
	}elseif($atts['style'] == 'withlatestpost-socio'){
		$return .= '<div class="w-100 m-0 d-flex flex-wrap align-content-around">';
		foreach($categories as $cat){
			$latpos = get_posts(array('category' => $cat->term_id, 'numberposts' => 1));
			//print_r($latpos);
			foreach($latpos as $latpo){
				if(has_post_thumbnail($latpo->ID)){
					$thethumb = get_the_post_thumbnail_url( $latpo->ID, "medium" );
				}else{
					$thethumb = wp_get_attachment_image_url( 1007, "medium" );
				}
			}
			$return .= '<img src="'.$thethumb.'" class="rounded m-1" style="height:140px;width:auto;">';
			$return .= '<a href="'.get_category_link($cat->term_id).'" class="btn btn-secondary m-1" style="flex-grow:1;max-width:200px;"><h5>'.$cat->name.'</h5><hr class="mt-0 mb-2">'.$cat->description.'</a>';
		}
		$return .= '</div>';
	}
	return $return;
}
add_shortcode('akseki_cat_children', 'akseki_cat_children');

function akseki_get_recent_posts($atts){
	$atts = shortcode_atts(
        array(
            'cat' => 0,
			'limit' => 0,
			'tag' => '',			
        ), $atts
	);
	$args = array(
		'cat' => $atts['cat'],
		'numberposts' => $atts['limit'],
		'tag' => $atts['tag'],
	);
	//$category_posts = new WP_Query($args);
	//change wp_query object with get_posts
	$category_posts = get_posts($args);
	$return = '';
	if(!empty($category_posts)){		
		$return .= '<div class="card-group">'; 	
		foreach($category_posts as $post){			
			if(has_post_thumbnail($post->ID)){
				$thethumb = get_the_post_thumbnail_url( $post->ID, "thumbnail" );
			}else{
				$thethumb = wp_get_attachment_image_url( 1007, "thumbnail" );
			}
			$return .= '<div class="card">';
			$return .= '<img class="card-img-top" src="'.$thethumb.'" alt="Card image cap">';
			$return .= '<div class="card-body p-3 text-center">';
			$return .= '<h5 class="card-title mb-0"><a href="'.get_permalink($post->ID).'">'.akseki_get_shortname($post->post_title, $post->ID, 3).'</a></h5>';
			//$return .= '<p class="card-text"></p>';
			$return .= '</div>';
			$return .= '<ul class="list-group list-group-flush">';
			$metas = explode('<span class="meta-comma"> </span>',akseki_get_the_meta($post->ID));
			foreach($metas as $meta){
				$return .= '<li class="list-group-item bg-light text-center"><small class="text-muted">'.$meta.'</small></li>';
			}
			$return .= '</ul>';
			//$return .= '<div class="card-footer"><small class="text-muted text-muted w-100 d-flex justify-content-between">'.akseki_get_the_meta(get_the_ID()).'</small></div>';
			$return .= '</div>';
		}
		$return .= '</div>';		
	}
    return ($return ? $return : false);
	
}
add_shortcode('akseki_get_recent_posts', 'akseki_get_recent_posts');

//akseki limited access
function akseki_limited_access(){
	$alanonce = wp_create_nonce( 'alanonce' );
	$return = '<form name="alaform" id="alaform" action="'.esc_url( admin_url( 'admin-post.php' ) ).'?action=handle_limited_access" method="post">
					<input type="hidden" name="alanonce" value="'.$alanonce.'" hidden>
					<input type="hidden" name="alaname" id="alaname" class="input" value="LimitedAccess" hidden>
					<label for="alapass">Password:</label>
					<input type="password" name="alapass" id="alapass" spellcheck="false" class="input" value="" size="20">
					<input type="submit" name="submit" id="submit" class="button btn-primary" value="Enter">
				</form>';
	return($return);
}
add_shortcode('akseki_limited_access', 'akseki_limited_access');

function akseki_handle_alaform(){
	$alapass=$_REQUEST['alapass'];
	//if not logged in
	$creds = array(
		'user_login'    => 'LimitedAccess',
		'user_password' => $alapass,
		'remember'      => false
	);
	echo('$alapass');
}

add_action( 'admin_post_nopriv_handle_limited_access', 'akseki_handle_alaform');

//check if user already logged in or not
function add_login_check_limited_access()
{
    if ( is_user_logged_in() && is_page(4452) ) {
        wp_redirect('/limited-access-documents-2');
        exit;
    }
    if (isset($_GET['loginf'])) {
		//The parameter you need is present
		echo('<div class="w-auto alert alert-primary" role="alert">Failed password</div>');
	}
}
add_shortcode('logincheck', 'add_login_check_limited_access');

//on limited access page on failed login redirect to its original/referer page
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      //does referrer url has ? sign
	  if(!strstr($referrer,"?")){
		  $loginf = "?loginf=failed";
	  }else{
		  $loginf = "&loginf=failed";
	  }
      wp_redirect( $referrer . $loginf );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
//custom field dropdown display limit
add_filter( 'postmeta_form_limit', 'meta_limit_increase' );
function meta_limit_increase( $limit ) {
    return 200;
}
//include DASHICON
function enable_frontend_dashicons() {
  wp_enqueue_style( 'dashicons' );
}

add_action( 'wp_enqueue_scripts', 'enable_frontend_dashicons' );
//add extra field to category
function addExtraFieldToCat(){
    $cat_extra = get_term_meta($_GET['tag_ID'], '_catextra', true);
    ?> 
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_extra"><?php _e('Category Extra Property'); ?></label></th>
        <td>
        
		<select name="cat_extra" id="cat_extra">
			<option value="">none</option>
			<option value="has_no_listing"<?php echo(($cat_extra=="has_no_listing")?" selected":""); ?>>Has no Listing</option>
			<option value="inactive"<?php echo(($cat_extra=="inactive")?" selected":""); ?>>Inactive</option>
		</select>
            <span class="description"><?php _e('Extra Property for category '); ?></span>
        </td>
    </tr>
    <?php
	
}
add_action ( 'edit_category_form_fields', 'addExtraFieldToCat');

function saveCategoryFields() {
    if ( isset( $_POST['cat_extra'] ) ) {
        update_term_meta($_POST['tag_ID'], '_catextra', $_POST['cat_extra']);
    }
}
add_action ( 'edited_category', 'saveCategoryFields');

//handle ajax for archives
add_action("wp_ajax_archiveAjax", "archiveAjax");
add_action("wp_ajax_nopriv_archiveAjax", "archiveAjax");
function archiveAjax() {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "nonce")) {
      exit("No naughty business please");
	}
	$year = $_REQUEST['year'];
	//$SAA_cats = akseki_get_ministrial_categories();
	//array_push($SAA_cats,'summit-level-statements','cpr-level');
	$SAA_cats = get_term_children(7,"category");
	$SAA_query = new WP_Query(array(
		//'category_name'=> implode( ',', $SAA_cats ),
		'cat'				=> $SAA_cats,
		'post_status' => 'publish',
		'orderby'           => 'date',
		'order'             => 'DESC',
		'posts_per_page' =>-1,
		'date_query' => array(
				'relation' => 'OR',
				array('year' => $year)
			),
		)
	);
	if( $SAA_query->have_posts() ) :
		$tempyear = $tempmonth = $tempdtdcount = 0;
		$echo = '';
		$echo .= '<h3><strong>Year: '.$year.'</strong></h3>';
		$echo .= '<div class="archive-inner-content" style="background-image: linear-gradient(to right, rgb(255, 255, 255) 45%, rgba(255, 255, 255, 0) 50%), url(\''.get_template_directory_uri().'/img/summitlogo/'.$year.'.jpg\'); background-repeat: no-repeat; background-position: right center; background-size: contain;">';
		$images = [];
		while($SAA_query->have_posts()):
			$SAA_query->the_post();
			//display a random image from query result
			/*if (has_post_thumbnail(get_the_ID())):
			  $image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
			  $images [] = $image;			  
			endif;*/
			$firstbuttonaria = "false";
			$qyear = get_the_date('Y');
			if($qyear !== $tempyear){
				if($tempdtdcount==0){
					//first element
					$echo .= '<div class="agenda-element">';
				}else{
					//other elements in the middle
					$echo .= '</div><div class="agenda-element">';
				}
				//$is_dtd .= '<h3 class="font-weight-bold mt-0 pt-3 mb-1">'.$qyear.'</h3>'; 
				$tempyear = $qyear;
				$tempdtdcount = 1;
			}
			$qmonth = get_the_date('ny');
			if($qmonth !== $tempmonth){
				$fy = get_the_date("F Y");
				$echo .= '<button class="mt-1 border-bottom font-weight-bold text-left w-100 btn mb-1 collapser-button" type="button" data-toggle="collapse" data-target="#collapse'.$qmonth.'" aria-expanded="'.$firstbuttonaria.'" aria-controls="collapse'.$qmonth.'"><span class="ml-1">'.$fy.'</span></button>';
				$tempmonth = $qmonth;
				//++$firstbutton;
			}
			
			if(has_tag("SC_month")){
				$datedisplay = '<span class="badge badge-secondary">'.get_the_date('F Y').'</span>';
			}else{
				$datedisplay = '<span class="badge badge-secondary">'.get_the_date('j F Y').'</span>';
			}
			
			$mecloc = akseki_get_mec_location(get_the_ID());
			if(empty($mecloc) or $mecloc == '' or $mecloc == 'tbd'){
				$flagdisplay = '';
			}else{
				$flagdisplay = '&ensp;'.akseki_get_the_flag(get_the_ID());
			}
			$qcats = get_the_category();
			$qcatsarr = wp_list_pluck( $qcats, 'slug' );
			
			$intersector = array_merge(akseki_get_ministrial_categories(),akseki_get_dg_categories(),akseki_get_som_categories(),akseki_get_wg_categories(),akseki_get_othlev_categories(),akseki_get_ott_categories());
			array_push($intersector,'summit-level-statements','cpr-level');
			//$saacatsarr = wp_list_pluck( $SAA_cats, 'slug' );
			$qcatint = array_intersect($qcatsarr,$intersector);
			$qcatObj = get_category_by_slug(implode($qcatint));
			//echo('<pre>');print_r($qcatObj);echo('</pre>');
			//borders, primary if summit, dark if ministerial
			if($qcatObj->slug == "summit-level-statements"){
				$border = " border border-primary rounded";
			}elseif(in_array($qcatObj->slug,akseki_get_ministrial_categories())){
				$border = " border border-dark rounded";
			}else{
				$border = "";
			}
			$catdisplay = '<br/><em class="badge badge-light"><a title="'.$qcatObj->name.' ('.$qcatObj->description.')" class="text-dark font-weight-normal" href="'.get_category_link($qcatObj).'">'.$qcatObj->description.'</a></em>';
			
			if(has_tag("hasnocontent")){
				$qitemname = '<span class="bg-white px-1">'.akseki_get_shortname(get_the_title(), get_the_ID()).'</span>';
			}else{
				$qitemname = '<a class="bg-white px-1" href="'.get_the_permalink().'">'.akseki_get_shortname(get_the_title(), get_the_ID()).'</a>';
			}
			
			$echo .= '<div class="collapse mx-4 p-1'.$border.'" id="collapse'.$qmonth.'">'.$datedisplay.$flagdisplay.'&ensp;'.$qitemname.$catdisplay.'</div>';			
		endwhile;
		$echo .= '</div></div>';
		
		/*$k = array_rand($images);
		$v = $images[$k];
		$echo0 .= ' style="background-image:url('.$v.'); background-repeat: no-repeat; background-position: right center; background-size: contain;" ';*/
		//$image = "|||".implode(",",$images);
		echo($echo);
	endif;
	wp_reset_postdata();
	die;
}

//get category descriptors
function echo_category_descriptor($current_category_id){
	$catdesc_echo = '';
	$catdesc_children = get_children(3236);
	$current_category_obj = get_category($current_category_id);
	foreach($catdesc_children as $child):
	    
	    //if(urlencode(get_queried_object()->name) == urlencode($child->post_title)):
		if($current_category_obj->name === $child->post_title):
		    
			$catdesc_content = $child->post_content;
			if ( has_post_thumbnail($child->ID) ) :
				$catdesc_echo .= '
				<style>
					.category-'.$current_category_id.' .ministerial-sidebar{padding-right:0;}
					.category-'.$current_category_id.' .ministerial-sidebar h3{width:100%;}
					.category-'.$current_category_id.' header h1{margin-top:10px;}
					.category-'.$current_category_id.' header{
						background-image: linear-gradient(to right, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0)), url("'.get_the_post_thumbnail_url($child->ID).'");
						background-repeat:none;
						background-position: center center;
						background-size:cover;
						overflow:hidden;
					}
				</style>
				';
			endif;
		endif;
	endforeach;	
	if(!empty($catdesc_content)):
		$catdesc_echo .= '<div class="catdesc list-group-item w-100 rounded bg-secondary p-3 mb-3">';
		$catdesc_echo .= $catdesc_content;			
		$catdesc_echo .= '</div>';				
	endif;
	return($catdesc_echo);
	//end cat desc
}

//level resources
function akseki_get_level_resources($level_id){
	$level_obj = get_category($level_id);
	$pillars=get_categories(array('parent'=>$level_id));
	$sc2 = '';
	foreach($pillars as $pillar){
		$topics=get_categories(array('parent'=>$pillar->term_id));
		$sc4 = '';
		foreach($topics as $topic){
			//handle no listing categories
			$cat_extra = get_term_meta( $topic->term_id, '_catextra', true );
			//print_r($cat_extra);
			$extra_title = '<h5><u>'.$topic->name.'</u></h5>';
			if($cat_extra == "has_no_listing"){
				$sc5 = echo_category_descriptor($topic->term_id).'<em class="float-right"><a href="'.get_category_link($topic->term_id).'">more about '.$topic->name.'&hellip;</a></em>';
			}else{
				$sc5 = '[catlist id='.$topic->term_id.' template=akseki_lcptemplate2 numberposts=-1]';
				
			}
			$sc4 .= '[su_tab title="<h5>'.$topic->name.'</h5><em>'.$topic->description.'</em>" disabled="no" anchor="" url="" target="blank" class=""]'.$sc5.'[/su_tab]';
			
		}
		$sc3 = '';
		$te_arr = akseki_get_themes_in_pillar($pillar->term_id);
		$themesecho = '';
		if(!empty($te_arr)){
			foreach($te_arr as $keytheme=>$theme){
				$themesecho .= '<a class="badge badge-secondary" href="'.get_permalink($keytheme).'">'.$theme.'</a>&ensp;';
			}
		}
		if(!empty($themesecho)){
			$sc3 .= '<div class="w-100 p-2 text-right" style="background-color:#eee!important;"><em>&#10150; Themes in '.$pillar->name.' :</em>&emsp;'.$themesecho.'</div>';
		}
		$sc3 .= '[su_tabs style="default" active="1" vertical="yes" class=""]'.$sc4.'[/su_tabs]';
		//themes
		
		$sc2 .= '[su_spoiler title="'.$pillar->name.'" open="no" style="default" icon="plus" anchor=""]'.$sc3.'[/su_spoiler]<hr class="my-2">';
	}
	$spoilercontent = do_shortcode('[su_accordion class="b_acc ml-4 '.$level_obj->slug.'"]'.$sc2.'[/su_accordion]');
	
	return $spoilercontent;
}

function akseki_get_themes_in_pillar($pillar_id){
	//returns an associative array of id=>name
	$themes = get_children(5733);
	$pil_obj = get_category($pillar_id);
	$return = '';
	$themes_arr = [];
	foreach($themes as $themepage){
		$tpc_pillar = get_post_custom_values( "tpc_pillar", $themepage->ID);
		//$tpc_topics = get_post_custom_values( "tpc_topics", $themepage->ID);
		//print_r($tpc_pillar[0]);
		//print_r($pil_obj->slug);
		if(str_starts_with($pil_obj->slug,$tpc_pillar[0])){
			$themes_arr[$themepage->ID] = $themepage->post_title;
		}
	}
	/*if(!empty($themes_arr)){
		foreach($themes_arr as $keytheme=>$theme){
			$return .= '<a class="badge badge-secondary" href="'.get_permalink($keytheme).'">'.$theme.'</a>&ensp;';
		}
		
	}*/
	return $themes_arr;
	//return $return;
}


function notifyauthor($post_id) {
    // Check if notification already sent for this post
    if (get_post_meta($post_id, '_notification_sent', true)) {
        return; // Email already sent, exit
    }
    
    $postm = get_post($post_id);
    
    // Only send for published posts
    if ($postm->post_status !== 'publish' || $postm->post_type !== 'post') {
        return;
    }
    
    if(has_tag("hasnocontent",$post_id)){
        $hastag = "<li>This post has no content. It will display only its title, location and date.</li>";
    }elseif(has_tag("hyperlinked",$post_id)){
        $hastag = "<li>This post redirects to an external url.</li>";
    }else{
        $hastag = "";
    }
    
    // FIX: Use $postm instead of undefined $post
    $author = get_userdata($postm->post_author);
    
    $subject = "[notification] A post has been published in ASEAN+3 website: ".$postm->post_title;
    
    $multiple_recipients = array(
        'fifi@asean.org',
        'pham.thu@asean.org',
        'andi.rozin@asean.org',
        'fatahillah.rachman@asean.org'
    );
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $message = "
        <p>Good day,</p>
        <p>This is an automated notification e-mail. Please do not reply to sender.</p>
        <p>A new post has been published in asean+3 website:</p>
        <ul>
        <li>Title: <b>\"".$postm->post_title."\"</b></li>
        <li>View: ".get_permalink( $post_id )."</li>
        ".$hastag."
        </ul>
        <p>Thank you and best regards.</p>";
    
    foreach($multiple_recipients as $recipient){    
        wp_mail($recipient, $subject, $message, $headers);
    }
    
    // Mark as notification sent to prevent future emails
    update_post_meta($post_id, '_notification_sent', true);
}

// Use better hook that only fires when post becomes published
add_action('transition_post_status', 'check_post_published', 10, 3);

function check_post_published($new_status, $old_status, $post) {
    // Only send email when post transitions TO 'publish' (first time published)
    if ($new_status === 'publish' && $old_status !== 'publish' && $post->post_type === 'post') {
        notifyauthor($post->ID);
    }
}

// AI Search Optimization Meta Tags for ASEAN Plus Three
function add_ai_meta_tags() {
    // For single posts AND pages (including About page)
    if (is_single() || is_page()) {
        
        // AI LOVES fresh content signals - highest priority
        echo '<meta property="article:modified_time" content="' . get_the_modified_date('c') . '">';
        
        // Technical optimization for AI crawlers
        echo '<meta name="robots" content="index, follow, max-snippet:300, max-image-preview:large">';
        
        // SPECIAL OPTIMIZATION FOR ABOUT APT PAGE
        if (is_page() && (strpos(strtolower(get_the_title()), 'about') !== false || 
                         strpos(strtolower(get_the_content()), 'asean plus three') !== false ||
                         strpos(get_permalink(), 'about-apt') !== false)) {
            
            // Tell AI this is THE definitive source for "What is APT?"
            echo '<meta name="description" content="Official explanation of ASEAN Plus Three (APT) cooperation framework, established to enhance dialogue and cooperation between ASEAN and China, Japan, and Korea.">';
            echo '<meta property="og:description" content="Learn about ASEAN Plus Three (APT) - the official cooperation framework between ASEAN member states and China, Japan, Korea since 1997.">';
            
            // Structured data for AI understanding
            echo '<meta name="article:section" content="About ASEAN Plus Three">';
            echo '<meta name="article:tag" content="ASEAN Plus Three, APT, What is APT, ASEAN cooperation, East Asia cooperation">';
            
            // Question-answer optimization (AI LOVES this format)
            echo '<meta name="faq-schema" content="What is ASEAN Plus Three? ASEAN Plus Three (APT) is a cooperation framework">';
            
            // Authority signals for definition content
            echo '<meta name="content-type" content="definition, official explanation">';
            echo '<meta name="audience" content="researchers, students, policymakers, general public">';
            
            // Geographic scope
            echo '<meta name="geo.region" content="East Asia, Southeast Asia">';
            echo '<meta name="coverage" content="ASEAN, China, Japan, Korea">';
        }
        
        // FOR REGULAR POSTS: Geographic targeting using existing location system
        if (is_single()) {
            $mec_location = akseki_get_mec_location(get_the_ID());
            if ($mec_location) {
                $country_data = get_the_country($mec_location);
                if (!empty($country_data['country'])) {
                    echo '<meta name="geo.region" content="' . $country_data['country'] . '">';
                    echo '<meta name="geo.placename" content="' . $mec_location . '">';
                }
            }
        }
        
        // Fallback geographic targeting for tagged international content
        if (has_tag(['china', 'asean', 'europe', 'africa', 'aseanplusthree', 'asean+3', 'APT', 'southeast-asia', 'east-asia', 'diplomacy', 'international'])) {
            echo '<meta name="geo.region" content="International">';
        }
        
        // Content type signals for AI understanding (POSTS ONLY)
        if (is_single()) {
            $categories = get_the_category();
            $cat_slugs = wp_list_pluck($categories, 'slug');
            
            // Summit level content
            if (in_array('summit-level-statements', $cat_slugs)) {
                echo '<meta name="article:section" content="Summit Diplomacy">';
            }
            // Ministerial level content  
            elseif (array_intersect($cat_slugs, akseki_get_ministrial_categories())) {
                echo '<meta name="article:section" content="Ministerial Cooperation">';
            }
            // SOM level content
            elseif (array_intersect($cat_slugs, akseki_get_som_categories())) {
                echo '<meta name="article:section" content="Senior Officials Meetings">';
            }
            // General international affairs
            else {
                echo '<meta name="article:section" content="International Affairs">';
            }
        }
        
        // Author and publication info for AI credibility
        echo '<meta name="article:author" content="ASEAN Plus Three">';
        echo '<meta name="article:publisher" content="ASEAN Plus Three Cooperation">';
        
        // Language and audience targeting
        echo '<meta name="content-language" content="en">';
        echo '<meta name="audience" content="policymakers, diplomats, researchers">';
        
        // AI citation optimization
        echo '<meta name="citation-style" content="academic">';
        echo '<meta name="source-credibility" content="official, governmental">';
    }
}
add_action('wp_head', 'add_ai_meta_tags');

// BONUS: Add structured data for About APT page
function add_apt_structured_data() {
    if (is_page() && (strpos(get_permalink(), 'about-apt') !== false || 
                     strpos(strtolower(get_the_title()), 'about') !== false)) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "AboutPage",
            "name": "About ASEAN Plus Three (APT)",
            "description": "Official information about ASEAN Plus Three cooperation framework",
            "url": "<?php echo get_permalink(); ?>",
            "mainEntity": {
                "@type": "Organization",
                "name": "ASEAN Plus Three",
                "alternateName": ["APT", "ASEAN+3"],
                "description": "Cooperation framework between ASEAN and China, Japan, Korea",
                "foundingDate": "1997",
                "memberOf": [
                    {"@type": "Organization", "name": "ASEAN"},
                    {"@type": "Country", "name": "China"},
                    {"@type": "Country", "name": "Japan"},
                    {"@type": "Country", "name": "Korea"}
                ]
            },
            "publisher": {
                "@type": "Organization",
                "name": "ASEAN Plus Three Cooperation"
            }
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'add_apt_structured_data');

?>