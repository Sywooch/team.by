<?php
namespace common\helpers;

class DYoutubeHelper
{
    public static function getYoutubeBlock($val)
    {
		$val = trim($val);
		if($val == '') return '';
		
		$youtube = explode('?v=', $val);
		return '<iframe width="277" height="156" src="https://www.youtube.com/embed/'.$youtube[1].'" frameborder="0" allowfullscreen></iframe>';
	}
}

