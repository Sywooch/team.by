<?php
namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ReviewsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUser($id)
    {
		$user = \common\models\User::findOne($id);
		if($user !== null) {
			
			$query = \common\models\Review::find()
				->distinct(true)
				->joinWith(['client'])
				->joinWith(['reviewMedia'])
				->where(['user_id'=>$user->id])
				->orderBy('created_at DESC');
			
			
			$DataProvider = new ActiveDataProvider([
				'query' => $query,

				'pagination' => [
					'pageSize' => Yii::$app->params['catlist-per-page'],
					//'pageSize' => 2,
					'pageSizeParam' => false,
				],
			]);
			
		} else {
			throw new NotFoundHttpException('Пользователь с данным ID отсутствует.');
		}

		return $this->render('user-reviews', [
			'user' => $user,
			'dataProvider'=>$DataProvider,
		]);
    }

}
