<?php
namespace backend\helpers;


class DAliasHelper
{
    public static function setAlias(&$model)
    { 
		$search = [' ', '(', ')', '/', '*'];
		$replace = ['-', '', '', '-', ''];
		if($model->alias == '') $model->alias = str_replace($search, $replace, (strtolower(self::ToTranslit($model->name))));
		return;
    }
	
	/**
	 * Транслит
	 * @param $text
	 * @return string
	 */
	public function ToTranslit($text)
	{
		$find=array('А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё',
			'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м',
			'Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у',
			'Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш','Щ','щ','Ъ','ъ',
			'Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я', '№',' ');

		$replace=array('A','a','B','b','V','v','G','g','D','d','E','e','Yo','yo',
			'Zh','zh','Z','z','I','i','J','j','K','k','L','l','M','m',
			'N','n','O','o','P','p','R','r','S','s','T','t','U','u','F',
			'f','H','h','Ts','ts','CH','ch','Sh','sh','Sch','sch',
			'','','Y','y','','','E','e','Yu','yu','Ya','ya', '',' ');

	   return preg_replace('/[^\w\d\s_-]*/','',str_replace($find,$replace,$text));
	}
}

