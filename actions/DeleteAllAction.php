<?php
/**
 * DeleteAllAction class file.
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
class DeleteAllAction extends Action
{
    /**
     * @var array
     */
    public $redirectAction = ['index'];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = $this->controller->findModel();
        if ($count = $model::deleteAll(['id' => explode(',', Yii::$app->request->post('ids', ''))])) {
            Yii::$app->session->addFlash('success', Yii::t('modules/post', 'Successfully deleted {count} items.', [
                'count' => $count
            ]));
        } else {
            Yii::$app->session->addFlash('error', Yii::t('modules/post', 'Could not delete items.'));
        }
        return $this->controller->redirect($this->redirectAction);
    }
}
