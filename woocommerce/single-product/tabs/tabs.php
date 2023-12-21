<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>
<div class="col-12">
  <div class="description card card-body shadow bg-body-tertiary rounded">
    <div class="row">
    <?php foreach ($product_tabs as $key => $product_tab) : ?>
      <div class="col">
        <?php
        if (isset($product_tab['callback'])) {
          call_user_func($product_tab['callback'], $key, $product_tab);
        }
        ?>
        <!-- <h2 class="block-title text-nowrap">Описание</h2>
        <p>Установка TLauncher за&#160;1 минуту. Ниже ссылки для скачивания. Не&#160;забудь указать свой НИК на&#160;сайте как НИК в&#160;TLauncher</p>
        <p>(Краткое описание 105 символов максимально, закголовок 56 символов максимально)</p>
        <p>Итого все объявление макс 161 символ как в&#160;директе. Заголовок + краткое.</p>
        <p>Ниже идет полное описание выводится следом за&#160;кратким, через отступ. Заголовок Описание не&#160;выводим.</p>
        <p>Полное описание, его лучше не&#160;разгонять. Всю интересную информацию, но&#160;объёмную лучше перенести вниз в&#160;проектчат. Там она будет структурированная по&#160;оглавлению/категориям чатов. Там&#160;же можно отзывы, картинки, шаблоны исполнительной документации, карточек нарядов и&#160;т.&#160;д.</p>
        <p>Добавляем, ключевые слова в&#160;полное описание. Но&#160;заполняем их&#160;в&#160;карточке товара в&#160;поле SEO</p>
        <p>Ставим внизу полного описание, это пригодится для SEO и&#160;важно при выгрузке товаров на&#160;маркетплейсы. Там это тоже поднимает товар в&#160;поиске.</p>
        <p>В&#160;полном описании можно с&#160;помощью текстового редактора вставлять фотки</p> -->
      </div>
      <div class="col"> 
        <h2 class="block-title text-nowrap">Характеристики</h2>
        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
          <li class="list-group-item d-flex px-0 pt-1 pb-2"><span class="text-nowrap">Название</span><span class="line mx-2"></span><span class="text-nowrap">Название</span></li>
        </ul><a class="d-block delivery py-2" href="" role="button">Доставка и оплата</a><a class="d-block conditions py-2" href="" role="button">Условия продажи</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="col-12">
  <?php do_action('woocommerce_product_after_tabs'); ?>
</div>
  
<?php endif; ?>
