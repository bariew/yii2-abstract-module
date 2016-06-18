<?php
/**
 * IndexAction class file.
 * @copyright (c) 2015, bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\abstractModule\actions;

use yii\base\Action;
use Yii;
use bariew\abstractModule\controllers\AbstractModelController;
use bariew\abstractModule\models\AbstractModel;
/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 * @property AbstractModelController $controller
 */
class IndexAction extends Action
{
    public $view = 'index';
    public $ajaxView = 'index-ajax';
    public $params = [];
    public $search = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        //$a = (new \app\modules\user\models\CompanySearch())->search([]);
        /**
         * @var AbstractModel $searchModel
         */
        $searchModel = $this->controller->findModel(false, true);

        $data = array_merge([
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(
                array_merge(Yii::$app->request->queryParams, $this->search
            )),
        ], $this->params);

        return Yii::$app->request->isAjax
            ? $this->controller->renderAjax($this->ajaxView, $data)
            : $this->controller->render($this->view, $data);
    }
}