<?php
/**
 * ItemController class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * For managing abstract items.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class AbstractModelController extends Controller
{
    public $modelName = '$2';
    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer|boolean $id
     * @param boolean $search
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException
     */
    public function findModel($id = false, $search = false)
    {
        $class = preg_replace(
            '#^(.+)\\\\controllers\\\\(.+)Controller#',
            '$1\\\\models\\\\'.$this->modelName,
            static::className()
        ) . ($search ? 'Search' : '');
        $model = new $class();
        if ($id && (!$model = $model->search(compact('id'))->one())) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
