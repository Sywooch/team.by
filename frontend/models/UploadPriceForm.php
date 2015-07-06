<?php
namespace common\models;
namespace frontend\models;

use Yii;
use yii\base\Model;

use yii\web\UploadedFile;

use frontend\helpers\DFileHelper;



/**
 * RegStep1 form
 */
class UploadPriceForm extends Model
{
	public $imageFiles;
	public $filename;
	public $path;
	
    //public $awards = [];
    //public $examples = [];



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[
				['imageFiles'], 
				'file', 
				'skipOnEmpty' => false, 
				'extensions' => 'xls, xlsx, csv', 
				'maxFiles' => 2,	//почему-то если поставить 1 то не видит загруженного файла
				'maxSize' => (10 * 1024 * 1024),
				'wrongExtension' => 'Файл имеет неверный формат',
				'tooBig' => 'Максимальный размер файла 10МБ',
			],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'' => '',
        ];
    }
	
    public function upload()
    {
        if ($this->validate()) {
			$this->path = Yii::getAlias('@frontend').'/web/tmp';
            foreach ($this->imageFiles as $file) {
				$this->filename = DFileHelper::getRandomFileName($this->path, $file->extension) . '.' . $file->extension;
                $file->saveAs($this->path. '/' . $this->filename);
            }
            return true;
        } else {
            return false;
        }
    }
}
