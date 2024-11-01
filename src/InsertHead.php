<?php

namespace WebsiteSurveyWidgetStartquestion;

use WebsiteSurveyWidgetStartquestion\CodeService;

class InsertHead {
    public function init() {
        add_action('wp_head', [$this, 'renderCode']);
    }

    public function renderCode() {
        echo $this->getCode();
    }

    public function getCode() {
        $widgetCode = CodeService::getCode();

        if (!$widgetCode) return;
        if (!CodeService::validCode($widgetCode)) return;

        $widgetCode = esc_attr($widgetCode);
        return "<script type='text/javascript'>!function(e,t,n,o,a){var c=e.Startquestion=e.Startquestion||{};c.invoked?e.console&&console.warn&&console.warn(\"Startquestion snippet included twice.\"):(c.invoked=!0,c.queue=[],c.call=function(){c.queue.push(Array.prototype.slice.call(arguments))},(e=t.createElement(\"script\")).type=\"text/javascript\",e.async=!0,e.src=n,(t=t.getElementsByTagName(\"script\")[0]).parentNode.insertBefore(e,t),c.call({type:\"load\",config:{key:o,lang:a}}))}(window,document,'https://library.startquestion.com/current/startquestion.js','{$widgetCode}','en');</script>";
    }
}