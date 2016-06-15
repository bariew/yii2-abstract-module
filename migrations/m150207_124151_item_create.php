<?php

use yii\db\Migration;
use bariew\abstractModule\models\AbstractModel;

class m1606145_152251_abstract_model_create extends Migration
{
    public function up()
    {
        $this->createTable(AbstractModel::tableName(), []);
    }

    public function down()
    {
        $this->dropTable(AbstractModel::tableName());
    }
}
