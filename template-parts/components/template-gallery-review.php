<?php
/**
 * An example implementation of the component in code
 *
 * Using content of component in a custom implementation of the html
 *
 * @author Dmitry
 * @version 0.01
 * @package component
 *
 * COMPONENT IMPLEMENTATION: Галерея для Отзывов
 *
 */

global $Mammen;
?>

<?php
tbs_video_style_js_init ();
?>

<div class="reviews__first section">
    <div class="main">
        <div class="center">
            <div class="center__top">
                <h3>Видео отзывы</h3>
                <div class="content__block">
                    <div class="container__video">
                        <ul id="youtubelist">
                        <?php
                        $videos = $Mammen->get_fields( 'Видео' );
                        if ( count( $videos ) ) {
                            $indexes = tbs_rand_indexes(1, count($videos), 5);
                            for ($i=0; $i<count($indexes); ++$i) {
                                ?>
                                <li><a href="<?php echo $videos[$indexes[$i]]->get_field('Ссылка на Youtube видео'); ?>"
                                       data-url="<?php echo $videos[$indexes[$i]]->get_field('Ссылка на Youtube видео'); ?>"><?php echo $videos[$indexes[$i]]->get_field('Название видео'); ?></a></li>
                                <?php
                            }
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="center__bottom">
                <h3>Фотографии гостей</h3>
                <div class="content__block review__block">
	                <?php
	                $photos = $Mammen->get_fields( 'Фото' );
	                if ( count( $photos ) ) {
		                $indexes = tbs_rand_indexes(1, count($photos), 5);
		                for ( $i = 0; $i < count( $indexes ); ++ $i ) {
			                ?>
                            <div class="review__photo" style="background-image: url(<?php echo $photos[$indexes[$i]]->get_img( 'Фото клиента', 'large' )[0]['src']; ?>)"></div>
			                <?php
		                }
	                }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="reviews__second section">
    <div class="main">
        <div class="center">
            <div class="center__top">
                <h3>Отзывы наших гостей</h3>
                <div class="center__top__reviews">
                <?php
                $reviews = $Mammen->get_fields( 'Отзывы' );
                if ( count( $reviews ) ) {
                    $indexes = tbs_rand_indexes( 1, count( $reviews ), 5 );
                    for ( $i = 0; $i < count( $indexes ); ++ $i ) {
                        ?>
                        <div class="center__reviews__block">
                            <p><?php echo $reviews[$indexes[$i]]->get_field('Имя'); ?></p>
                            <hr>
                            <p class="reviews__question"><?php echo $reviews[$indexes[$i]]->get_field('Вопрос'); ?></p>
                            <p class="text--italic"><?php echo $reviews[$indexes[$i]]->get_field('Ответ'); ?></p>
                        </div>
                        <?php
                    }
                }
                ?>
                </div>
            </div>
            <div class="center__bottom">
                <h3>Напишите нам отзыв</h3>
                <div class="container cta__block cta__block--none-style">
                    <form action="#" class="cta__form reviews__form">
                        <textarea name="cta__text" id="" cols="30" rows="10" placeholder="Написать текст" required ></textarea>
                        <input name="cta__name" class="reviews__form__input reviews__name" type="text" placeholder="Имя" required  pattern="[a-zA-Zа-яА-Я]{2,}">
                        <input name="cta__last-name" class="reviews__form__input reviews__lname" type="text" placeholder="Фамилия" required  pattern="[a-zA-Zа-яА-Я]{2,}">
                        <input name="cta__email" class="reviews__form__input reviews__email" type="text" placeholder="Email" required>
                        <button class="btn" type="submit">Отправить</button>

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
                                <span class="cta__status-title"><b>Отзыв успешно отправлен!</b><br>Спасибо за ваше мнение</span>
                            </div>
                        </div>

                        <div class="cta__status cta__status--error">
                            <div class="cta__status-body">
                                <span class="cta__status-title"><b>Произошла ошибка!</b><br>Заявка не отправлена</span>
                            </div>
                        </div>

                        <input type="hidden" name="url" value="<?php echo get_the_permalink(); ?>">
                        <input type="hidden" name="description" value="Отзыв">
                        <input type="hidden" name="type" value="default">
                        <input type="hidden" name="cat" value="отзывы">
                        <input type="hidden" name="action" value="tbs_form">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>