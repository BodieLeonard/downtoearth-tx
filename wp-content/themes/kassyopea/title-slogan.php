			<?php global $post; $slogan = get_post_meta( $post->ID, '_slogan_page', true ) ?>
                    
            <?php if( $slogan != '' ) : ?><h2 class="title-page"><?php convertTags( $slogan ) ?></h2><?php clear(); else : clear('space'); endif; ?> 