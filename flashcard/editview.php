<?php

    /** 
    * This view provides a way for editing questions
    * 
    * @package mod-flashcard
    * @category mod
    * @author Gustav Delius
    * @contributors Valery Fremaux
    * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
    */

    if (!defined('MOODLE_INTERNAL')){
        die('Direct access to this script is forbidden.'); /// It must be included from a Moodle page.
    }

    if ($action != ''){
        $result = include $CFG->dirroot.'/mod/flashcard/editview.controller.php';
        if ($result == -1){ // traps forms
            print_footer($course);
        }
    }
    
    $cards = get_records('flashcard_deckdata', 'flashcardid', $flashcard->id, 'id');
    
    $strquestionnum = get_string('num', 'flashcard');
    $strquestion = get_string('question', 'flashcard');
    $stranswer = get_string('answer', 'flashcard');
    $strcommands = get_string('commands', 'flashcard');
    $table->head = array('', "<b>$strquestionnum</b>", "<b>$strquestion</b>", "<b>$stranswer</b>", "<b>$strcommands</b>");
    $table->size = array('1%', '10%', '40%', '40%', '9%');
    $table->width = '100%';
    $i = 1;
    if ($cards){
        $strselect = get_string('choose');
        foreach($cards as $card){
            $checkbox = "<input type=\"checkbox\" name=\"items[]\" value=\"{$card->id}\" />";
            $text = htmlentities($card->questiontext, ENT_NOQUOTES, 'utf-8');
            if ($flashcard->questionsmediatype == FLASHCARD_MEDIA_IMAGE){
                $questioninput = "<input type=\"text\" name=\"q{$card->id}\" value=\"{$text}\" style=\"width: 300px\" />";
                $questioninput .= "<br/>";
                $questioninput .= flashcard_print_image($flashcard, $card->questiontext, true);
                $questioninput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.q{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            } elseif ($flashcard->questionsmediatype == FLASHCARD_MEDIA_SOUND){
                $questioninput = "<input type=\"text\" name=\"q{$card->id}\" value=\"{$text}\" style=\"width: 300px\" />";
                $questioninput .= "<br/>";
                $questioninput .= flashcard_play_sound($flashcard, $card->questiontext, 'false', true);
                $questioninput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.q{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            } elseif ($flashcard->questionsmediatype == FLASHCARD_MEDIA_IMAGE_AND_SOUND){
                list($image, $sound) = split('@', $text);
                $questioninput = "<input type=\"text\" name=\"i{$card->id}\" value=\"{$image}\" style=\"width: 300px\" />";
                $questioninput .= "<br/>";
                $questioninput .= flashcard_print_image($flashcard, $image, true);
                $questioninput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.i{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
                $questioninput .= "<br/><input type=\"text\" name=\"s{$card->id}\" value=\"{$sound}\" style=\"width: 300px\" />";
                $questioninput .= "<br/>";
                $questioninput .= flashcard_play_sound($flashcard, $sound, 'false', true);
                $questioninput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.s{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            } else {
                $questioninput = "<textarea name=\"q{$card->id}\" style=\"width: 100%\" rows=\"3\">{$text}</textarea>";
            }
            if ($flashcard->questionsmediatype != FLASHCARD_MEDIA_TEXT){
                $questioninput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.q{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            }
            $text = htmlentities($card->answertext, ENT_NOQUOTES, 'utf-8');
            if ($flashcard->answersmediatype == FLASHCARD_MEDIA_IMAGE){
                $answerinput = "<input type=\"text\" name=\"a{$card->id}\" value=\"{$text}\" style=\"width: 300px\" />";
                $answerinput .= "<br/>";
                $answerinput .= flashcard_print_image($flashcard, $card->answertext, true);
                $answerinput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.a{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            } elseif ($flashcard->answersmediatype == FLASHCARD_MEDIA_SOUND){
                $answerinput = "<input type=\"text\" name=\"a{$card->id}\" value=\"{$text}\" style=\"width: 300px\" />";
                $answerinput .= "<br/>";
                $answerinput .= flashcard_play_sound($flashcard, $card->answertext, 'false', true);
                $answerinput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.a{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
            } elseif ($flashcard->answersmediatype == FLASHCARD_MEDIA_IMAGE_AND_SOUND){
                if (empty($card->answertext)) $card->answertext = '@';
                list($image, $sound) = split('@', $text);
                $answerinput = "<input type=\"text\" name=\"i{$card->id}\" value=\"{$image}\" style=\"width: 300px\" />";
                $answerinput .= "<br/>";
                $answerinput .= flashcard_print_image($flashcard, $image, true);
                $answerinput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.i{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
                $answerinput .= "<br/><input type=\"text\" name=\"s{$card->id}\" value=\"{$sound}\" style=\"width: 300px\" />";
                $answerinput .= "<br/>";
                $answerinput .= flashcard_play_sound($flashcard, $sound, 'false', true);
                $answerinput .= "&nbsp;<input type=\"button\" value=\"{$strselect}\" onClick=\"window.open('{$CFG->wwwroot}/files/index.php?id={$COURSE->id}&amp;choose=editcard.s{$card->id}&amp;wdir=/moddata/flashcard/{$flashcard->id}', '_blank', 'width=750,height=480,status=no,toolbar=no,menubar=no,scrollbars=yes,resizable=1')\" />";
                
            } else {
                $answerinput = "<textarea name=\"a{$card->id}\" style=\"width: 100%\" rows=\"3\">{$text}</textarea>";
            }
            $commands = "<a href=\"view.php?id={$cm->id}&amp;what=delete&amp;items={$card->id}&amp;view=edit\"><img src=\"{$CFG->pixpath}/t/delete.gif\" /></a>";
            $table->data[] = array($checkbox, $i, $questioninput, $answerinput, $commands);
            $i++;
        }
    }
?>
<center>
<div style="width: 90%">
<form name="editcard" method="POST" action="view.php">
<input type="hidden" name="what" value="save" />
<input type="hidden" name="id" value="<?php p($cm->id) ?>" />
<input type="hidden" name="view" value="edit" />
<?php    
if (!empty($cards)){
    print_table($table);
?>
</center>
<p><a href="Javascript:document.forms['editcard'].what.value = 'delete' ; document.forms['editcard'].submit()"><?php print_string('deleteselection', 'flashcard') ?></a></p>
<?php
} else {
    print_simple_box(get_string('nocards', 'flashcard'));
}
?>
</div>
</form>

<center>
<form name="adddata" method="GET" action="view.php">
<input type="hidden" name="what" value="add" />
<input type="hidden" name="id" value="<?php p($cm->id) ?>" />
<input type="hidden" name="view" value="edit" />
<input type="hidden" name="add" value="" />
<!-- not in this form, but for display it is better here -->
<?php
if (!empty($cards)){
?>
<input type="button" name="add_btn" value="<?php print_string('update') ?>" onclick="document.forms['editcard'].submit()" />
<?php
}
?>
<input type="button" name="add_btn" value="<?php print_string('addone', 'flashcard') ?>" onclick="document.forms['adddata'].add.value = 1 ; document.forms['adddata'].submit()" />&nbsp;
<input type="button" name="add_btn" value="<?php print_string('addthree', 'flashcard') ?>" onclick="document.forms['adddata'].add.value = 3 ; document.forms['adddata'].submit()" />&nbsp;
<input type="button" name="add_btn" value="<?php print_string('import', 'flashcard') ?>" onclick="document.forms['adddata'].what.value = 'import' ; document.forms['adddata'].submit()" />
</form>
</center>