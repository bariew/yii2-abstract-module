<?php
/**
 * UpdateAction class file.
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
class UpdateAction extends Action
{
    public $view = 'update';
    public $redirectAction = 'view';

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $model = $this->controller->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('modules/post', 'Successfully updated.'));
            if (!Yii::$app->request->isAjax) {
                $this->controller->redirect([$this->redirectAction, 'id' => $model->id]) && Yii::$app->end();
            }
        }
        $render = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->controller->$render($this->view, compact('model'));
    }
}