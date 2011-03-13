<?php
class EDefault extends CWidget
{
    /**
     * Tooltip options
     * 
     * @var array
     **/
    public $tooltip;

    private $options;

    private $cssFiles = array("tooltip.css");
    private $jsFiles = array("jquery.tools.min.js");
    
    private $cssPath = "css";
    private $jsPath = "js";

    private $css;
    private $js;

    private function registerScripts()
    {
        $cs = Yii::app()->clientScript;
        //Publish only one pic
        $imagesPath = dirname(__FILE__).DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
        $imageAssetPath = Yii::app()->getAssetManager()->publish($imageAssetPath);
        if($this->css===null) {
            $cssPath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->cssPath.DIRECTORY_SEPARATOR;

            $cssAssetPath = Yii::app()->getAssetManager()->publish($cssPath);
            foreach($this->cssFiles as $file)
            {
                $cs->registerCssFile($cssAssetPath.DIRECTORY_SEPARATOR.$file);
            }
        }
        if($this->js===null) {
            $jsPath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->jsPath.DIRECTORY_SEPARATOR;

            if(!$cs->isScriptRegistered('jquery')) {
                $cs->registerCoreScript('jquery');
            }
            $jsAssetPath = Yii::app()->getAssetManager()->publish($jsPath);
            foreach($this->jsFiles as $file)
            {
                $cs->registerScriptFile($jsAssetPath.DIRECTORY_SEPARATOR.$file, CClientScript::POS_BEGIN);
            }
        }
    }
    public function init()
    {    
        $this->registerScripts();
        $this->options = require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'tooltip.options.php');
        $this->initTooltip();
        parent::init();
    }
    public function run()
    {
    }
    private function initTooltip()
    {
        $initialize = array();
        if(is_array($this->tooltip)) {
            foreach($this->tooltip as $option => $value ){
                if(in_array($option, $this->options))
                    $initialize[$option] = $value;
            }
        }
        $this->init = $initialize;
    }    
}
