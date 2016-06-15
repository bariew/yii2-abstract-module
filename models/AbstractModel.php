<?php
/**
 * AbstractModel class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\models;

use bariew\abstractModule\Module;
use Yii;
use \yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class AbstractModel extends ActiveRecord
{
    /**
     * Gets class name for a model that inherits current modules model.
     * @param $className
     * @param null $formName
     * @param array $replacements
     * @return \yii\db\ActiveRecord
     */
    public static function getClass($className = null, $formName = null, $replacements = [])
    {
        $className = $className ? : static::className();
        $class = $formName
            ? preg_replace('/(.*\\\\)\w+$/', '$1' . $formName, $className)
            : $className;
        return str_replace(array_keys($replacements), array_values($replacements), $class);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $moduleName = preg_replace('#.*\\\\(\w+)\\\\models\\\\\w+$#','$1', static::className());
        return '{{%'.$moduleName . '_' . Inflector::camel2id(static::formName()).'}}';
    }

    /**
     * Gets search query.
     * @param array $params search params key=>value
     * @return ActiveQuery
     */
    public function search($params = [])
    {
        return $this::find()->andFilterWhere(array_merge($this->attributes, $params));
    }

}
