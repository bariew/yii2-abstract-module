<?php
/**
 * ViewAction class file.
 * @copyright (c) 2015, bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */


namespace bariew\abstractModule\actions;

use yii\base\Action;
use Yii;
use bariew\abstractModule\controllers\AbstractModelController;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 * @property AbstractModelController $controller
 */
class ViewAction extends Action
{
    public $view = 'view';
    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $render = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->controller->$render($this->view, [
            'model' => $this->controller->findModel($id),
        ]);
    }
}