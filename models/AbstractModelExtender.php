<?php
/**
 * AbstractModel class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\models;

use Yii;

function get_dynamic_parent(){
    $backtrace = debug_backtrace();
    foreach ($backtrace as $key => $data) {
        if (@$data['args'][0] != 'bariew\abstractModule\models\AbstractModelExtender') {
            continue;
        }
        $class = $backtrace[$key+6]['args'][0];
        break;
    }
    return preg_replace('#^(.+)Search$#', '$1', $class);
}

class_alias(get_dynamic_parent(), 'bariew\abstractModule\models\DynamicParent');
/**
 * Description.
 *
 * CAUTION!
 * You cannot use this class extending from different models in a same process.
 *
 * @mixin AbstractModel
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class AbstractModelExtender extends DynamicParent
{
    /**
     * @inheritdoc
     */
    public function search($params = [])
    {
        /** @var \yii\db\ActiveQuery $result */
        $result = parent::search($params);
        $result->modelClass = parent::parentClass();
        return $result;
    }
}
