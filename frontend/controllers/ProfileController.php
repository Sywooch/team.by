<?php

namespace frontend\controllers;

use Yii;

use common\models\Category;
use common\models\User;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProfileController extends Controller
{

    public function actionIndex()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		//$model = Category::findOne($id)
		//echo'<pre>';print_r(\Yii::$app->user->identity);echo'</pre>';
		$model = User::findOne(\Yii::$app->user->id);
		
		return;
//		return $this->render('index', [
//			'categories' => $cats_l1,
//		]);
		
	}
		
    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
