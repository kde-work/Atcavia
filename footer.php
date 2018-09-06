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
                    <div class="footer-top__title">
                        Контакты офиса<br>в&nbsp;вашеме регионе
                    </div>
                    <div class="footer-top__desc">Перейдите в раздел <a href="<?php echo get_the_permalink(27); ?>">Контакты</a></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom__left flat-menu"><?php wp_nav_menu(
		            array(
			            'container' => false,
			            'item_spacing' => 'discard',
			            'menu' => 'Footer Left'
		            )
	            ); ?></div>
            <div class="footer-bottom__center flat-menu"><?php wp_nav_menu(
		            array(
			            'container' => false,
			            'item_spacing' => 'discard',
			            'menu' => 'Footer Right'
		            )
	            ); ?></div>
            <div class="footer-bottom__right"><div class="btn btn--big btn--alpha-dark" onclick="popup_c({'cat':'connect-with-us', 'title':'<?php echo nbsp( __t( 'Связаться с нами', 'Connect with Us' )); ?>', 'service': 1, 'description': '<?php echo nbsp( __t( 'Связаться с нами (подвал)', 'Connect with Us (footer)' )); ?>'}, this);">Связаться&nbsp;с&nbsp;нами</div></div>
        </div>
    </div>
</div>

    <div class="services__popup cta">
        <div class="cta__block">
            <form action="#" class="cta__form">
                <h3><?php echo __t( 'Связь с нами', 'Connect With Us' ); ?></h3>
                <div class="cta__cont">
                    <div class="cta__inputs">
                        <input type="text" name="cta__name" class="input--deep-blue" autocomplete="off" required placeholder="* <?php echo __t( 'Имя', 'Name' ); ?>">
                        <input type="text" name="cta__phone" class="input--deep-blue" autocomplete="off" required placeholder="* <?php echo __t( 'Номер телефона', 'Phone' ); ?>">
                        <input type="email" name="cta__email" class="input--deep-blue" autocomplete="off" required placeholder="* Email">
                    </div>
                    <div class="cta__service beauty-list">
                        <div class="beauty-list__head">
                            <div class="beauty-list__visible-title"><?php echo __t( 'Тип услуги', 'Type of service' ); ?></div>
                            <div class="beauty-list__ico"></div>
                        </div>
                        <div class="beauty-list__body">
                            <div class="beauty-list__item beauty-list__item--active" data-i="0" data-type="service">Авиаперевозки</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">Морские перевозки</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">Наземные перевозки</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">Складские услуги</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">IT-решения в логистике</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">Продажа авиабилетов</div>
                            <div class="beauty-list__item" data-i="1" data-type="service">Туристические услуги</div>
                        </div>
                    </div>
                </div>

                <label for="cta__message"><?php echo __t( 'Сообщение', 'Message' ); ?></label>
                <textarea name="message" class="cta__message input--deep-blue" autocomplete="off" id="cta__message" rows="4" title="<?php echo __t( 'Сообщение', 'Message' ); ?>"></textarea>

                <div class="wrap cta__center">
                    <button type="submit" class="btn btn--light-blue btn--medium">Отправить</button>
                </div>

                <div class="cta__status cta__status--loading">
                    <div class="cta__status-body">
                        <span class="cta__status-title">Идет отправка...</span>
                        <div class="spinner">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                    </div>
                </div>

                <div class="cta__status cta__status--success">
                    <div class="cta__status-body">
                        <span class="cta__status-title"><h4>Заявка отправлена!</h4><br>В ближайшее время Вам позвонят</span>
                    </div>
                </div>

                <div class="cta__status cta__status--error">
                    <div class="cta__status-body">
                        <span class="cta__status-title"><h4>Произошла ошибка!</h4><br>Заявка не отправлена</span>
                    </div>
                </div>

                <input type="hidden" name="url" value="<?php echo get_the_permalink(); ?>">
                <input type="hidden" name="description" value="default">
                <input type="hidden" name="service" value="default">
                <input type="hidden" name="type" value="default">
                <input type="hidden" name="cat" value="0">
                <input type="hidden" name="action" value="tbs_form">
            </form>
        </div>
    </div>

<?php wp_footer(); ?>

</body>
</html>