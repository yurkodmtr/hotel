<?php 
	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}
?>

    <div class="featured">
        <div class="center">
            <div class="item__list clearfix">
                <div class="item">
                    <figure>
                        <img src="<?php echo do_shortcode( $atts['item_1_icon']['url'] ); ?>" alt="">           
                    </figure>
                    <p>
                        <?php echo do_shortcode( $atts['item_1_title'] ); ?>
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo do_shortcode( $atts['item_2_icon']['url'] ); ?>" alt="">           
                    </figure>
                    <p>
                        <?php echo do_shortcode( $atts['item_2_title'] ); ?>
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo do_shortcode( $atts['item_3_icon']['url'] ); ?>" alt="">           
                    </figure>
                    <p>
                        <?php echo do_shortcode( $atts['item_3_title'] ); ?>
                    </p>
                </div>
                <div class="item">
                    <figure>
                        <img src="<?php echo do_shortcode( $atts['item_4_icon']['url'] ); ?>" alt="">           
                    </figure>
                    <p>
                        <?php echo do_shortcode( $atts['item_4_title'] ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

	
