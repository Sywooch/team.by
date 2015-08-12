<?php
namespace common\helpers;


class DStringHelper
{
	// получает часть текста указанной длины. Не разбивает слова.
	public static function getIntroText($maxchar, $text)
	{
		$text_intro = '';
		if(strlen($text) > $maxchar)	{
			$words = explode(' ', $text);
			foreach ($words as $word)	{
				if (strlen($text_intro . ' ' . $word) < $maxchar)	{
					$text_intro .= ' '.$word; 
				} else	{
					$text_intro .= '';
					break;
				}
			}
			$text_intro .= '...';
		}	else	{
			$text_intro = $text;
		}
		return $text_intro;
	}
}



