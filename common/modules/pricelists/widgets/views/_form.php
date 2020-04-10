<?php

use yii\helpers\Html;
use common\modules\pricelists\widgets\PriceListsWidget;

/* @var $priceList \common\modules\pricelists\models\Pricelist */
/* @var $priceLists  array */
/* @var $type string */
/* @var $activePriceList integer */
/* @var $activeLabel string */
/* @var $activateBtnClass string */

?>
<div class="row" name="price-lists-navigation">
    <div class="col-lg-12">
        <div class="price-list-choose">

            <ul class="nav nav-tabs" role="tablist">
                <?php
                foreach ($priceLists as $priceList): ?>

                    <li role="presentation"
                        class="<?php if ($activePriceList == $priceList->id) {
                            echo 'active';
                        } ?>">
                        <?= Html::a($priceList->title . $activeLabel[$priceList->active], '#price_list_id_' . $priceList->id, [
                            'aria-controls' => "price_list_id_" . $priceList->id,
                            'role' => "tab",
                            'data-toggle' => "tab",

                        ]) ?>

                    </li>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="row" name="price-list-content">
    <div class="col-lg-12">
        <div class="tab-content price-list">
            <?php
            $flag = true;
            foreach ($priceLists as $priceList): ?>
                <div role="tabpanel"
                     class="tab-pane <?php if ($activePriceList == $priceList->id) {
                         echo 'active';
                     } ?>" id="<?= "price_list_id_" . $priceList->id ?>">

                    <?php if ($type == PriceListsWidget::TYPE_EDIT): ?>

                        <div id="pricelist-action">
                            <p>
                                <h5><span class="label label-default">
                                    Тип прейскуранта: <?= $priceList->type ? $priceList->typeList[$priceList->type] : 'Не определён' ?>
                                </span></h5>
                                <?= Html::a('Изменить', ['update', 'id' => $priceList->id], ['class' => 'btn btn-primary btn-xs']) ?>
                                <?= Html::a($priceList->active ? 'Деактивировать' : 'Активировать',
                                    ['delete', 'id' => $priceList->id],
                                    [
                                        'class' => $activateBtnClass[$priceList->active],
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                <?= Html::a('Новая категория',
                                    ['/pricelists/price/create-category',
                                        'pricelist_id' => $priceList->id,
                                        'category' => 1,
                                        'superior_category_id' => 0],
                                    ['class' => 'btn btn-success btn-xs'])
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <ul class="nav nav-pills nav-stacked">


                        <?php foreach (PriceListsWidget::getCategoryes($priceList->id, $type) as $category): ?>
                            <li class="active">

                                <a data-toggle="collapse"
                                   href="#collapse-category-id-<?= $category->id ?>"
                                   aria-expanded="false"
                                   aria-controls="collapse-category-id-<?= $category->id ?>">
                                    <?= $category->title . $activeLabel[$category->active] ?>
                                    <span class="caret"></span>
                                </a>


                                <div class="collapse" id="collapse-category-id-<?= $category->id ?>">
                                    <?php if ($type == PriceListsWidget::TYPE_EDIT): ?>
                                        <?= Html::a('Новая позиция в прейскурант',
                                            [
                                                '/pricelists/price/create-price',
                                                'pricelist_id' => $priceList->id,
                                                'category' => 0,
                                                'superior_category_id' => $category->id
                                            ],
                                            ['class' => 'btn btn-success btn-xs'])
                                        ?>


                                        <?= Html::a('Изменить категорию',
                                            [
                                                '/pricelists/price/update-category',
                                                'id' => $category->id,
                                            ],
                                            ['class' => 'btn btn-primary btn-xs'])
                                        ?>

                                        <?= Html::a($category->active ? 'Деактивировать' : 'Активировать',
                                            ['/pricelists/price/delete', 'id' => $category->id],
                                            [
                                                'class' => $activateBtnClass[$category->active],
                                                'data' => [
                                                    // 'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                    <?php endif; ?>
                                    <table class="table">
                                        <?php foreach (PriceListsWidget::getItemsFromCategory($category->id, $type) as $pricelistItem): ?>
                                            <tr>
                                                <td>


                                                    <?php if ($type == PriceListsWidget::TYPE_EDIT): ?>
                                                        <?= $pricelistItem->title . $activeLabel[$pricelistItem->active] ?>
                                                        <br>
                                                        <?= Html::a('Изменить позицию',
                                                            [
                                                                '/pricelists/price/update-price',
                                                                'id' => $pricelistItem->id,
                                                            ],
                                                            ['class' => 'btn btn-primary btn-xs'])
                                                        ?>
                                                        <?= Html::a($pricelistItem->active ? 'Деактивировать' : 'Активировать',
                                                            ['/pricelists/price/delete', 'id' => $pricelistItem->id],
                                                            [
                                                                'class' => $activateBtnClass[$pricelistItem->active],
                                                                'data' => [
                                                                    // 'confirm' => 'Are you sure you want to delete this item?',
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                    <?php else: ?>
                                                        <a href="#" class="manipulation-item"
                                                           id="<?= $pricelistItem->priceId ?>"
                                                           price="<?= $pricelistItem->price ?>">
                                                            <?= $pricelistItem->title ?>

                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>

                                                    <?php echo $pricelistItem->price ?> р
                                                </td>
                                                <?php if ($type == PriceListsWidget::TYPE_EDIT): ?>
                                                    <td>
                                                        <?php echo $pricelistItem->coefficient ?> б
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </li>
                        <?php endforeach; ?>


                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>