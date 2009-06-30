<?php
/*========================================================================
*   Open eClass 2.1
*   E-learning and Course Management System
* ========================================================================
*  Copyright(c) 2003-2008  Greek Universities Network - GUnet
*  A full copyright notice can be read in "/info/copyright.txt".
*
*  Developers Group:	Costas Tsibanis <k.tsibanis@noc.uoa.gr>
*			Yannis Exidaridis <jexi@noc.uoa.gr>
*			Alexandros Diamantidis <adia@noc.uoa.gr>
*			Tilemachos Raptis <traptis@noc.uoa.gr>
*
*  For a full list of contributors, see "credits.txt".
*
*  Open eClass is an open platform distributed in the hope that it will
*  be useful (without any warranty), under the terms of the GNU (General
*  Public License) as published by the Free Software Foundation.
*  The full license can be read in "/info/license/license_gpl.txt".
*
*  Contact address: 	GUnet Asynchronous eLearning Group,
*  			Network Operations Center, University of Athens,
*  			Panepistimiopolis Ilissia, 15784, Athens, Greece
*  			eMail: info@openeclass.org
* =========================================================================*/
/*
===========================================================================
    usage/usage.php
 * @version $Id$
    @last update: 2006-12-27 by Evelthon Prodromou <eprodromou@upnet.gr>
    @authors list: Vangelis Haniotakis haniotak@ucnet.uoc.gr
==============================================================================
    @Description: Main script for the usage statistics module


    @todo: Nothing much; most functionality is already in form.php and results.php
==============================================================================
*/

$require_current_course = TRUE;
$require_help = true;
$helpTopic = 'Usage';
$require_login = true;
$require_prof = true;
include '../../include/baseTheme.php';

$tool_content = '';
$tool_content .= "
<div id=\"operations_container\">
  <ul id=\"opslist\">";
$tool_content .= "\n    <li><a href='favourite.php?first='>".$langFavourite."</a></li>";
$tool_content .= "\n    <li><a href='userlogins.php?first='>".$langUserLogins."</a></li>";
$tool_content .= "\n  </ul>\n</div>";

$dateNow = date("d-m-Y / H:i:s",time());
$nameTools = $langUsage;
$local_style = '
    .month { font-weight : bold; color: #FFFFFF; background-color: #edecdf; padding-left: 15px; padding-right : 15px; }
    .content {position: relative; left: 25px; }';

include('../../include/jscalendar/calendar.php');
if ($language == 'greek') {
    $lang = 'el';
} else {
    $lang = 'en';
}

$jscalendar = new DHTML_Calendar($urlServer.'include/jscalendar/', $lang, 'calendar-blue2', false);
$local_head = $jscalendar->get_load_files_code();
if (isset($_POST['u_analyze']) && isset($_POST['user_id']) && $_POST['user_id'] != -1) {
    require_once "analyze.php";
} else {
    if (!extension_loaded('gd')) {
        $tool_content .= "<p>$langGDRequired</p>";
    } else {
        $made_chart = true;
        ob_start();
        require_once "results.php";
        require_once "form.php";
    }
}

draw($tool_content, 2, 'usage', $local_head, '');

?>
