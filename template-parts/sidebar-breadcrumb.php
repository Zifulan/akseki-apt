        <?php
		//start breadcrumb		
		echo('<div class="akseki_breadcrumb mb-4">');
		$bc_separator = "";
		//breadcrumb immidiate category
		$categories = get_the_category();
		//get children of ministerial category
		$min_child=get_categories(
			array( 'parent' => 43 )
		);
		$the_curcat = $args['the_curcat'];
		$the_curcat_obj = get_category($the_curcat);
		$idSummitObj = get_category_by_slug('summit-level-statements'); 
		$Summitid = $idSummitObj->term_id;
		$idObj = get_category_by_slug('cpr-level'); 
		$cprid = $idObj->term_id;
		$ottcat = akseki_get_ott_categories();
		
		//current category's ancestors
		$curcat_anc = get_ancestors($the_curcat,'category');
		$curcat_anc_rev = array_reverse($curcat_anc);
		
		//if arcitcle is not SUMMIT or MINISTERIAL or CPR or SOM, do not display breadcrumb
		//if(in_array(43, $curcat_anc) or $the_curcat == $Summitid or $the_curcat == $cprid or in_array(280, $curcat_anc) or in_array(295, $curcat_anc)){
		
		//if not CPR+3
		if($the_curcat !== 275 and !in_array($the_curcat_obj->slug,$ottcat)){
			//display breadcrumb
    		foreach($curcat_anc_rev as $index=>$cca){
    			//don't display dropdown for first category
    			//unless for CPR, display Other categ
    			if($index == 0 and $the_curcat === $cprid){
					//echo('<span class="btn btn-secondary ab-item first-item">'.get_cat_name($cca).':</span>'.$bc_separator);
				}else if($index == 0){
    				//do nothing
    			}else{
    				echo('<div class="d-inline-block">');
    				echo('<a class="ab-item btn btn-secondary mb-1 py-1 px-2 mr-1 text-left" href="'.get_category_link($cca).'" role="button" type="button" id="dropdownMenuLink'.$cca.'"><small>'.get_cat_name($cca).'</small></a>'.$bc_separator);
    				/*echo('<div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$cca.'">');
    				//get their siblings
    				$child = get_category($cca);
    				//from your child category, grab parent ID
    				$parent_id = $child->parent;
    				
    				//iterate children of parent to get siblings, exclude the one already mentioned
    				$siblings=get_categories(
    					array( 'parent' => $parent_id )
    				);
    				foreach($siblings as $i=>$sibp){
    					if($sibp->term_id !== $cca && $parent_id !== 0){
    						echo('<a class="dropdown-item" href="'.get_category_link($sibp->term_id).'">'.$sibp->name.'</a>');
    					}else{
    						echo('<a class="dropdown-item bg-secondary" href="'.get_category_link($sibp->term_id).'">'.$sibp->name.'</a>');
    					}
    					
    				}
    				echo ('</div>');*/
    				echo ('</div>');
    			}
    		}
			//display the theme/topic
			//don't display in other tracks and summit
			if($the_curcat !== 41 and !in_array($the_curcat_obj->slug,$ottcat)){
				$the_theme_id = akseki_get_theme_from_id($the_curcat,"category");
				$the_theme_obj = get_post($the_theme_id);//print_r($the_theme_obj);
				echo('<div class="dropdown d-inline-block">');
				echo('<a class="ab-item btn btn-secondary mb-1 py-1 px-2 mr-1 text-left" href="'.get_permalink($the_theme_id).'" role="button" type="button" id="dropdownMenuLinkeded"><small>'.$the_theme_obj->post_title.'</small></a>'.$bc_separator);
				echo('</div>');
			}
		}
    		//breadcrumb current category
    		echo('<div class="dropdown d-inline-block">');
    		echo('<a title="'.strip_tags(category_description($the_curcat)).'" class="ab-item btn btn-secondary mb-1 px-2 py-1" href="'.get_category_link($the_curcat).'" role="button" type="button" id="dropdownMenuLink'.$the_curcat.'"><small>'.get_cat_name($the_curcat).'</small></a>'.$bc_separator);
    		/*echo('<div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$the_curcat.'">');
    		//get the parent
    		$anc0_children=get_categories(
    			array( 'parent' => $curcat_anc[0] )
    		);
    		$anc0_pluck = wp_list_pluck($anc0_children, 'name', 'term_id');
    		foreach($anc0_pluck as $i=>$ancp){
    			if($ancp !== get_cat_name($the_curcat)){
    				echo('<a class="dropdown-item" href="'.get_category_link($i).'">'.$ancp.'</a>');
    			}else{
    				echo('<a class="dropdown-item bg-secondary" href="'.get_category_link($i).'">'.$ancp.'</a>');
    			}
    		}
    		
    		echo('</div>');*/
    		echo('</div>');
    		//breadcrumb last item
    		//echo('<span class="btn btn-secondary ab-item last-item">'.akseki_get_shortname(get_the_title(get_the_ID()),get_the_ID()).'</span>');
    		
    		echo('</div>');
		//}
		?> 