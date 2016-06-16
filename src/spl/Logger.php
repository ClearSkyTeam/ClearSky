<?php
interface Logger{

    /**
     * System is unusable
     *
     * @param string $message
     */
    public function emergency($message);

    /**
     * Action must me taken immediately
     *
     * @param string $message
     */
    public function alert($message);

    /**
     * Critical conditions
     *
     * @param string $message
     */
    public function critical($message);

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     */
    public function error($message);

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     */
    public function warning($message);

    /**
     * Normal but significant events.
     *
     * @param string $message
     */
    public function notice($message);

    /**
     * Inersting events.
     *
     * @param string $message
     */
    public function info($message);

    /**
     * Detailed debug information.
     *
     * @param string $message
     */
    public function debug($message);

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     */
    public function log($level, $message);
}