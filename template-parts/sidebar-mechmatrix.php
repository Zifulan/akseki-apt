<?php
$summitid = 41;
$ministerialid = 43;
$cprid = 409;
$othid = 295;
$ottid = 399;
$displaysummit = true;
$matrixexcludes=[$othid];
$levels = get_categories(array(
	'parent' => 7,
	'exclude' => $matrixexcludes
	)
);

//table

echo('<table id="matrixtable" class="table table-sm table-bordered table-hover table-responsive-lg">');
echo('<thead><tr>');
echo('<td class="bg-yellow-muted p-2 text-left"><strong>Area</strong></td>');//first column, pillar/topic name
foreach($levels as $key=>$level){
	$words = explode( " ", $level->cat_name );
	$lastElement = end($words);
	if($lastElement == "Statements"){
		array_splice( $words, -1 );
		$title = implode( " ", $words );
	}else{
		$title = $level->cat_name;
	}
	echo('<td class="text-center p-2"><strong>'.$title.'</strong></td>');
}
echo('</tr></thead>');
echo('<tbody>');

//number of rows
$matrixarr = ["political-cooperations"=>[],"economic-cooperations"=>[],"socio-cultural-cooperations"=>[]];
$themespageid = 5733;
$themes = get_children($themespageid);

foreach($themes as $key=>$theme){
	$tpc_pillar = get_post_custom_values( "tpc_pillar", $theme->ID);	
	
	if(!empty($tpc_pillar)){
		$matrixarr[$tpc_pillar[0]][] = $theme->ID;
	}
}
//is a topic slug in which level?

foreach($matrixarr as $key=>$pillar){
	//echo('<tr><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td>8</td></tr>');
	$colnum=count($levels)+1;
	$pobj = get_category_by_slug($key);
	$ptext = '<button title="click to expand" class="ml-2 collapsed matrixpillarbutton btn btn-light w-100 text-left m-0 p-0" type="button" data-toggle="collapse" data-target="#collapse'.$key.'" aria-expanded="false" aria-controls="collapse'.$key.'"><em class="ml-2">
    '.$pobj->name.'</em></button>';
	echo('<tr class=""><td class="bg-light" colspan="'.$colnum.'">'.$ptext.'</td></tr>');
	foreach($pillar as $keypil=>$topicid){
		$tobj = get_post($topicid);//print_r($tobj);
		$tpc_topics = get_post_custom_values( "tpc_topics", $tobj->ID);
		$tpc_topics_arr = explode(',',$tpc_topics[0]);
		echo('<tr class="collapse" id="collapse'.$key.'"><td class=""><a href="'.get_permalink($tobj->ID).'">'.$tobj->post_title.'</a></td>');
		foreach($levels as $keyh=>$header){
			if($keyh!==0){
				echo('<td>');
				foreach($tpc_topics_arr as $keyt=>$topic){
					$k = get_category_by_slug($topic);
					$l = akseki_get_level_from_id($k,"category");
					$m = get_category($l);
					//print_r($header);
					if($m == $header && $k->category_count > 0){
						echo('<p class="keyt pb-1 mb-0"><a title="'.$k->description.'" href="'.get_category_link($k).'">'.$k->name.'</a></p>');
						//echo('<hr class="my-0 py-0">');
						
					}
				}
				echo('</td>');
			}else{
				if($keypil==0){
					//display summit link only once
					if($displaysummit == true){
						$ks = get_category($summitid);
						echo('<td rowspan="'.count($pillar).'" class="bg-summit-muted"><p class="keyt pb-1 mb-0"><a title="'.$ks->description.'" href="'.get_category_link($ks).'">Summit Level</a></p></td>');
						$displaysummit = false;
					}else{
						echo('<td rowspan="'.count($pillar).'" class="bg-summit-muted"></td>');
					}
				}else{
					//do nothing
					//echo('<td>'.$keypil.'</td>');
				}
			}
		}
		echo('</tr>');
	}
	
}



echo('</tbody>');
echo('</table>');
//echo('<pre>');print_r($matrixarr);echo('</pre>');
?>

