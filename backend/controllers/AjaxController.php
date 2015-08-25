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
		$profile_model = Yii::$app->session->get('profile_model', 'OrderForm');

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
			//echo'imageFiles<pre>';print_r($model->imageFiles);echo'</pre>';//die;
			//echo'$_FILES<pre>';print_r($_FILES);echo'</pre>';//die;
			
            if ($model->upload()) {
				
				$img_path = $model->path. '/' . $model->filename;
				$img_dimentions = $this->getImageDimentions($img_path);
				
				$watermark_path = Yii::getAlias('@frontend').'/web/images/watermark.png';
				$w_img_dimentions = $this->getImageDimentions($watermark_path);
				
				if($img_dimentions['width'] < Yii::$app->params['max-image-res']['width'] || $img_dimentions['height'] < Yii::$app->params['max-image-res']['height']) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				Image::thumbnail( $img_path, Yii::$app->params['max-image-res']['width'], Yii::$app->params['max-image-res']['height'])
					->save(Yii::getAlias($img_path), ['quality' => 100]);

				$img_dimentions = $this->getImageDimentions($img_path);

				Image::watermark($img_path, $watermark_path, [($img_dimentions['width'] - $w_img_dimentions['width'] - 20), ($img_dimentions['height'] - $w_img_dimentions['height'] - 20)])
					->save(Yii::getAlias($img_path));
				
				Image::thumbnail( $img_path, 75, 90)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[review_foto][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(Yii::$app->params['homeUrl'] . '/tmp/thumb_' .$model->filename), Yii::$app->params['homeUrl'] . '/tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'review_foto_images']);
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

	public function getImageDimentions($img_path)
	{
		$img = Image::getImagine()->open($img_path); //загружаем изображение
		$image_size = $img->getSize();	//получаем размеры изображения
		$img_w = $image_size->getWidth();
		$img_h = $image_size->getHeight();
		
		return ['width'=>$image_size->getWidth(), 'height'=>$image_size->getHeight()];
	}

}
