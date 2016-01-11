<?php
interface LoggerAttachment{

    /**
     * @param mixed  $level
     * @param string $message
     */
    public function log($level, $message);

}