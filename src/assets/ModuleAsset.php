<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace macfly\taxonomy\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@vendor/macfly/yii2-taxonomy/src/assets';
    public $css = [
        'css/jquery.dataTables.min.css',
        'css/responsive.dataTables.min.css',
        'css/multi-select.css',
        'css/jquery.scombobox.min.css',
        'css/main.css',
    ];
    public $js = [
        'js/jquery.dataTables.min.js',
        'js/dataTables.responsive.min.js',
        'js/jquery.multi-select.js',
        'js/jquery.scombobox.min.js',
        'js/main.js'
    ];
    public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
    ];
}
