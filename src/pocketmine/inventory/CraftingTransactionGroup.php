<?php
namespace pocketmine\inventory;

use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\item\Item;
use pocketmine\Server;

class CraftingTransactionGroup extends SimpleTransactionGroup{
	/** @var Item[] */
	protected $input = [];
	/** @var Item[] */
	protected $output = [];

	/** @var Recipe */
	protected $recipe = null;

	public function __construct(SimpleTransactionGroup $group){
		parent::__construct();
		$this->transactions = $group->getTransactions();
		$this->inventories = $group->getInventories();
		$this->source = $group->getSource();

		$this->matchItems($this->output, $this->input);
	}

	public function addTransaction(Transaction $transaction){
		parent::addTransaction($transaction);
		$this->input = [];
		$this->output = [];
		$this->matchItems($this->output, $this->input);
	}

	/**
	 * Gets the Items that have been used
	 *
	 * @return Item[]
	 */
	public function getRecipe(){
		return $this->input;
	}

	/**
	 * @return Item
	 */
	public function getResult(){
		reset($this->output);

		return current($this->output);
	}

	public function canExecute(){
		if(count($this->output) !== 1 or count($this->input) === 0){
			return false;
		}

		return $this->getMatchingRecipe() instanceof Recipe;
	}

	/**
	 * @return Recipe
	 */
	public function getMatchingRecipe(){
		if($this->recipe === null){
			$this->recipe = Server::getInstance()->getCraftingManager()->matchTransaction($this);
		}

		return $this->recipe;
	}

	public function execute(){
		if($this->hasExecuted() or !$this->canExecute()){
			return false;
		}

		Server::getInstance()->getPluginManager()->callEvent($ev = new CraftItemEvent($this, $this->getMatchingRecipe()));
		if($ev->isCancelled()){
			foreach($this->inventories as $inventory){
				$inventory->sendContents($inventory->getViewers());
			}

			return false;
		}

		foreach($this->transactions as $transaction){
			$transaction->getInventory()->setContents($transaction->getViewers()->getSlot(), $transaction->getTargetItem(), $transaction->getSourceItem());
		}
		$this->hasExecuted = true;

		return true;
	}
}
