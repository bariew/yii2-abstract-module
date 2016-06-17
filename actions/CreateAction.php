<?php
/**
 * CreateAction class file.
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
class CreateAction extends Action
{
    public $view = 'create';
    public $redirectAction = 'view';
    public $modelAttributes = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = $this->controller->findModel(null);
        foreach ($this->modelAttributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        };
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Successfully created.'));
            if (Yii::$app->request->isAjax) {
                return $this->controller->redirect(Yii::$app->request->referrer);
            } else {
                $this->controller->redirect([$this->redirectAction, 'id' => $model->id]) && Yii::$app->end();
            }
        }
        $render = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->controller->$render($this->view, compact('model'));
    }
}