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
use yii\helpers\ArrayHelper;

use yii\imagine\Image;

use frontend\models\UploadPriceForm;
use frontend\models\UploadAwardsForm;
use frontend\models\UploadAvatarForm;
use frontend\models\UploadExamplesForm;
use frontend\models\UploadLicenseForm;

use common\models\Category;
use common\models\User;
use common\models\Region;
use common\models\UserCategories;
use common\models\UserSpecials;

use common\helpers\DImageHelper;


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
	/*
    public function actionUploadPrice()
    {
        $model = new UploadPriceForm();
		
		$profile_model = Yii::$app->session->get('profile_model', 'RegStep2Form');

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[price_list]', $model->filename);
				
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
		
		$profile_model = Yii::$app->session->get('profile_model', 'RegStep2Form');

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
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[awards][]', $model->filename);
				//$json_arr['file'] = Url::home(true) . 'tmp/' .$model->filename;
				//$json_arr['thumb_file'] = Url::home(true) . 'tmp/thumb_' .$model->filename;
				$json_arr['html_file'] = Html::a(Html::img('http://team.by/' . 'tmp/thumb_' .$model->filename), 'http://team.by/' . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
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
		
		$profile_model = Yii::$app->session->get('profile_model', 'RegStep2Form');

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
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[avatar]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img('http://team.by/' . 'tmp/thumb_' .$model->filename, ['class'=>'img-responsive']), 'http://team.by/' . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox']);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadLicense()
    {
        $model = new UploadLicenseForm();
		
		$profile_model = Yii::$app->session->get('profile_model', 'RegStep2Form');

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
				
				Image::thumbnail( $model->path. '/' . $model->filename, 190, 130)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[license]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img('http://team.by/' . 'tmp/thumb_' .$model->filename, ['class'=>'img-responsive']), 'http://team.by/' . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox']);
				
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
		
		$profile_model = Yii::$app->session->get('profile_model', 'RegStep2Form');

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 600 || $image_size->getHeight() < 800) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				//Image::thumbnail( $model->path. '/' . $model->filename, 75, 90)
				Image::thumbnail( $model->path. '/' . $model->filename, 190, 130)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[examples][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img('http://team.by/' . 'tmp/thumb_' .$model->filename), 'http://team.by/' . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
				$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	*/
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
	
    public function actionGetSpecFields($id)
    {
		$model = Category::findOne($id);
		return $this->renderPartial('get-spec-fields', [
			'model'=>$model,
		]);
		
	}
	
    public function actionGetspeclist()
    {
		$phone = Yii::$app->request->post('phone', '');
		
		$client = \common\models\Client::find()->where(['phone' => $phone])->one();
		//echo'<pre>';print_r($client);echo'</pre>';die;
		if($client !== NULL)	{
			//$orders = $client->orders;
			$orders = \common\models\Order::find()
				->joinWith(['user'])
				->where(['client_id'=>$client->id])
				//->andWhere(['{{%order}}.status' => 4])	// 4 - оплачен, ожидает отзыва
				->all();

			//echo'<pre>';print_r($orders);echo'</pre>';die;
			/*
			$users = \common\models\User::find()
					->distinct(true)
					->joinWith(['orders'])
					->where(['{{%order}}.client_id'=>$client->id])
					->all();
				*/
			
			$spec_arr = [];
			foreach($orders as $order) {
				if($order->review === null)
					$spec_arr[$order->id] = $order->user->fio . ' заказ №'. $order->id;
			}

			//$users_arr = [null => '--- Выберите ----'] + ArrayHelper::map($users, 'id', 'fio');			
			$users_arr = [null => '--- Выберите ----'] + $spec_arr;			
		}	else	{
			$users_arr = [null => '--- Заказы не найдены ----'];
		}
		
		echo Html::dropDownList('AddReviewForm[order_id]', 0, $users_arr, ['class'=>'form-control', 'id'=>'addreviewform-order_id']);
		
		return;
	}
	
    public function actionUploadReviewfoto()
    {
        $model = new \frontend\models\UploadReviewFotoForm();

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$img_path = $model->path. '/' . $model->filename;
				
				$img_dimentions = DImageHelper::getImageDimentions($img_path);
				
				if($this->checkImageDimentions($model, $img_dimentions) === false)
					return;
								
				DImageHelper::processImage($model->path, $model->filename, 70, 45, $img_dimentions);
				
				/*
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 320 || $image_size->getHeight() < 240) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				//Image::thumbnail( $model->path. '/' . $model->filename, 75, 90)
				Image::thumbnail( $model->path. '/' . $model->filename, 70, 45)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				*/
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'AddReviewForm[foto][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(DImageHelper::getImageUrl($model->filename, 'tmp', 1)), DImageHelper::getImageUrl($model->filename, 'tmp', 0), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
				//$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionProfiSearch()
    {
		$search = Yii::$app->request->post('profi_search', '');
		$region_id = Yii::$app->request->post('region_id', 1);
		if($search != '') {
			$search = Html::encode($search);
			$region_ids = '';
			
			if($region_id != 1) {
				$region = Region::findOne($region_id);
				$region_children = $region->children()->all();
				$region_ids = [$region_id => $region_id] + ArrayHelper::map($region_children, 'id', 'id');
			}
						
			//ищем по ФИО и специализации
			$query = User::find()
				->asArray()
				//->where("fio LIKE '%$search%' OR specialization LIKE '%$search%'")
				->where(['like', 'fio', $search])
				->orWhere(['like', 'specialization', $search]);
			
			
			
			
			if($region_ids != '')
				//$query->andWhere("region_id IN ($region_ids)");
				$query->andWhere(['region_id' => $region_ids]);
			
			$search1 = $query->all();
			
			echo'<pre>';print_r($search1);echo'</pre>';die;
			
			
			//ищем по категориям
			$categories = Category::find()
				->asArray()
				//->where("name LIKE '%$search%'")
				->where(['like', 'name', $search])
				->all();
			
			$ids = [];			
			foreach($categories as $i) $ids[] = $i['id'];
				
			$UserCategories = UserCategories::find()
				->asArray()
				->where("category_id IN (". implode(',', $ids) .")")
				->all();
			
			$ids = [];			
			foreach($UserCategories as $i) $ids[] = $i['user_id'];
			
			$query = User::find()
				->asArray()
				->where("id IN (". implode(',', $ids) .")");
			
			if($region_ids != '')
				$query->andWhere("region_id IN ($region_ids)");
			
			$search2 = $query->all();
			
			//ищем по услугам используем опять массив категорий
			// так как услуги это тоже категории только 3-го уровня
			$ids = [];			
			foreach($categories as $i) $ids[] = $i['id'];
			
			$UserSpecials = UserSpecials::find()
				->asArray()
				->where("category_id IN (". implode(',', $ids) .")")
				->all();
			
			$ids = [];			
			foreach($UserSpecials as $i) $ids[] = $i['user_id'];
			
			
			//echo'<pre>';print_r($query);echo'</pre>';//die;			
			echo'<pre>';print_r($search2);echo'</pre>';//die;
			
		}	else	{
			echo 'err';
		}
		
		return;
		
		$model = Category::findOne($id);
		return $this->renderPartial('get-spec-fields', [
			'model'=>$model,
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

	public function checkImageDimentions(&$model, $img_dimentions)
	{
		if($img_dimentions['width'] < Yii::$app->params['max-image-res']['width'] || $img_dimentions['height'] < Yii::$app->params['max-image-res']['height']) {
			$this->printErrors($model, 'Слишком маленькое изображение');
			return false;
		} else {
			return true;
		}
	}
	

}
