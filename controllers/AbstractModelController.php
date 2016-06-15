<?php
/**
 * ItemController class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\controllers;

use bariew\abstractModule\models\AbstractModel;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use bariew\abstractModule\Module;

/**
 * For managing abstract items.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class AbstractModelController extends Controller
{
    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer|boolean $id
     * @param boolean $search
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id = false, $search = false)
    {
        $class = preg_replace('#^(.+)/controllers/(.+)Controller#', '$1/models/$2', static::className())
            . ($search ? 'Search' : '');
        $model = new $class();
        if ($id && (!$model = $model->search(compact('id'))->one())) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
