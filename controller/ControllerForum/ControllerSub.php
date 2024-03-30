<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

class ControllerSub
{

    /*
    loadSub: fills in forum/sub_template dynamically depending on which "sub" link \
    user clicked on
    */
    public static function loadSub($subName)
    {
        
        ob_start();

        // Include the sub-template
        include '../view/forum/sub_template.php';

        
        $content = ob_get_clean(); //get sub_template page data

        
        $title = $subName;
        $threadTitle = "Threads";
        $threadItems = "";

        include 'ControllerThread.php';
        $threadList = ControllerThread::getThreads($subName);
        
        foreach($threadList as $thread)
        {
            $threadItems .= "<li><a href=\"./routeur.php?thread=".$thread[0]."\">".$thread[0]."</a> by ".$thread[1]."</li>";
        }

        //replace sub_template placeholders with actual values
        $content = str_replace("{TITLE}", $title, $content);
        $content = str_replace("{THREAD_TITLE}", $threadTitle, $content);
        $content = str_replace("{THREADS}", $threadItems, $content);

        echo $content; //update page content
    }
}