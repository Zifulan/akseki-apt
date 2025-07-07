        <?php
		//start breadcrumb		
		echo('<div class="akseki_breadcrumb mb-4">');
		$bc_separator = "&ensp;";
		//breadcrumb immidiate category
		$categories = get_the_category();
		//get children of ministerial category
		$min_child=get_categories(
			array( 'parent' => 43 )
		);
		$the_curcat = $args['the_curcat'];
		
		$idSummitObj = get_category_by_slug('summit-level-statements'); 
		$Summitid = $idSummitObj->term_id;
		$idObj = get_category_by_slug('cpr-level'); 
		$cprid = $idObj->term_id;
		
		//current category's ancestors
		$curcat_anc = get_ancestors($the_curcat,'category');
		$curcat_anc_rev = array_reverse($curcat_anc);
		
		//if arcitcle is not SUMMIT or MINISTERIAL or CPR or SOM, do not display breadcrumb
		if(in_array(43, $curcat_anc) or $the_curcat == $Summitid or $the_curcat == $cprid or in_array(280, $curcat_anc) or in_array(295, $curcat_anc)){
			//display breadcrumb
    		foreach($curcat_anc_rev as $index=>$cca){
    			//don't display dropdown for first category
    			//unless for CPR, display Other categ
    			if($index == 0 and $the_curcat === $cprid){
					//echo('<span class="btn btn-secondary ab-item first-item">'.get_cat_name($cca).':</span>'.$bc_separator);
				}else if($index == 0){
    				//do nothing
    			}else{
    				echo('<div class="dropdown d-inline-block">');
    				echo('<a class="ab-item btn btn-secondary dropdown-toggle" href="#" role="button" type="button" id="dropdownMenuLink'.$cca.'" data-toggle="dropdown">'.get_cat_name($cca).'</a>'.$bc_separator);
    				echo('<div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$cca.'">');
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
    				echo ('</div>');
    				echo ('</div>');
    			}
    		}
    		//breadcrumb current category
    		echo('<div class="dropdown d-inline-block">');
    		echo('<a class="ab-item btn btn-secondary dropdown-toggle" href="#" role="button" type="button" id="dropdownMenuLink'.$the_curcat.'" data-toggle="dropdown">'.get_cat_name($the_curcat).'</a>'.$bc_separator);
    		echo('<div class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$the_curcat.'">');
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
    		
    		echo('</div>');
    		echo('</div>');
    		//breadcrumb last item
    		//echo('<span class="btn btn-secondary ab-item last-item">'.akseki_get_shortname(get_the_title(get_the_ID()),get_the_ID()).'</span>');
    		
    		echo('</div>');
		}
		?> 