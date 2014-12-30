<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

// Используемый шаблонный хук
// Для старых шаблонов нужно задать 'body_end'
$config['template_hook'] = 'layout_body_end';
//$config['template_hook'] = 'body_end';

// Значения по умолчанию для всех элементов
$config['default'] = array(
    //'basedir' => Config::Get('path.static.dir') . Config::Get('path.uploads.images'),
    'size' => 'x300',
    'place' => array(
        'position' => 3, // 1 - верхний левый; 2 - верхний правый; 3 - нижний правый; 4 - нижний левый
        'offset' => array(0, 0), // смещение - x, y
    ),
    //'css' => '', // CSS class for <img ...> element
    //'style' => '', // style attributes for <img ...> element
    //'on' => array('index', 'blog'), // где показывать
    //'off' => array('admin/*', 'settings/*', 'profile/*', 'talk/*', 'people/*'), // где НЕ показывать
    'display' => array(
        'date_from'=>'2014-12-25',
        'date_upto'=>'2015-01-25',
    ),
);

// Выводимые изображения
/*
$config['images']['img1'] = array(
    'image' => 'tree-01.png',
    'place' => array(
        'position' => 3, // 1 - верхний левый; 2 - верхний правый; 3 - нижний правый; 4 - нижний левый
    ),
);
*/
$config['images']['img2'] = array(
    'image' => 'twig-01.png',
    'size' => '200x200',
    'place' => array(
        'position' => 2, // 1 - верхний левый; 2 - верхний правый; 3 - нижний правый; 4 - нижний левый
        'offset' => array(0, 50), // смещение - x, y
    ),
);

$config['snow'] = array(
    //'display' => false, // раскомментируйте эту строку, если не нужен "снег"
    'options' => array(
        'flakeCount' => 25,        // number
        'flakeColor' => '#ffffff', // string
        'flakeIndex' => 999999,     // number
        'minSize' => 10,            // number
        'maxSize' => 16,            // number
        'minSpeed' => 2,           // number
        'maxSpeed' => 3,           // number
        'round' => true,          // bool
        'shadow' => true,         // bool
        'char' => '*',
    ),
);

// EOF