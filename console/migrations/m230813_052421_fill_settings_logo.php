<?php

use common\modules\clinic\models\Settings;
use yii\db\Migration;

/**
 * Class m230813_052421_fill_settings_logo
 */
class m230813_052421_fill_settings_logo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $logo = new Settings(['name'=>'logo']);
        $smsApiKey = new Settings(['name'=>'smsApiKey']);
        $yandexDiskToken = new Settings(['name'=>'yandexDiskToken']);
        $logo->save(false);
        $smsApiKey->save(false);
        $yandexDiskToken->save(false);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230813_052421_fill_settings_logo cannot be reverted.\n";

        return false;
    }
    */
}
