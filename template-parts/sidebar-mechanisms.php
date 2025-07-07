<?php
$summitid = 41;
$ministerialid = 43;
$cprid = 409;
$ottid = 399;

$matrixexcludes=[];
$levels = get_categories(array(
	'parent' => 7,
	'exclude' => $matrixexcludes
	)
);
function echo_the_topics($pillarobj){
    $themespageid = 5733;
	$themes = get_children($themespageid);
	$return = "";
	foreach($themes as $key=>$theme){
		$tpc_pillar = get_post_custom_values( "tpc_pillar", $theme->ID);
		
		
		$tpc_topics_echo = '';
		
		
		if (str_contains($pillarobj->slug, $tpc_pillar[0]) && !empty($tpc_pillar)) { 
		//if($tpc_pillar[0] == $pillarobj->slug){
			
			$tpc_topics = get_post_custom_values( "tpc_topics", $theme->ID);
			$tpc_topics_arr = explode(',',$tpc_topics[0]);
			$emptymarker = 0;
			foreach($tpc_topics_arr as $topic){
				$topic_cat_obj = get_category_by_slug($topic);
				//$t = get_ancestors($topic_cat_obj->term_id,'category');
				//echo('<pre>');print_r($pillarobj->term_id);echo('</pre>');
				
				$cl = akseki_get_level_from_id($topic_cat_obj->term_id,'category');
				
				
				if($pillarobj->parent == $cl && $topic_cat_obj->category_count > 0){
					$tpc_topics_echo .= '<h5 class="mb-0"><a href="'.get_category_link($topic_cat_obj).'">'.$topic_cat_obj->name.'</a></h5>';
					$tpc_topics_echo .= '<em class="mb-2 badge badge-light font-weight-normal">'.$topic_cat_obj->description.'</em>';
					$emptymarker++;
				}
			}
			if($emptymarker == 0){
				$hidden = " hidden";
			}else{
				$hidden = "";
			}
			$return .= '<div class="row border-bottom my-1 mechrow"'.$hidden.'>						
							<div class="col-6 col-md-4 col-lg-3"><a href="'.get_permalink($theme->ID).'">'.$theme->post_title.'</a></div>
							<div class="col-6 col-md-8 col-lg-9">'.$tpc_topics_echo.'</div>
						</div>';
		}
	}
	return $return;
}
//summit cpr other tracks
/*echo('<div class="row">');
foreach($matrixexcludes as $excludes){
	$excobj = get_category($excludes);
	$excposts_echo = '';
	if($excobj->term_id == $summitid){
		$cardcolor = "info";
		$textcolor = " text-white";
		$excposts = get_posts( array(
			'numberposts' => 3,
			'category' => $summitid
		) );
		//print_r($excposts);
		$lastyear = 0;
		
			//print_r($excpost);
			//$excyear = date('Y',strtotime($excpost->post_date));
			//$excposts_echo .= '<li class="list-group-item pr-4"><strong>'.$excyear.'</strong><a href="http://lo//calhost/localapt5/?cat=46">'.$excpost->post_title.'</a></li>';
			
			
										$theid = $excpost->ID;
										$year = date('Y',strtotime($excpost->post_date));
										$mon = date('m',strtotime($excpost->post_date));
										$year_mon = $year.$mon;
										$newgroups[$year_mon][] = $theid;
										
										
										
			
		
		foreach($newgroups as $key=>$newgroup){
			
			$echo = '';
			foreach($newgroup as $id){
				$obj = get_post($id);
				$year = date('Y',strtotime($obj->post_date));
				$meta = '<small>'.akseki_get_the_meta($obj->ID).'</small>';
				$echo .= '<li><a href="#">'.$obj->post_title.'</a></li>';
			}
			$excposts_echo .= '<li class="list-group-item pr-4"><h5 class="mb-0">'.substr($key,0,-2).'</h5>'.$meta.'<ul class="mt-2">';
			$excposts_echo .= $echo;
			$excposts_echo .= '</ul></li>';
		}
		
		//echo('<pre>');print_r($newgroups);echo('</pre>');
	}else{
		$cardcolor = "light";
		$textcolor = "";
		$excposts = get_posts( array(
			'numberposts' => 5,
			'category' => $cprid
		) );
		$excposts_echo .= '<ul>';		
		foreach($excposts as $post){
			$excposts_echo .= '<li class="mt-2"><strong>'.akseki_get_shortname($post->post_title, $post->ID).'</strong><br><small>'.akseki_get_the_meta($post->ID).'</small></li>';
		}
		$excposts_echo .= '</ul>';
	}
	
	//print_r($excobj);
	echo('<div class="mb-2 col-12 col-lg-4">
		<div class="card border-'.$cardcolor.' shadow mt-2">
			<h4 class="card-header bg-'.$cardcolor.$textcolor.'">'.$excobj->name.'</h4>
			<ul class="mt-3 pb-3 list-group list-group-flush">
				'.$excposts_echo.'				
			</ul>
		</div>
	</div>');
}
echo('</div>');*/
//tab nav
echo('<div class="container">');
echo('<ul class="nav row nav-tabs mx-0" id="mechTab" role="tablist">');
//echo('<li class="col-3"><label class="text-left">&nbsp;</label></li>');
foreach($levels as $key=>$level){
	if($level->term_id == $summitid){
		$active = " active";
		$selected = "true";
	}else{
		$active = "";
	}
		$selected = "false";
		echo('<li class="col nav-item mx-1 px-0">
			<a href="javascript:void(0);" class="text-muted bg-light text-muted text-center h-100 nav-link'.$active.'" id="'.$level->term_id.'-tab" data-toggle="tab" data-target="#'.$level->slug.'-tabcontent" role="tab" aria-controls="'.$level->slug.'-tabcontent" aria-selected="'.$selected.'">'.$level->cat_name.'</a>
		</li>');
}
echo('</ul>');
//tab content
echo('<div class="tab-content" id="mechTabContent">');
//display the tabs

foreach($levels as $key=>$level){
	
	if($level->term_id == $summitid){
		$excposts = get_posts( array(
			'numberposts' => 8,
			'category' => $summitid
		) );
		echo('<div class="tab-pane fade active show" id="'.$level->slug.'-tabcontent" role="tabpanel" aria-labelledby="'.$level->slug.'-tab">');
		
		foreach($excposts as $excpost){	
			$theid = $excpost->ID;
			$year = date('Y',strtotime($excpost->post_date));
			$mon = date('m',strtotime($excpost->post_date));
			$year_mon = $year.$mon;
			$newgroups[$year_mon][] = $theid;
		}								

		$excposts_echo = '<div class="mt-4 mechContentList"><ul class="list-group list-group-flush">';
		foreach($newgroups as $key=>$newgroup){
			
			$echo = '';
			foreach($newgroup as $id){
				$obj = get_post($id);
				$year = date('Y',strtotime($obj->post_date));
				$meta = '<small>'.akseki_get_the_meta($obj->ID).'</small>';
				$echo .= '<li><a href="'.get_permalink($obj->ID).'">'.$obj->post_title.'</a></li>';
			}
			$excposts_echo .= '<li class="list-group-item pr-4" style="break-inside:avoid;"><h5 class="mb-0">'.substr($key,0,-2).'</h5>'.$meta.'<ul class="mt-2">';
			$excposts_echo .= $echo;
			$excposts_echo .= '</ul></li>';
		}
		$excposts_echo .= '</ul>';
		$excposts_echo .= '<em><a href="'.get_category_link($summitid).'" type="button" class="mt-2 btn btn-light w-100">more&hellip;</a></em>';
		$excposts_echo .= '</div>';
		//print_r($newgroups);
		echo($excposts_echo);
		echo('</div>');
	/*}elseif($level->term_id == $cprid){
		echo('<div class="tab-pane fade" id="'.$level->slug.'-tabcontent" role="tabpanel" aria-labelledby="'.$level->slug.'-tab">');
		$cprposts = get_posts( array(
			'numberposts' => 11,
			'category' => $cprid
		) );
		$cprposts_echo .= '<div class="mt-4 mechContentList"><ul class="list-group list-group-flush">';
		foreach($cprposts as $post){
			$cprposts_echo .= '<li class="list-group-item"><a class="font-weight-bold" href="'.get_permalink($post->ID).'">'.akseki_get_shortname($post->post_title, $post->ID).'</a><br><small>'.akseki_get_the_meta($post->ID).'</small></li>';
		}
		$cprposts_echo .= '</ul>';
		$cprposts_echo .= '<em><a href="'.get_category_link($cprid).'" type="button" class="btn btn-light w-100 mt-2">more&hellip;</a></em>';
		$cprposts_echo .= '</div>';
		echo($cprposts_echo);
		echo('</div>');*/
	}elseif($level->term_id == $ottid){
		echo('<div class="tab-pane fade" id="'.$level->slug.'-tabcontent" role="tabpanel" aria-labelledby="'.$level->slug.'-tab">');
		$ottcats = get_categories( array(
			'parent' => $ottid
		) );


		$ott_echo .= '<div class="row mt-4">';		
		foreach($ottcats as $ottcat){
			$ott_echo .= '<div class="col-6"><div class="card"><div class="card-header font-weight-bold">'.$ottcat->name.'</div><ul class="list-group list-group-flush">';
			$ottcatchildren = get_categories( array(
				'parent' => $ottcat->term_id
			) );
			foreach($ottcatchildren as $ottcatchild){
				$ott_echo .= '<li class="list-group-item"><h5 class="mb-0"><a href="'.get_category_link($ottcatchild->term_id).'">'.$ottcatchild->name.'</a></h5><em class="mb-2 badge badge-light font-weight-normal">'.$ottcatchild->description.'</em></li>';
			}
			$ott_echo .= '</ul></div></div>';
		}
		$ott_echo .= '</div>';
		echo($ott_echo);
		echo('</div>');
	}else{
		$active = "";
		$show = "";
		/*if($level->term_id == $ministerialid){
			$active = " active";
			$show=" show";
		}*/
		echo('<div class="tab-pane fade'.$show.$active.'" id="'.$level->slug.'-tabcontent" role="tabpanel" aria-labelledby="'.$level->slug.'-tab">');
		//display each pillar
		$pillars = get_categories(array( 'parent' => $level->term_id));
		//echo('<pre>');print_r($pillars);echo('</pre>');
		foreach($pillars as $pillar){
			echo('<div class="row mx-2" id="ar_'.$pillar->slug.'">');
				echo('<button class="bg-light color-white my-1 btn col-12 btn-secondary text-left innerAccordion" data-toggle="collapse" data-target="#collapse'.$pillar->slug.'" aria-expanded="true" aria-controls="collapse'.$pillar->slug.'"><span>
					'.$pillar->name.'
				</span></button>');
				echo('<div id="collapse'.$pillar->slug.'" class="collapse show col-12">
					<div class="container pt-1">
						
							'.echo_the_topics($pillar).'
						
					</div>
				</div>
			</div>');
		}
		echo('</div>');
	}
}
echo('</div>');
echo('</div>');

?>



<!--
<ul class="nav nav-tabs" id="ssTab" role="tablist">
  <li class="col-2">
    <label class="btn text-left m-0 p-0">Cooperation level:</label>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
  </li>
</ul>
<div class="tab-content" id="ssTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">1...</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2...</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3...</div>
</div>
-->