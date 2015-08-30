<?php
namespace common\helpers;

use Yii;

use yii\imagine\Image;

class DImageHelper
{
    public static function getImageUrl($filename, $type, $thumb = 0)
    {
		if($type != 'tmp') $url = Yii::$app->params['homeUrl'] . '/' . Yii::$app->params[$type.'-path'] . '/';
			else $url = Yii::$app->params['homeUrl'] . '/tmp/';
		
		if($thumb == 1) $url .= 'thumb_';
		$url .= $filename;
		return $url;
	}
	
    public static function processImage($file_path, $file_name, $thumb_width, $thumb_height, $img_dimentions)
    {
		$img_path = $file_path. '/' . $file_name;
		//echo'<pre>';print_r($img_dimentions);echo'</pre>';//die;

		$watermark_path = Yii::getAlias('@frontend').'/web/images/watermark.png';
		$w_img_dimentions = self::getImageDimentions($watermark_path);
		
		//echo'<pre>';print_r($w_img_dimentions);echo'</pre>';die;
		Image::watermark($img_path, $watermark_path, [(($img_dimentions['width'] / 2) - ($w_img_dimentions['width'] / 2) + 180), ($img_dimentions['height'] - $w_img_dimentions['height'] - 20)])
			->save(Yii::getAlias($img_path));
		
		$img_dimentions = self::getImageDimentions($img_path);

		Image::thumbnail( $img_path, $thumb_width, $thumb_height)
			->save(Yii::getAlias($file_path. '/' . 'thumb_' . $file_name), ['quality' => 90]);
	}
	
	public static function getImageDimentions($img_path)
	{
		$img = Image::getImagine()->open($img_path); //загружаем изображение
		$image_size = $img->getSize();	//получаем размеры изображения
		$img_w = $image_size->getWidth();
		$img_h = $image_size->getHeight();
		
		return ['width'=>$image_size->getWidth(), 'height'=>$image_size->getHeight()];
	}
	
}

