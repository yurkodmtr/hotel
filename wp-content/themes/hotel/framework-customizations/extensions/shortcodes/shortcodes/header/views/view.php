<?php 
	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}
?>


	<div class="header">
        <div class="center">
            <a href="#" class="logo">
                <img src="<?php echo do_shortcode($atts['logo_img']['url']);?>" alt="">
            </a>
            <div class="slogan">
                <?php echo do_shortcode($atts['slogan']); ?>
            </div>
            <div class="nav">
                <a class="contact_us _open_menu">связаться с нами</a>
                <div class="burger _open_menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="menu">
            <div class="top">
                <img src="<?php echo do_shortcode($atts['logo_img']['url']);?>">
                <div class="close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" enable-background="new 0 0 60 60" xml:space="preserve"> <g> <line stroke="#FFF" stroke-width="10" transform="translate(5, 5)" stroke-miterlimit="10" x1="5" y1="5" x2="50" y2="50" stroke-linecap="round"/> <line stroke="#FFF" stroke-width="10" transform="translate(5, 5)" stroke-miterlimit="10" x1="5" y1="50" x2="50" y2="5" stroke-linecap="round"/> </g> <g> <circle opacity="0" stroke-width="3" stroke="#FFF" stroke-miterlimit="10" cx="30" cy="30" r="40"/> </g> </svg>
                </div>
            </div>
            <div class="mid">
                <ul>
                	<?php foreach ( $atts['menu_links'] as $item ) : ?>
                    	<li><a href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bottom">
                <div class="title">Свяжитесь с нами:</div>
                <div class="info">
                    <img src="<?php echo get_template_directory_uri();?>/images/mail.png">
                    <?php echo do_shortcode($atts['email']); ?>
                </div>
                <div class="info">
                    <img src="<?php echo get_template_directory_uri();?>/images/phone.png">
                    <?php echo do_shortcode($atts['phone']); ?>
                </div>
                <div class="soc">
                	<?php foreach ( $atts['social'] as $item ) : ?>
                    	<a href="<?php echo $item['link'];?>">
	                        <img src="<?php echo $item['logo_img']['url']; ?>">
	                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
