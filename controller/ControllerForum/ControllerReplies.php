<?php

class ControllerReplies
{
    public static function getReplies($threadTopic)
    {

        if(!file_exists(FORUM_PATH))
        {
            echo "Could not open xml file";
            return;
        }

        $xmlReader = simplexml_load_file("".FORUM_PATH) or die ("Error cannot create object");
        $threadReplies = array();
        $match = $xmlReader->xpath("//topic");

        foreach($match as $topic)
        {
            if((string)$topic == $threadTopic)
            {
                $thread = $topic->xpath('ancestor::thread')[0];
                foreach($thread->messages->message as $message)
                {
                    $tmp = array();
                    foreach($message->replies->reply as $reply)
                    {
                        array_push($tmp, [$reply->author, $reply->content]);
                    }
                    array_push($threadReplies, $tmp);
                }
            }
        }

        return $threadReplies;
    }
}