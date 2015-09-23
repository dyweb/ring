<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-23
 * Time: 下午4:32
 */

define('IMAGE_DIR', __DIR__ . '/' . 'images/');
define('RESULT_DIR', __DIR__ . '/' . 'results/');

class TestFiles
{
    protected static $files = null;


    public static function init()
    {
        if (is_null(static::$files)) {
            static::$files = array(
                'image' => array(
                    'normal.jpg',
                    'normal.png',
                    'normal.gif'
                ),
                'notExist' => array(
                    'notExist'
                ),
                'notImage' => array(
                    'notImage.bin'
                ),
                'notOpenImage' => array(
                    'notOpenImage'
                ),
                'unsupportedImage' => array(

                ),
                'notReadable' => array(
                    'notReadable'
                )
            );
        }
    }


    public static function get()
    {
        if (is_null(static::$files)) {
            static::$files = array(
                'normal.jpg',
                'normal.png',
                'normal.gif',
                'notExist',
                'notImage.bin',
                'notOpenImage',
//                'unsupportedImage.xbm',
                'notReadable'
            );

            foreach (static::$files as &$file) {
                $file = IMAGE_DIR . $file;
            }
        }

        return static::$files;
    }




}
