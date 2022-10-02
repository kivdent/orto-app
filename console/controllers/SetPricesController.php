<?php

namespace console\controllers;

use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\pricelists\models\PricelistItems;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use yii\console\Controller;

class SetPricesController extends Controller
{
    public function actionFromMay()
    {
        echo "Поиск позиций. \n";
        foreach (Pricelist::find()->where(['active' => 1])->all() as $priceList) {
            echo $priceList->title . "\n";
            foreach ($priceList->getActiveCategoryes() as $categorye) {
                echo "--" . $categorye->title . "\n";
                foreach ($categorye->getActiveItemsFromCategory() as $item) {
//                    UserInterface::getVar($item);
                    if ($item->priceForItem->coefficient <> 0) {
                        $newPrice = new Prices();
                        $oldPrice = $item->priceForItem;
                        $newPrice->created_at = "2022-05-01 08:00:17";
                        $newPrice->updated_at = "2022-05-01 08:00:17";
                        $newPrice->price = $oldPrice->price;
                        $newPrice->pricelist_items_id = $oldPrice->pricelist_items_id;
                        $newPrice->coefficient = round($oldPrice->coefficient * 1.05, 2);
                        $newPrice->active = 1;

                        $oldPrice->active = 0;

                        echo "----" . $oldPrice->id . " " . $oldPrice->coefficient . " " . $oldPrice->created_at . " " . $oldPrice->active . "\n";
                        echo "----" . $newPrice->id . " " . $newPrice->coefficient . " " . $newPrice->created_at . " " . $newPrice->active . "\n";

                        $oldPrice->save(false);
                        $newPrice->detachBehaviors();
                        $newPrice->save(false);

                        $invoiceItems = InvoiceItems::find()
                            ->where(['invoice_items.prices_id' => $oldPrice->id])
                            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
                            ->andWhere('invoice.created_at>\'2022-05-01\'')
                            ->all();
                        UserInterface::getVar( $invoiceItems,false);
                        foreach ($invoiceItems as $invoiceItem) {
                            $invoiceItem->prices_id = $newPrice->id;
                            $invoiceItem->save(false);
                        }

                    }
                }
            }
        }
    }
}