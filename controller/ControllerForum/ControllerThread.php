<?php

include 'forum.inc.php';

error_reporting(E_ALL); ini_set('display_errors', 1);

class ControllerThread
{
    public static function getThreads($discipline)
    {
        if(!file_exists(FORUM_PATH))
        {
            echo "Could not open xml file";
            return;
        }

        $xmlReader = simplexml_load_file("".FORUM_PATH) or die ("Error cannot create object");
        $threadList = array();
        $match = $xmlReader->xpath("//discipline[@name='$discipline']");
            
        foreach($match as $discipline)
        {
            foreach($discipline->thread as $thread)
            {
                array_push($threadList, [$thread->topic, $thread->author]);
            }
        }

        return $threadList;

    }

    public static function loadThread($threadTopic)
    {
        echo $threadTopic;
        ob_end_clean();
        ob_start();

        // Include the thread_template
        include '../view/forum/thread_template.php';

        
        $content = ob_get_clean(); //get thread_template page data

        
        $title = $threadTopic;
        $thread_author = "TMP";
        $messagesItems = "";

        include 'ControllerMessages.php';
        include 'ControllerReplies.php';
        $threadMessages = ControllerMessages::getMessages($threadTopic);
        $messagesReplies = ControllerReplies::getReplies($threadTopic);
        
        foreach($threadMessages as $message)
        {
            $messagesItems .= "<li><p>".$message[1]." | ".$message[0]."</p></li><ul>";
            foreach($messagesReplies as $replies)
            {
                foreach($replies as $reply)
                {
                    $messagesItems .= "<li>".$reply[0]." ".$reply[1]."</li><br>";
                }
            }


            $messagesItems .= "</ul>";
        }

        

        //replace sub_template placeholders with actual values
        $content = str_replace("{THREAD_TOPIC}", $threadTopic, $content);
        $content = str_replace("{THREAD_AUTHOR}", $thread_author, $content);
        $content = str_replace("{THREAD_MESSAGES}", $messagesItems, $content);

        echo $content; //update page content
    }
}