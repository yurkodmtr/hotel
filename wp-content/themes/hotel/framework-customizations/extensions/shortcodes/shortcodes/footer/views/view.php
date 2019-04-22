<?php 
	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}
?>

    <footer class="footer">
        <div class="center">
            <div class="item__list clearfix">
                <div class="item">
                    <a href="#" class="footer_logo">
                        <img src="<?php echo do_shortcode( $atts['logo']['url'] ); ?>" alt="">
                    </a>
                    <div class="copy">
                        <?php echo do_shortcode( $atts['copy_text']); ?>
                    </div>
                    <div class="link">
                        <a href="<?php echo do_shortcode( $atts['copy_item_1_link']); ?>">
                            <?php echo do_shortcode( $atts['copy_item_1_text']); ?>
                        </a><br>
                        <a href="<?php echo do_shortcode( $atts['copy_item_2_link']); ?>">
                            <?php echo do_shortcode( $atts['copy_item_2_text']); ?>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="<?php echo get_template_directory_uri();?>/images/footer_carts.png" alt="">
                </div>
                <div class="item">
                    <?php echo do_shortcode( $atts['info']); ?> 
                </div>
                <div class="item">
                    <div class="title">Свяжитесь с нами: </div>
                    <div class="descr">
                        <span><?php echo do_shortcode( $atts['info_phone']); ?></span>
                        <span>E-mail: <?php echo do_shortcode( $atts['info_email']); ?></span>
                    </div>
                    <div class="soc">
                        <?php foreach ( $atts['soc'] as $item ) : ?>
                            <a href="<?php echo $item['link'];?>">
                                <img src="<?php echo $item['logo']['url'];?>" alt="">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

	