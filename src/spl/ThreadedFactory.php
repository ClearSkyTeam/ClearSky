<?php
class ThreadedFactory{
	/** @var ThreadedFactory */
	protected static $instance;
	/** @var \Threaded[] */
	protected $threadedList = [];

	protected function __construct(){
		global $threadedFactoryInstance;
		$threadedFactoryInstance = $this;
		self::$instance = $this;
	}

	/**
	 * @return ThreadedFactory
	 */
	public static function getInstance(){
		if(self::$instance === \null){
			global $threadedFactoryInstance;
			if($threadedFactoryInstance instanceof ThreadedFactory){
				self::$instance = $threadedFactoryInstance;
			}else{
				new ThreadedFactory();
			}
		}

		return self::$instance;
	}

	/**
	 * @param \Threaded $class
	 * @param ...$arguments
	 *
	 * @return \Threaded
	 */
	public static function create($class = \Threaded::class, ...$arguments){
		/** @var \Threaded $threaded */
		$threaded = new $class(...$arguments);
		self::getInstance()->threadedList[\spl_object_hash($threaded)] = $threaded;
		return $threaded;
	}
	
	public static function destroy(\Threaded $threaded){
		$instance = self::getInstance();
		if(isset($instance->threadedList[$hash = \spl_object_hash($threaded)])){
			$threaded->synchronized(function(\Threaded $t){
				$t->notify();
			}, $threaded);
			unset($instance->threadedList[$hash]);
			return \true;
		}
		return \false;
	}

	/**
	 * @return \Threaded[]
	 */
	public static function all(){
		return self::getInstance()->threadedList;
	}
}
