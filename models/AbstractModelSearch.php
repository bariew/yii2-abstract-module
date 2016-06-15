<?php
/**
 * AbstractModelSearch class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\models;

use bariew\abstractModule\Module;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Searches ars.
 * 
 * 
 * @example
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class AbstractModelSearch extends AbstractModel
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $class = preg_replace('#^(.+)Search$#', '$1', static::className());
        return new ActiveDataProvider(['query' => (new $class())->search()]);
    }
}
