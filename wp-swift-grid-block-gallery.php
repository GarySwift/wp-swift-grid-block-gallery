<?php
/*
Plugin Name: WP Swift: Grid Block Gallery
Plugin URI: 
Description: Placeholder description
Version: 1
Author: Gary Swift
Author URI: https://github.com/wp-swift-wordpress-plugins
License: GPL2
*/

/**
 * The ACF field groups
 */ 
require_once plugin_dir_path( __FILE__ ) . 'acf/gallery.php';

add_action( 'after_setup_theme', 'your_theme_setup' );
function your_theme_setup() {
	// Add gallery image sizes
	add_image_size( 'gallery-small', 384, 357, true ); // name, width, height, crop
	add_image_size( 'gallery-medium', 579, 331, true );
	add_image_size( 'gallery-large', 872, 581, true );
	add_image_size( 'gallery-xlarge', 1164, 700, true );
}

// [grid-block-gallery]
function grid_block_gallery_func( $atts ) {
    return wp_swift_grid_block_gallery();
}
// add_shortcode( 'grid-block-gallery', 'grid_block_gallery_func' );

function wp_swift_grid_block_gallery() {
	$post_id = get_the_ID();
	$colors = array("primary", "secondary", "gray");
	$img_rows = get_image_rows_array( $post_id, $colors );

	$optim_imgs = true;
	$size_xlarge = $optim_imgs ? 'gallery-xlarge' : 'large';
	$size_large = $optim_imgs ? 'gallery-large' : 'large';
	$size_medium = $optim_imgs ? 'gallery-medium' : 'medium_large';
	$size_small = $optim_imgs ? 'gallery-small' : 'medium_large';

	if (count($img_rows)): 
		$img_count = 0; 
		$color_index = 0;
		ob_start(); 
		?>

			<div id="project-image-gallery" class="lightbox-gallery">
				<div class="grid-container">

				<?php foreach ($img_rows as $key => $img_row): ?>
					<div class="grid-x">
						<?php foreach ($img_row as $cell):
								$image = null;
								$image_src = null;
								$image_alt = '';
								$css_class = 'project-cell cell small-'.$cell['size'];
								if (isset($cell['color'])) {
									$color_index++;
									$color = $cell['color'];
									$css_class .= ' '.$color;
								}
								elseif (isset($cell["image"])) {
									$img_count++;
									$image = $cell["image"]["file"];
									$source = $image["sizes"]['fp-xlarge']; 
									$class = $cell["image"]["class"];
									$image_src = '';
									$image_alt = 'Image '.$img_count;
									$image_caption = $image["title"];
									if ($image["caption"]) {
										$image_caption = $image["caption"];
									}
									$image_alt = $image_caption;
									switch ($class) {
										case 'xlarge':
											$image_src = $image["sizes"][$size_xlarge];
											break;									
										case 'large':
											$image_src = $image["sizes"][$size_large];
											break;
										case 'medium':
											$image_src = $image["sizes"][$size_medium];
											break;	
										case 'small':
											$image_src = $image["sizes"][$size_small];
											break;															
										default:
											$image_src = $image['url'];
											break;
									}

								}

								elseif( !isset($cell["image"]) && !isset($cell['color'])) {
									/*
									 * Give empty cells a color
									 */
									if (!isset($colors[$color_index])) {
										$color_index = 0;//Reset if out of range
									}
									$color = $colors[$color_index];
									$css_class .= ' '.$color;
									$color_index++;					
								}
							 ?>

							<?php if ($image): ?>
								<div class="<?php echo $css_class; ?>">
									<?php if ($source): ?><a href="<?php echo $source; ?>" target="_blank" class="lightbox" title="<?php echo $image_caption ?>"><?php endif ?>

									<img src="<?php echo $image_src ?>" alt="<?php echo $image_alt ?>">

									<?php if ($source): ?></a><?php endif ?>
		
								</div><!-- @end .cell -->							
							<?php else: ?><div class="<?php echo $css_class; ?>"></div><!-- @end .cell --><?php endif ?>
						<?php endforeach ?>
					</div><!-- @end .grid-x -->
				<?php endforeach ?>

				</div><!-- @end .grid-container -->
			</div><!-- @end #project-image-gallery -->

		<?php 
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	endif; 	
}

function get_image_rows_array($post_id, $colors) {
	$img_rows = array();
	$images = get_field('gallery');
	$count_images = count($images);
	$img_row_templates = array(
		array( "image_count" => 1, "sizes" => array(12), 	"color" => "", "images" => array() ),
		array( "image_count" => 2, "sizes" => array(6,6), 	"color" => "", "images" => array() ),
		array( "image_count" => 1, "sizes" => array(9,3), 	"color" => $colors[0], "images" => array() ),
		array( "image_count" => 2, "sizes" => array(6,6), 	"color" => "", "images" => array() ),
		array( "image_count" => 2, "sizes" => array(6,6), 	"color" => "", "images" => array() ),
		array( "image_count" => 1, "sizes" => array(3,9),   "color" =>  $colors[1], "images" => array() ),
		array( "image_count" => 2, "sizes" => array(6,6), 	"color" => "", "images" => array() ),
		array( "image_count" => 1, "sizes" => array(12), 	"color" => "", "images" => array() ),
		array( "image_count" => 3, "sizes" => array(4,4,4), "color" => "", "images" => array() ),
		array( "image_count" => 1, "sizes" => array(9,3), 	"color" =>  $colors[2], "images" => array() ),
		array( "image_count" => 2, "sizes" => array(6,6), 	"color" => "", "images" => array() ),
	);
	$count_img_row_templates = count($img_row_templates);
	if ($count_images) {
		$i=0; 
		/*
		 * Loop through the image array and reduce size
		 * Remove image sing array_shift if conditions allow
		 */
		while ( count( $images )) {

			if (isset($img_row_templates[$i])) {
				$img_row_template = $img_row_templates[$i];
			}
			elseif (isset($img_row_templates[$i - $count_img_row_templates])) {
				$img_row_template = $img_row_templates[$i - $count_img_row_templates];
			}

			$i++;
			$image = null;
			$img_row = array();
			$color = $img_row_template["color"];
			$image_count = $img_row_template["image_count"];
			
			/*
			 * Create a cell for each image
			 */
			foreach ($img_row_template["sizes"] as $key => $size) {
				$cell = array("size" => $size);
				if ( (!$color || ($color && $size > 3)) && count( $images )) {
					$image = array_shift($images);
					switch ($size) {
						case 12:
							$class = 'xlarge';
							break;					
						case 9:
							$class = 'large';
							break;	
						case 6:
							$class = 'medium';
							break;
						case 4:
							$class = 'small';
							break;																	
						default:
							$class = 'default';
							break;
					}
					$cell["image"] = array("file" => $image, "class" => $class);
				}	
				if ($color && $size === 3) {
					$cell["color"] = $color;
				}
				$img_row[] = $cell;
			}
			
			$img_rows[] = $img_row;	
		}
	}
	return $img_rows;
}
