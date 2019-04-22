<?php 
	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}
?>

    <div class="footer_block">
        <div class="center">

            <div class="links">
                <div class="item__list clearfix">
                    <div class="item">
                        <div class="title"><?php echo do_shortcode( $atts['block_1_title'] ); ?></div>
                        <ul>
                            <?php foreach ( $atts['block_1'] as $item ) : ?>
                                <li><a href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="title"><?php echo do_shortcode( $atts['block_2_title'] ); ?></div>
                        <ul>
                            <?php foreach ( $atts['block_2'] as $item ) : ?>
                                <li><a href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="title"><?php echo do_shortcode( $atts['block_3_title'] ); ?></div>
                        <ul>
                            <?php foreach ( $atts['block_3'] as $item ) : ?>
                                <li><a href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="find_btn">
                <a href="<?php echo do_shortcode( $atts['search_link'] ); ?>">
                    <?php echo do_shortcode( $atts['search_text'] ); ?>
                </a>
            </div>

            <div class="subscribe">
                <div class="title">
                    <?php echo do_shortcode( $atts['subscribe_title'] ); ?>
                </div>
                <div class="subtitle">
                    <?php echo do_shortcode( $atts['subscribe_subtitle'] ); ?>
                </div>
                <form class="mailchimp">
                    <input type="email" placeholder="Ваш E-mail" class="input">
                    <button type="submit" class="submit">Подписаться</button>
                </form>
                <div class="notice">
                    <?php echo do_shortcode( $atts['subscribe_notice'] ); ?>
                </div>
            </div>

        </div>
       
    </div>

	
