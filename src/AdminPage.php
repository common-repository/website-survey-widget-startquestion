<?php

namespace WebsiteSurveyWidgetStartquestion;

class AdminPage {
    public function init() {
        // add setting
        add_action('admin_init', [$this, 'setting']);

        // add settings page
        add_action('admin_menu', [$this, 'settingsPage']);

        // add admin CSS and JS
        add_action('admin_print_styles', [$this, 'adminCss']);
        add_action('admin_enqueue_scripts', [$this, 'adminJs']);

        // add admin notice warning
        add_action( 'admin_notices', [$this, 'noticeMissingWidgetCode'] );
    }

    public function setting() {
        register_setting('startquestion_plugin_settings', CodeService::DB_OPTION_NAME);
    }

    public function settingsPage() {
        add_options_page('Startquestion widget', 'Startquestion widget', 'manage_options', 'website-survey-widget-startquestion', [$this, 'renderOptionsPage']);
    }

    public function adminCss() {
        wp_enqueue_style('startiquestion-widget',  plugin_dir_url(__DIR__) . "admin-style.css");
    }

    public function adminJs() {
        wp_enqueue_script('startiquestion-widget',  plugin_dir_url(__DIR__) . "admin-script.js");
    }

    public function noticeMissingWidgetCode() {
        global $pagenow;

        if ($pagenow === 'options-general.php' && $_GET['page'] === 'website-survey-widget-startquestion') return;
        if (CodeService::validCode(CodeService::getCode())) return;

        $url = get_admin_url('') . 'options-general.php?page=website-survey-widget-startquestion';
        echo '
            <div class="notice notice-warning">
                <p>
                    <strong>Startquestion widget:</strong> 
                    You need to add widget code to make the plugin work. You can do it in the <a href="' . esc_attr($url) . '">settings of Startuqestion widget tab.</a></p>
            </div>
        ';
    }


    public function renderCompanyDescription() {
        echo '
            <div>
                <img src="' . plugin_dir_url(__DIR__) . 'assets/logo.svg" width="204" height="36" alt="Startquestion logo" />
               
                <p style="font-size: 20px;">
                    Startquestion is a professional survey software for creating online surveys and surveys of clients and employees. 
                    <br>A recognized tool among companies, universities and large organizations.
                </p>
                
                <h3>Our widget:</h3>
                <p>
                    <a href="https://www.startquestion.com/features/website-surveys/" target="_blank">
                        <img alt="Widget preview" width="554" height="510" src="' . plugin_dir_url(__DIR__) . 'assets/widget.png" />
                    </a>      
                </p>
                <p>
                    <a href="https://www.startquestion.com/features/website-surveys/" target="_blank">
                        Read more about Website Widget
                    </a> 
                </p>
            </div>
        ';
    }

    public function renderInstruction() {
        $current_user = wp_get_current_user();

        $registerUrl = 'https://app.startquestion.com/polecenie?id_partner=1003&redir_code=1&surveyId=789837&plan=1&email=' . urlencode( $current_user->user_email );

        echo '
            <div style="margin-top:15px; margin-bottom: 30px;font-size: 18px;line-height:1.5em;">
                <ol>
                    <li><a target="_blank" href="' . esc_attr($registerUrl) . '">Register account in Startquestion</a></li>
                    <li><a target="_blank" href="https://app.startquestion.com/user#widget-installation">Get widget code from Startquestion account\'s settings</a></li>
                    <li>Put code into field below</li>
                    <li>Configure widget in <a target="_blank" href="https://app.startquestion.com/user#widget-rules">Startquestion tool</a> and analyse results there.</li>
                </ol>
            </div>
            ';
    }

    public function renderForm() {
        $widgetCode = CodeService::getCode();
        $optionName1 = 'startquestion_html_code';
        $optionName2 = CodeService::DB_OPTION_NAME;
        $validCode = CodeService::validCode($widgetCode);

        echo '
            <form action="options.php" method="POST">
            ';

        echo settings_fields('startquestion_plugin_settings');
        echo do_settings_sections('website-survey-widget-startquestion');

        echo '
            <div>
                <h3>Configuration</h3>
            ';

        if (!$validCode) {
            self::renderInstruction();
        }

        $textareaValue = '';
        if ($validCode) {
            $insertHead = new InsertHead();
            $textareaValue = $insertHead->getCode();
        }

        echo '
                <div class="fields">
                    <label for="' . esc_attr($optionName1) . '" style="font-weight:bold;">Widget code</label>
                    <textarea type="text" name="' . esc_attr($optionName1) . '" id="' . esc_attr($optionName1) . '">' . esc_textarea($textareaValue) . '</textarea>
                    <input type="hidden" name="' . esc_attr($optionName2) . '" id="' . esc_attr($optionName2) . '" value="' . esc_attr($widgetCode) . '" />
                </div> 
            </div>
        ';

        if ($validCode) {
            echo '
                <p>
                    <small>If you want to disable displaying widget, you can empty the field above and save it.</small>
                </p>
            ';
        }

        echo submit_button('Save changes');

        echo '</form>';
    }

    public function renderOptionsPage() {
        echo '
            <div class="wrap">

            <div id="startuqestionWidgetSettings">
            ';

        self::renderCompanyDescription();
        self::renderForm();

        echo '
            </div>
        </div>
        ';
    }
}