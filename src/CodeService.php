<?php

namespace WebsiteSurveyWidgetStartquestion;

class CodeService {
    public const DB_OPTION_NAME = 'startquestion_widget_code';

    public static function saveCode($value) {
        if (!CodeService::validCode($value)) return false;

        $value = htmlentities(stripslashes($value));
        if (CodeService::getCode()) {
            return update_option(CodeService::DB_OPTION_NAME, $value);
        } else {
            return add_option(CodeService::DB_OPTION_NAME, $value);
        }
    }

    public static function getCode() {
        return html_entity_decode(get_option(CodeService::DB_OPTION_NAME));
    }

    public static function validCode($value) {
        $regexp = "/[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}/";

        if (strlen($value) < 36) return false;
        if (preg_match($regexp, $value) !== 1) return false;

        return true;
    }
}