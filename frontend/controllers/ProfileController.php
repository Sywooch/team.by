<?php

namespace frontend\controllers;

use Yii;

use common\models\Category;
use common\models\User;

use frontend\models\ProfileAnketaForm;

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
		
		$model = User::findOne(\Yii::$app->user->id);
		$ProfileAnketaForm = new ProfileAnketaForm();
		//echo'<pre>';print_r($ProfileAnketaForm->attributes());echo'</pre>';
		//echo'<pre>';print_r($model->attributes());echo'</pre>';
		//echo'<pre>';print_r($model->toArray());echo'</pre>';
		
		$ProfileAnketaForm->attributes = $model->toArray();
		
		$userMedia = $this->getMedia($model);	//получам массив с картинками
		
		$ProfileAnketaForm->awards = $userMedia['awards'];
		$ProfileAnketaForm->examples = $userMedia['examples'];
		
		//$ProfileAnketaForm->load($model->attributes);
		echo'<pre>';print_r($ProfileAnketaForm->awards);echo'</pre>';
		
		$categories = Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$cats_l1 = [];
		$cats_l3 = [];

		foreach($categories as $c){
			if($c->parent_id == 1)	{
				$cats_l1[] = [
					'id'=>$c->id,
					'name'=>$c->name,
					'alias'=>$c->alias,
					'path'=>$c->path,
					'children'=>[],
				];				
			}	elseif($c->depth > 2)	{
				$cats_l3[$c->id] = $c->name;
			}
		}		
		
		foreach($cats_l1 as &$c_l1){
			foreach($categories as $c){
				if($c->parent_id == $c_l1['id']) {
					$c_l1['children'][] = [
						'id'=>$c->id,
						'name'=>$c->name,
						'alias'=>$c->alias,
						'path'=>$c->path,
					];
				}
			}
		}
		
		
		return $this->render('index', [
			'model' => $model,
			'ProfileAnketaForm' => $ProfileAnketaForm,
			'categories' => $cats_l1,
			'categories_l3' => $cats_l3,
			
		]);
		
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
	
	public function getMedia($user)
	{
		$awards = [];
		$examples = [];
		foreach($user->userMedia as $media) {
			switch($media->media_id)	{
				case 1:
					$awards[] = $media->filename;
					break;
				case 2:
					$examples[] = $media->filename;
					break;
			}
		}
		return['awards'=>$awards, 'examples'=>$examples];
	}

}
