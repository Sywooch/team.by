<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\imagine\Image;

class AjaxController extends Controller
{
	
    public function beforeAction($action) {
        //$this->enableCsrfValidation = ($action->id !== "reg-step2-upload-price"); 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }	

    public function actionIndex()
    {
		echo 'index';
    }
	
    public function actionUploadReviewFoto()
    {
        $model = new \backend\models\UploadReviewsFotoForm();
		
		$profile_model = 'OrderForm';

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
			//echo'imageFiles<pre>';print_r($model->imageFiles);echo'</pre>';//die;
			//echo'$_FILES<pre>';print_r($_FILES);echo'</pre>';//die;
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 600 || $image_size->getHeight() < 800) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				Image::thumbnail( $model->path. '/' . $model->filename, 70, 45)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[review_foto][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(Yii::$app->urlManagerFrontEnd->baseUrl . '/tmp/thumb_' .$model->filename), Yii::$app->urlManagerFrontEnd->baseUrl . '/tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
				$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
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
