<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\imagine\Image;

use frontend\models\UploadPriceForm;
use frontend\models\UploadAwardsForm;
use frontend\models\UploadAvatarForm;
use frontend\models\UploadExamplesForm;

use common\models\Category;

class AjaxController extends Controller
{
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
//        ];
//    }
	
    public function beforeAction($action) {
        //$this->enableCsrfValidation = ($action->id !== "reg-step2-upload-price"); 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }	

    public function actionIndex()
    {
		echo 'index';
    }
	
    public function actionUploadPrice()
    {
        $model = new UploadPriceForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'RegStep2Form[price_list]', $model->filename);
				
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadAwards()
    {
        $model = new UploadAwardsForm();

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
			//echo'imageFiles<pre>';print_r($model->imageFiles);echo'</pre>';//die;
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 600 || $image_size->getHeight() < 800) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				Image::thumbnail( $model->path. '/' . $model->filename, 75, 90)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'RegStep2Form[awards][]', $model->filename);
				//$json_arr['file'] = Url::home(true) . 'tmp/' .$model->filename;
				//$json_arr['thumb_file'] = Url::home(true) . 'tmp/thumb_' .$model->filename;
				$json_arr['html_file'] = Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->filename), Url::home(true) . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
				$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadAvatar()
    {
        $model = new UploadAvatarForm();

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
			//echo'imageFiles<pre>';print_r($model->imageFiles);echo'</pre>';//die;
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 600 || $image_size->getHeight() < 800) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				Image::thumbnail( $model->path. '/' . $model->filename, 275, 280)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'RegStep2Form[avatar]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->filename), Url::home(true) . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox']);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadExamples()
    {
        $model = new UploadExamplesForm();

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 600 || $image_size->getHeight() < 800) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				Image::thumbnail( $model->path. '/' . $model->filename, 75, 90)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'RegStep2Form[examples][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->filename), Url::home(true) . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
				$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionGetChildrens($id)
    {
		$model = Category::findOne($id);
		//print_r($model);die;
		$children = $model->children()->all();
		return $this->renderPartial('children-list', [
			'model'=>$model,
			'children'=>$children,
		]);
		
	}
	
	
	public function printErrors($model, $error_msg = '')
	{
		$json_arr['res'] = 'error';

		foreach($model->getFirstErrors() as $err) 
			$json_arr['msg'][] = $err;
		
		if($error_msg != '')
			$json_arr['msg'][] = $error_msg;

		echo Json::encode($json_arr);
		
		return;
	}


}
