<?php
/**
 * AbstractModule class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class AbstractModule extends \yii\base\Module
{
    public static function childClass()
    {
        $myClass = get_called_class();
        foreach (\Yii::$app->modules as $module) {
            if (is_string($module)) {
                $class = $module;
            } else if(is_array($module)) {
                $class = $module['class'];
            } else {
                $class = get_class($module);
            }
            if (is_subclass_of($class, $myClass)) {
                return $class;
            }
        }
        return null;
    }

    public static function getNamespace()
    {
        return preg_replace('#^(.+)\\\\\w+$#', '$1', static::childClass());
    }
}