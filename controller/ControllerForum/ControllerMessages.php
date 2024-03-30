<?php

class ControllerMessages
{
    
    public static function getMessages($threadTopic)
    {
        if(!file_exists(FORUM_PATH))
        {
            echo "Could not open xml file";
            return;
        }

        $xmlReader = simplexml_load_file("".FORUM_PATH) or die ("Error cannot create object");
        $threadMessages = array();
        $match = $xmlReader->xpath("//topic");

        foreach($match as $topic)
        {
            if((string)$topic == $threadTopic)
            {
                $thread = $topic->xpath('ancestor::thread')[0];
                foreach($thread->messages->message as $message)
                {
                    array_push($threadMessages, [$message->author, $message->content]);
                }
            }
        }

        return $threadMessages;

    }
}

?>