<?php
namespace common\helpers;

use Yii;

use yii\imagine\Image;

class DImageHelper
{
    public static function getImageUrl($filename, $type, $thumb = 0, $https = 0)
    {
		//echo'<pre>';print_r(Yii::getAlias($from) . '/web/' . Yii::$app->params[$type.'-path'] . '/' . $filename);echo'</pre>';//die;
		if($thumb == 1) $filename = 'thumb_' . $filename;
		if($https == 1)	{
			$from = '@pro';
			$main_url = 'proUrl';
		}	else	{
			$from = '@frontend';
			$main_url = 'homeUrl';
		}
		
		if($type != 'tmp')	{
			$path = '/' . Yii::$app->params[$type.'-path'] . '/';
		}	else	{
			$path = '/tmp/';
		}
		
		/*
		if($type != 'tmp')	{
			// создаем символическую ссылку, чтобы про протоколу https не было вопросов
			if($from == '@pro' && !file_exists(Yii::getAlias($from) . '/web/' . Yii::$app->params[$type.'-path'] . '/' . $filename) && file_exists(Yii::getAlias('@frontend') . '/web/' . Yii::$app->params[$type.'-path'] . '/' . $filename))	{
				$target = Yii::getAlias('@frontend') . '/web/' . Yii::$app->params[$type.'-path'] . '/' . $filename;
				$link = Yii::getAlias($from) . '/web/' . Yii::$app->params[$type.'-path'] . '/' . $filename;
				symlink($target, $link);
			}
			
		
		}
		*/
		/*
		$target = Yii::getAlias('@frontend') . '/web/files';
		$link = Yii::getAlias('@pro') . '/web/files';
		
				echo'<pre>';print_r($target);echo'</pre>';//die;
				echo'<pre>';print_r($link);echo'</pre>';die;
		symlink($target, $link);
		*/
		
		$url = Yii::$app->params[$main_url] . $path;
		
		//if($thumb == 1) $url .= 'thumb_';
		$url .= $filename;
		
		return $url;
	}
	
    public static function processImage($file_path, $file_name, $thumb_width, $thumb_height, $img_dimentions, $is_avatar = false)
    {
		$img_path = $file_path. '/' . $file_name;
		//echo'<pre>';print_r($img_dimentions);echo'</pre>';//die;

		
		if($is_avatar === false) {
			$delta = 180;
			$watermark_file = 'watermark.png';
		}	else	{
			$delta = 0;
			$watermark_file = 'watermark-mini.png';
		}
		
		$watermark_path = Yii::getAlias('@frontend').'/web/images/'.$watermark_file;
		$w_img_dimentions = self::getImageDimentions($watermark_path);
		//echo'<pre>';print_r($watermark_path);echo'</pre>';//die;
		//echo'<pre>';print_r($w_img_dimentions);echo'</pre>';die;
		
		$startMemory = 0;
		$startMemory = memory_get_usage();

		// Измеряемое

		//echo (memory_get_usage() - $startMemory) . ' bytes' . PHP_EOL;		
		//echo'<pre>';print_r(memory_get_usage());echo'</pre>';//die;
		
		if($is_avatar === false) {
			$img_dimentions = self::getImageDimentions($img_path);
			
			if($img_dimentions['width'] > Yii::$app->params['image-res']['width'] || $img_dimentions['height'] > Yii::$app->params['image-res']['height'])
				Image::thumbnail( $img_path, Yii::$app->params['image-res']['width'], Yii::$app->params['image-res']['height'])
					->save(Yii::getAlias($img_path), ['quality' => 100]);
			
			$img_dimentions = self::getImageDimentions($img_path);			
			
			//echo'<pre>';print_r($w_img_dimentions);echo'</pre>';die;
			Image::watermark($img_path, $watermark_path, [(($img_dimentions['width'] / 2) - ($w_img_dimentions['width'] / 2) + $delta), ($img_dimentions['height'] - $w_img_dimentions['height'] - 20)])
				->save(Yii::getAlias($img_path));

			$img_dimentions = self::getImageDimentions($img_path);

			Image::thumbnail( $img_path, $thumb_width, $thumb_height)
				->save(Yii::getAlias($file_path. '/' . 'thumb_' . $file_name), ['quality' => 90]);
			
		}	else	{
			//134 217 728
			//5837368
			
			//echo'<pre>';print_r(memory_get_usage());echo'</pre>';//die;
			
			Image::thumbnail( $img_path, $thumb_width, $thumb_height, 'inset')
				->save(Yii::getAlias($img_path), ['quality' => 100]);
			//echo'<pre>';print_r(memory_get_usage());echo'</pre>';die;
			$img_dimentions = self::getImageDimentions($img_path);
			
			
			
			
			//echo'<pre>';print_r($w_img_dimentions);echo'</pre>';die;
			Image::watermark($img_path, $watermark_path, [(($img_dimentions['width'] / 2) - ($w_img_dimentions['width'] / 2) + $delta), ($img_dimentions['height'] - $w_img_dimentions['height'] - 5)])
				->save(Yii::getAlias($img_path));
			

			
			$img_dimentions = self::getImageDimentions($img_path);

			Image::thumbnail( $img_path, $thumb_width, $thumb_height, 'inset')
				->save(Yii::getAlias($file_path. '/' . 'thumb_' . $file_name), ['quality' => 100]);
			
		}
	}
	
	public static function getImageDimentions($img_path)
	{
		$img = Image::getImagine()->open($img_path); //загружаем изображение
		$image_size = $img->getSize();	//получаем размеры изображения
		$img_w = $image_size->getWidth();
		$img_h = $image_size->getHeight();
		$img = null;
		
		return ['width'=>$image_size->getWidth(), 'height'=>$image_size->getHeight()];
	}
	
	/*
	* создает символические ссылки для картинок для личного кабинета, и правит ссылки в тексте
	*/
	public static function processImagesToHttps($text)
	{
		/*
		preg_match_all('/<img[^>]+>/i',$text, $images_arr);
		//echo'<pre>';print_r($images_arr);echo'</pre>';//die;

		//$img = array();
		foreach($images_arr[0] as $k=>$image) {
			//echo'<pre>';print_r($image);echo'</pre>';//die;
			preg_match_all('/(alt|title|src)=("[^"]*")/i', $image, $img);
			foreach($img[0] as $attr) {
				$attr = substr($attr, 0, -1);
				$find = 'src="';
				$pos = strpos($attr, $find);
				if ($pos !== false) {
					$url = substr($attr, 5);
					$url_arr = explode('/', $url);
					$filename = $url_arr[(count($url_arr)-1)];
					if(!file_exists(Yii::getAlias('@pro') . '/web/files/global/' . $filename))	{
						$target = Yii::getAlias('@frontend') . '/web/files/global/' . $filename;
						$link = Yii::getAlias('@pro') . '/web/files/global/' . $filename;
						symlink($target, $link);
					}

					$text = str_replace('src="'.Yii::$app->params['homeUrl'], 'src="'.Yii::$app->params['proUrl'], $text);
				}
			}
		}
		*/
		
		$text = str_replace('src="'.Yii::$app->params['homeUrl'], 'src="'.Yii::$app->params['proUrl'], $text);
		return $text;
	}
}

