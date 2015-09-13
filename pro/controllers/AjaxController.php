<?php

namespace pro\controllers;

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

use frontend\models\UploadPassportForm;
use frontend\models\UploadBookForm;
use frontend\models\UploadDiplomForm;
use frontend\models\UploadDocumentsOtherForm;
use frontend\models\UploadRegFileForm;
use frontend\models\UploadBitovieFileForm;
use frontend\models\UploadAttestatForm;

use common\models\Category;
use common\models\User;
use common\models\Region;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\UserDocuments;

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
				
				$img_path = $model->path. '/' . $model->filename;
				
				$img_dimentions = DImageHelper::getImageDimentions($img_path);
				
				if($this->checkImageDimentions($model, $img_dimentions) === false)
					return;
								
				DImageHelper::processImage($model->path, $model->filename, 75, 90, $img_dimentions);				

				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[awards][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(DImageHelper::getImageUrl($model->filename, 'tmp', 1, 1)), DImageHelper::getImageUrl($model->filename, 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
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
				
				$img_path = $model->path. '/' . $model->filename;
				
				$img_dimentions = DImageHelper::getImageDimentions($img_path);
				
				if($this->checkImageDimentions($model, $img_dimentions, 'min-avatar-res') === false)
					return;
								
				DImageHelper::processImage($model->path, $model->filename, 275, 280, $img_dimentions, true);

				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[avatar]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(DImageHelper::getImageUrl($model->filename, 'tmp', 1, 1), ['class'=>'img-responsive']), DImageHelper::getImageUrl($model->filename, 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox']);
				
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
		
		$document_form = Yii::$app->session->get('document_form', 'DocumentsForm2');

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $document_form.'[license]', $model->filename);
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
				
				$img_path = $model->path. '/' . $model->filename;
				
				$img_dimentions = DImageHelper::getImageDimentions($img_path);
				
				if($this->checkImageDimentions($model, $img_dimentions) === false)
					return;
								
				DImageHelper::processImage($model->path, $model->filename, 190, 130, $img_dimentions);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $profile_model.'[examples][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(DImageHelper::getImageUrl($model->filename, 'tmp', 1, 1)), DImageHelper::getImageUrl($model->filename, 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
				$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadPassportFile()
    {
        $model = new UploadPassportForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'DocumentsForm1[passport_file]', $model->filename);
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadBookFile()
    {
        $model = new UploadBookForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'DocumentsForm1[trud_file]', $model->filename);
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadDiplomFile()
    {
        $model = new UploadDiplomForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'DocumentsForm1[diplom_file]', $model->filename);
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadDocumentsOther()
    {
        $model = new UploadDocumentsOtherForm();
		
		$document_form = Yii::$app->session->get('document_form', 'DocumentsForm2');
		
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$html = UserDocuments::getLicenseLink($model->filename);
				$html .= Html::input('hidden', $document_form.'[other_file][]', $model->filename);
				$html .= Html::a('×', '#', ['class'=>'remove-document-file', 'title'=>'Удалить файл']);
				//<a href="#" class="remove-document-file" title="Удалить файл">×</a>
				$html .= '<div class="document_delete__popup popup_block"><p>Действительно удалить?</p><p><a href="#" class="document-delete-yes" data-file="other_file">Да</a> <a href="#" class="document-delete-no">Нет</a></p></div>';
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::tag('li', $html);
								
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadRegFile()
    {
        $model = new UploadRegFileForm();
		
		$document_form = Yii::$app->session->get('document_form', 'DocumentsForm2');
		
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				//$json_arr['filename'] = Html::input('hidden', $document_form.'[reg_file]', $model->filename);
				$json_arr['filename'] = $document_form.'[reg_file]';
				$json_arr['filevalue'] = $model->filename;
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadBitovieFile()
    {
        $model = new UploadBitovieFileForm();
		
		$document_form = Yii::$app->session->get('document_form', 'DocumentsForm2');
		
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $document_form.'[bitovie_file]', $model->filename);
				echo Json::htmlEncode($json_arr);
                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	
    public function actionUploadAttestatFile()
    {
        $model = new UploadAttestatForm();
		
		$document_form = Yii::$app->session->get('document_form', 'DocumentsForm2');
		
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', $document_form.'[attestat_file]', $model->filename);
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
		$children = $model->children()->all();
		
		$cats_l1[] = [
			'id'=>$model->id,
			'name'=>$model->name,
			'alias'=>$model->alias,
			'path'=>$model->path,
			'children'=>[],
		];				

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
			$orders = $client->orders;

			$users = \common\models\User::find()
					->distinct(true)
					->joinWith(['orders'])
					->where(['{{%order}}.client_id'=>$client->id])
					->all();

			$users_arr = [null => '--- Выберите ----'] + ArrayHelper::map($users, 'id', 'fio');			
		}	else	{
			$users_arr = [null => '--- Заказы не найдены ----'];
		}
		
		echo Html::dropDownList('AddReviewForm[user_id]', 0, $users_arr, ['class'=>'form-control', 'id'=>'addreviewform-user_id']);
		
		return;
	}
	/*
    public function actionUploadReviewfoto()
    {
        $model = new \frontend\models\UploadReviewFotoForm();

        if (Yii::$app->request->isPost) {
			
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			
            if ($model->upload()) {
				
				$img = Image::getImagine()->open($model->path. '/' . $model->filename); //загружаем изображение
				
				$image_size = $img->getSize();	//получаем размеры изображения
				
				if($image_size->getWidth() < 320 || $image_size->getHeight() < 240) {
					$this->printErrors($model, 'Слишком маленькое изображение');
					return;
				}
				
				//Image::thumbnail( $model->path. '/' . $model->filename, 75, 90)
				Image::thumbnail( $model->path. '/' . $model->filename, 70, 45)
					->save(Yii::getAlias($model->path. '/' . 'thumb_' . $model->filename), ['quality' => 90]);
				
				$json_arr['res'] = 'ok';
				$json_arr['filename'] = Html::input('hidden', 'AddReviewForm[foto][]', $model->filename);
				$json_arr['html_file'] = Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->filename), Url::home(true) . 'tmp/' .$model->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
				//$json_arr['html_file_remove'] = Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->filename]);
				
				echo Json::htmlEncode($json_arr);

                return;
            }	else	{
				$this->printErrors($model);
			}
        }		
		return;
    }
	*/
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
	
	
	public function actionGetregionsdropdown()
	{
		$form_name = Yii::$app->request->post('form_name', 'ProfileAnketaForm');
		$region_ids = Yii::$app->request->post('ids', []);
		$region_ids = explode(',', $region_ids);
		
		foreach($region_ids as $k=>$id)
			if($id == 0) unset($region_ids[$k]);
			
		if(count($region_ids) == '') return
		
		
		
		$selected_ids = [];
			
		$selected_ids[] = 1;
		
		foreach($region_ids as $id) {
			$selected_ids[] = $id;
			$model = Region::findOne($id);
			if($model === null) return;
			
			$children = $model->children()->all();
			foreach($children as $child) {
				$selected_ids[] = $child->id;
			}
			
		}
		
		//echo'<pre>';print_r($selected_ids);echo'</pre>';//die;
		$categories = Region::find()
			->where(['not in', 'id',  $selected_ids])
			->orderBy('lft, rgt')->all();
		
		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.' '.$c->name;
		}
		
		
		//$categories = [0=>'Выберите'] + $categories2;
		$categories = [0=>'Выберите'] + ArrayHelper::map($categories, 'id', 'name');
		$html = '';
		$html .= Html::tag('div', Html::dropDownList($form_name.'[regions][]', 0, $categories, ['class'=>'form-control']), ['class'=>'col-lg-8 region-dd-cnt']);
		$html .= Html::tag('div', Html::textInput($form_name.'[ratios][]', '', ['placeholder'=>'коэффициент', 'class'=>'form-control']), ['class'=>'col-lg-3']);
		$html .= Html::tag('div', (Html::a('—', '#', ['class'=>'remove_region_row'])), ['class'=>'col-lg-1']);
		$html = Html::tag('div', $html, ['class'=>'form-group row clearfix region-row']);
		
		echo $html;
		//echo Html::dropDownList($form_name.'[regions][]', 0, $categories, ['class'=>'form-control']);
		//echo'<pre>';print_r($categories);echo'</pre>';die;
		
/*
			<div class="form-group row clearfix region-row">
				<div class="col-lg-8 region-dd-cnt">
					<?= Html::dropDownList($form_name.'[regions][]', $model->regions[$x], $model->regionsDropDownList, ['class'=>'form-control']) ?>
				</div>
				<div class="col-lg-3">
					<?= Html::textInput($form_name.'[ratios][]', $model->ratios[$x], ['placeholder'=>'коэффициент', 'class'=>'form-control']) ?>
				</div>
				<div class="col-lg-1">
					<a href="#" class="remove_region_row">—</a>
				</div>
			</div>
*/
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
	
	
	public function checkImageDimentions(&$model, $img_dimentions, $param = 'max-image-res')
	{
		if($img_dimentions['width'] < Yii::$app->params[$param]['width'] || $img_dimentions['height'] < Yii::$app->params[$param]['height']) {
			$this->printErrors($model, 'Слишком маленькое изображение');
			return false;
		} else {
			return true;
		}
	}
	
	
	


}
