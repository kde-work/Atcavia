    </div> <!-- .page-content -->
    <div class="page-mobile-pagination mobile">
        <div class="page-mobile-pagination__items"></div>
        <div class="page-mobile-pagination__btn">
            <div class="btn btn--small-white btn--thin" onclick="popup_c({'cat':'connect-with-us', 'title':'<?php echo nbsp( __t( 'Связаться с нами', 'Get in touch' )); ?>', 'service': 1, 'description': '<?php echo nbsp( __t( 'Связаться с нами (выше подвала)', 'Get in touch (under footer)' )); ?>'}, this);"><?php
                echo __t( 'Связаться&nbsp;с&nbsp;нами', 'Get&nbsp;in&nbsp;touch' );
                ?></div>
        </div>
    </div>
</div> <!-- .page-content-p -->
<div class="layout footer">
    <div class="layout__box">
        <div class="footer-top">
            <div class="footer-top__left">
                <a href="<?php echo get_home_url(); ?>" class="footer-top__logo header__logo" style="background-image: url(<?php echo wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'large', true )[0]; ?>)"></a>
            </div>
            <div class="footer-top__right">
                <div class="footer-top__text-block">
                    <div class="footer-top__title"><?php
						echo __t( 'Контакты офиса<br>в&nbsp;вашеме регионе', 'Office Locator' );
						?></div>
                    <div class="footer-top__desc"><?php echo __t( 'Перейдите в раздел ', 'Go the ' ); ?><a href="<?php echo get_the_permalink(27); ?>"><?php echo __t( 'Контакты', 'Contacts' ); ?></a></div>
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
            <div class="footer-bottom__right"><div class="btn btn--big btn--alpha-dark" onclick="popup_c({'cat':'connect-with-us', 'title':'<?php echo nbsp( __t( 'Связаться с нами', '\'Get in touch' )); ?>', 'service': 1, 'description': '<?php echo nbsp( __t( 'Связаться с нами (подвал)', 'Get in touch (footer)' )); ?>'}, this);"><?php echo nbsp( __t( 'Связаться&nbsp;с&nbsp;нами', 'Get&nbsp;in&nbsp;touch' )); ?></div></div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>