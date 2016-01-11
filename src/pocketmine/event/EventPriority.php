<?php
namespace pocketmine\event;


/**
 * List of event priorities
 *
 * Events will be called in this order:
 * LOWEST -> LOW -> NORMAL -> HIGH -> HIGHEST -> MONITOR
 *
 * MONITOR events should not change the event outcome or contents
 */
abstract class EventPriority{
	/**
	 * Event call is of very low importance and should be ran first, to allow
	 * other plugins to further customise the outcome
	 */
	const LOWEST = 5;
	/**
	 * Event call is of low importance
	 */
	const LOW = 4;
	/**
	 * Event call is neither important or unimportant, and may be ran normally
	 */
	const NORMAL = 3;
	/**
	 * Event call is of high importance
	 */
	const HIGH = 2;
	/**
	 * Event call is critical and must have the final say in what happens
	 * to the event
	 */
	const HIGHEST = 1;
	/**
	 * Event is listened to purely for monitoring the outcome of an event.
	 *
	 * No modifications to the event should be made under this priority
	 */
	const MONITOR = 0;

}