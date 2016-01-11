<?php
namespace pocketmine\permission;


class PermissionAttachmentInfo{
	/** @var Permissible */
	private $permissible;

	/** @var string */
	private $permission;

	/** @var PermissionAttachment */
	private $attachment;

	/** @var bool */
	private $value;

	/**
	 * @param Permissible          $permissible
	 * @param string               $permission
	 * @param PermissionAttachment $attachment
	 * @param bool                 $value
	 *
	 * @throws \InvalidStateException
	 */
	public function __construct(Permissible $permissible, $permission, $attachment, $value){
		if($permission === null){
			throw new \InvalidStateException("Permission may not be null");
		}

		$this->permissible = $permissible;
		$this->permission = $permission;
		$this->attachment = $attachment;
		$this->value = $value;
	}

	/**
	 * @return Permissible
	 */
	public function getPermissible(){
		return $this->permissible;
	}

	/**
	 * @return string
	 */
	public function getPermission(){
		return $this->permission;
	}

	/**
	 * @return PermissionAttachment
	 */
	public function getAttachment(){
		return $this->attachment;
	}

	/**
	 * @return bool
	 */
	public function getValue(){
		return $this->value;
	}
}