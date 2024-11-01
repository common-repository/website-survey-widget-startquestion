<?php
/*
 * Plugin Name:       Website survey widget by Startquestion
 * Plugin URI:        https://www.startquestion.com/solutions/website-evaluation/
 * Description:       Try an easy-to-use professional website feedback tool. Gather feedback from the right users at the right time and context – exactly when they interact with your site.
 * Version:           1.0.0
 * Author:            Damian Lewita
 * Author URI:        https://https://www.linkedin.com/in/dami95/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

namespace WebsiteSurveyWidgetStartquestion;

use WebsiteSurveyWidgetStartquestion\AdminPage;
use WebsiteSurveyWidgetStartquestion\InsertHead;

require_once 'src/CodeService.php';
require_once 'src/AdminPage.php';
require_once 'src/InsertHead.php';

if (is_admin()) {
    $adminPage = new AdminPage();
    $adminPage->init();
} else {
    $insertHead = new InsertHead();
    $insertHead->init();
}