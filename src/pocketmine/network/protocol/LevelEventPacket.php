<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class LevelEventPacket extends DataPacket{
	const NETWORK_ID = Info::LEVEL_EVENT_PACKET;


	const EVENT_SOUND_CLICK = 1000;
	const EVENT_SOUND_CLICK_FAIL = 1001;
	const EVENT_SOUND_SHOOT = 1002;
	const EVENT_SOUND_DOOR = 1003;
	const EVENT_SOUND_FIZZ = 1004;
	const EVENT_SOUND_TNT = 1005;
	const EVENT_SOUND_GHAST = 1007;
	const EVENT_SOUND_GHAST_SHOOT = 1008;
	const EVENT_SOUND_BLAZE_SHOOT = 1009;
	const EVENT_SOUND_DOOR_BUMP = 1010;
	const EVENT_SOUND_DOOR_CRASH = 1012;
	const EVENT_SOUND_BAT_FLY = 1015;
	const EVENT_SOUND_ZOMBIE_INFECT = 1016;
	const EVENT_SOUND_ZOMBIE_HEAL = 1017;
	const EVENT_SOUND_ENDERMAN_TELEPORT = 1018;
	
	const EVENT_SOUND_ANVIL_BREAK = 1020; //This sound is played on the anvil's final use, NOT when the block is broken.
	const EVENT_SOUND_ANVIL_USE = 1021;
	const EVENT_SOUND_ANVIL_FALL = 1022;
	
	const EVENT_SOUND_DROP_ITEM = 1030;
	const EVENT_SOUND_THROW_PROJECTILE = 1031;
	
	const EVENT_SOUND_ITEMFRAME_ADD_ITEM = 1040;
	const EVENT_SOUND_ITEMFRAME_PLACE = 1041;
	const EVENT_SOUND_PAINTING_BREAK = 1042;
	//1042 is item frame, but cannot tell exactly what.
	const EVENT_SOUND_ITEMFRAME_DROP_ITEM = 1043;
	const EVENT_SOUND_ITEMFRAME_ROTATE_ITEM = 1044;
	
	//1050 sounds a lot like skeleton walking but different. TODO: find out exactly what it is.
	const EVENT_SOUND_EXP_PICKUP = 1051;
	const EVENT_SOUND_BLOCK_PLACE = 1052;
	const EVENT_SOUND_BUTTON_CLICK = 3500;
	const EVENT_PARTICLE_SHOOT = 2000;
	const EVENT_PARTICLE_DESTROY = 2001;
	const EVENT_PARTICLE_SPLASH = 2002; //This is actually the splash potion sound with particles
	const EVENT_PARTICLE_EYE_DESPAWN = 2003;
	const EVENT_PARTICLE_SPAWN = 2004;
	const EVENT_START_RAIN = 3001;
	const EVENT_START_THUNDER = 3002;
	const EVENT_STOP_RAIN = 3003;
	const EVENT_STOP_THUNDER = 3004;
	const EVENT_SOUND_EXPLODE = 3501;
	/* 3502-3509 are splash SOUNDS with particles. Probably for cauldrons. */
	const EVENT_SOUND_SPELL = 3504;
	const EVENT_SOUND_SPLASH = 3506;
	const EVENT_SOUND_GRAY_SPLASH = 3507;//TODO: fix name
	const EVENT_SET_DATA = 4000;
	const EVENT_PLAYERS_SLEEPING = 9800;
	const EVENT_ADD_PARTICLE_MASK = 0x4000;
	
	public $evid;
	public $x;
	public $y;
	public $z;
	public $data;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putShort($this->evid);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putInt($this->data);
	}

}
