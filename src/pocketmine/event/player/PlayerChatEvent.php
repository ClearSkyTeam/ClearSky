<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;
use pocketmine\Server;

/**
 * Called when a player chats something
 */
class PlayerChatEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $message;

	/** @var string */
	protected $format;

	/**
	 * @var Player[]
	 */
	protected $recipients = [];

	public function __construct(Player $player, $message, $format = "chat.type.text", array $recipients = null){
		$this->player = $player;
		$this->message = $message;

		$this->format = $format;

		if($recipients === null){
			$this->recipients = Server::getInstance()->getPluginManager()->getPermissionSubscriptions(Server::BROADCAST_CHANNEL_USERS);
		}else{
			$this->recipients = $recipients;
		}
	}

	public function getMessage(){
		return $this->message;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	/**
	 * Changes the player that is sending the message
	 *
	 * @param Player $player
	 */
	public function setPlayer(Player $player){
		$this->player = $player;
	}

	public function getFormat(){
		return $this->format;
	}

	public function setFormat($format){
		$this->format = $format;
	}

	public function getRecipients(){
		return $this->recipients;
	}

	public function setRecipients(array $recipients){
		$this->recipients = $recipients;
	}
}