<?php

function process_site_categories_grid_display($content, $data, $args) {
	//echo "args<pre>"; print_r($args); echo "</pre>";
	//echo "data<pre>"; print_r($data); echo "</pre>";

	if ((isset($data['categories'])) && (count($data['categories']))) {

		$content .= '<div id="site-categories-wrapper">';

		$content .= '<ul class="site-categories site-categories-grid">';

		$cols_width = floor(100/intval($args['grid_cols']));
		$col_count = 0;
		foreach ($data['categories'] as $category) { 

			$col_count += 1;
			if ($col_count == (intval($args['grid_cols']) + 1)) {
				$col_count = 0;
				$clear_style .= "clear: both;";
			} else {
				$clear_style = '';
			}

			$content .=	'<li class="site-categories-parent" style="width:'. $cols_width .'%; '. $clear_style .'">';

			if ($category->count > 0)
				$content .=	'<a href="'. $category->bcat_url .'">';
				
			if ( ($args['icon_show'] == true) && (isset($category->icon_image_src))) {
				$content .= '<img class="site-category-icon" width="'. $args['icon_size'] .'" height="'. $args['icon_size'] .'"
				 alt="'. $category->name .'" src="'. $category->icon_image_src .'" />';
			} 

			$content .= '<span class="site-category-title">'. $category->name .'</span>';

//			if ($args['show_counts']) {
//				$content .= '<span class="site-category-count">('. $category->count .')</span>';
//			}
			
			if ($category->count > 0)
				$content .= '</a>';
					
			if (($args['show_description']) && (strlen($category->description))) {

				$bact_category_description = apply_filters('the_content', $category->description);
				$bact_category_description = str_replace(']]>', ']]&gt;', $bact_category_description);
			
				if (strlen($bact_category_description)) {
					$content .= '<div class="site-category-description">'. $bact_category_description .'</div>';
				}
			}
					
			if ((isset($category->children)) && (count($category->children))) {
				$content .= '<ul class="site-categories-children">';

				foreach( $category->children as $category_child) {

					$content .=	'<li class="site-categories-child" style="width: 100%">';

					if ($category_child->count > 0)
						$content .=	'<a href="'. $category_child->bcat_url .'">';

					$content .= '<span class="site-category-title">'. $category_child->name .'</span>';

					if ($args['show_counts']) {
						$content .= '<span class="site-category-count">('. $category_child->count .')</span>';
					}

					if ($category_child->count > 0)
						$content .= '</a>';
						
					$content .= '</li>';
				}

				$content .= '</ul>';						
			}
			$content .= '</li>';
			
		}

		$content .= "</ul>";

		if ((isset($data['prev'])) || (isset($data['next']))) { 

			$content .= '<div id="site-categories-navigation">';

			if (isset($data['prev'])) { 
				$content .= '<a href="'. $data['prev']['link_url'] .'">'. $data['prev']['link_label'] .'</a>';
			} 

			if (isset($data['next'])) { 
				$content .= '<a href="'. $data['next']['link_url'] .'">'. $data['next']['link_label'] .'</a>';
			}
			$content .= '</div>';
		}
		$content .= '</div>';
	}

	return $content;
}
add_filter('site_categories_landing_grid_display', 'process_site_categories_grid_display', 99, 3);
