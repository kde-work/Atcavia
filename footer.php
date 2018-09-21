</div> <!-- .page-content -->
<div class="page-mobile-pagination mobile">
    <div class="page-mobile-pagination__items"></div>
    <div class="page-mobile-pagination__btn">
        <div class="btn btn--small-white btn--thin"><?php
			echo __t( 'Связаться&nbsp;с&nbsp;нами', 'Contact&nbsp;With&nbsp;Us' );
			?></div>
    </div>
</div>
</div> <!-- .page-content-p -->
<div class="layout footer">
    <div class="layout__box">
        <div class="footer-top">
            <div class="footer-top__left">
                <div class="footer-top__logo header__logo" style="background-image: url(<?php echo wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'large', true )[0]; ?>)"></div>
            </div>
            <div class="footer-top__right">
                <div class="footer-top__text-block">
                    <div class="footer-top__title"><?php
						echo __t( 'Контакты офиса<br>в&nbsp;вашеме регионе', 'Office contacts<br>in&nbsp;your region' );
						?></div>
                    <div class="footer-top__desc"><?php echo __t( 'Перейдите в раздел ', 'Go to the section ' ); ?><a href="<?php echo get_the_permalink(27); ?>"><?php echo __t( 'Контакты', 'Contacts' ); ?></a></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom__left flat-menu"><?php wp_nav_menu(
					array(
						'container' => false,
						'item_spacing' => 'discard',
						'menu' => ___( 'Footer Left' )
					)
				); ?></div>
            <div class="footer-bottom__center flat-menu"><?php wp_nav_menu(
					array(
						'container' => false,
						'item_spacing' => 'discard',
						'menu' => ___( 'Footer Right' )
					)
				); ?></div>
            <div class="footer-bottom__right"><div class="btn btn--big btn--alpha-dark" onclick="popup_c({'cat':'connect-with-us', 'title':'<?php echo nbsp( __t( 'Связаться с нами', 'Connect with Us' )); ?>', 'service': 1, 'description': '<?php echo nbsp( __t( 'Связаться с нами (подвал)', 'Get in touch (footer)' )); ?>'}, this);"><?php echo nbsp( __t( 'Связаться&nbsp;с&nbsp;нами', 'Get&nbsp;in&nbsp;touch' )); ?></div></div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>