<?php
interface AttachableLogger extends \Logger{

    /**
     * @param LoggerAttachment $attachment
     */
    public function addAttachment(\LoggerAttachment $attachment);

    /**
     * @param LoggerAttachment $attachment
     */
    public function removeAttachment(\LoggerAttachment $attachment);

    public function removeAttachments();

    /**
     * @return \LoggerAttachment[]
     */
    public function getAttachments();
}