<?php
/**
 * DeleteAction class file.
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
class DeleteAction extends Action
{
    public $redirectAction = ['index'];
    /**
     * @inheritdoc
     */
    public function run($id)
    {
        if ($this->controller->findModel($id)->delete()) {
            Yii::$app->session->addFlash('success', Yii::t('modules/post', 'Successfully deleted.'));
        } else {
            Yii::$app->session->addFlash('error', Yii::t('modules/post', 'Could not delete item.'));
        }

        if (Yii::$app->request->isAjax) {
            return true;
        }
        $this->controller->redirect($this->redirectAction) && Yii::$app->end();
    }
}