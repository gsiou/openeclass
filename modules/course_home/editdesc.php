<?php

/* ========================================================================
 * Open eClass 2.4
 * E-learning and Course Management System
 * ========================================================================
 * Copyright 2003-2011  Greek Universities Network - GUnet
 * A full copyright notice can be read in "/info/copyright.txt".
 * For a full list of contributors, see "credits.txt".
 *
 * Open eClass is an open platform distributed in the hope that it will
 * be useful (without any warranty), under the terms of the GNU (General
 * Public License) as published by the Free Software Foundation.
 * The full license can be read in "/info/license/license_gpl.txt".
 *
 * Contact address: GUnet Asynchronous eLearning Group,
 *                  Network Operations Center, University of Athens,
 *                  Panepistimiopolis Ilissia, 15784, Athens, Greece
 *                  e-mail: info@openeclass.org
 * ======================================================================== */

/*
 * Edit, Course Description
 *
 */

$require_current_course = TRUE;
$require_login = true;
$require_editor = true;

require_once '../../include/baseTheme.php';
require_once 'modules/units/functions.php';

$tool_content = $head_content = "";
$pageName = $langEditCourseProgram;
$navigation[] = array('url' => 'index.php?course=' . $course_code, 'name' => $langCourseProgram);

if (isset($_POST['submit'])) {
    Database::get()->query('UPDATE course SET description = ?s WHERE id = ?d',
        purify($_POST['description']), $course_id);
    // update index
    require_once 'modules/search/indexer.class.php';
    Indexer::queueAsync(Indexer::REQUEST_STORE, Indexer::RESOURCE_COURSE, $course_id);
    header("Location: {$urlServer}courses/$course_code");
    exit;
}

$description = Database::get()->querySingle('SELECT description FROM course WHERE id = ?d', $course_id)->description;
$tool_content = action_bar(array(
        array(
            'title' => $langBack,
            'url' => $urlAppend."courses/".$course_code,
            'icon' => 'fa-reply',
            'level' => 'primary-label'
        )
    ))."
    <div class='row'>
        <div class='col-xs-12'>
            <div class='form-wrapper'>
                <form class='form-horizontal' role='form' method='post' action='editdesc.php?course=$course_code'>
                    <fieldset>
                    <div class='form-group'>
                        <label for='description' class='col-sm-2 control-label'>$langDescription:</label>
                        <div class='col-sm-10'>
                            " . rich_text_editor('description', 4, 20, $description) . "
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-10 col-sm-offset-2'>
                            <input class='btn btn-primary' type='submit' name='submit' value='$langSubmit'>
                            <a href='{$urlAppend}courses/$course_code' class='btn btn-default'>$langCancel</a>
                        </div>
                    </div>
                  </fieldset>
                </form>
    </div></div></div>";

draw($tool_content, 2, null, $head_content);
