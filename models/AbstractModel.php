<?php
/**
 * AbstractModel class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\models;

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
     * Gets class name for a parent model for the current module's model.
     * @return static
     */
    public static function parentClass()
    {
        $parents = array_values(class_parents(get_called_class()));
        $currentClass = $parents[array_search(get_parent_class(), $parents) - 2];
        $pattern = '#^(.+\\\\)(\w+)$#';
        $myFormName = preg_replace($pattern, '$2', $currentClass);
        return preg_replace($pattern, '$1'.$myFormName, get_called_class());
    }

    /**
     * Gets class name for a model that inherits current modules model.
     * CAUTION! This works only when called from inside another module model
     * @return \yii\db\ActiveRecord
     */
    public static function childClass()
    {
        $data = debug_backtrace();
        $callingClassName = $data[1]['object']->className();
        $pattern = '#^(.+\\\\)(\w+\\\\\w+)$#';
        $formName = preg_replace($pattern, '$2', get_called_class());
        return preg_replace($pattern, '$1'.$formName, $callingClassName);
    }

    public static function moduleName($className)
    {
        return preg_replace('#.*\\\\(\w+)\\\\\w+\\\\\w+$#','$1', $className);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $name = preg_replace(['#.*\\\\(\w+)\\\\models\\\\(\w+)$#', '#^(.+)Search$#'],['$1$2', '$1'], static::className());
        return '{{%'.Inflector::camel2id($name, '_').'}}';
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
