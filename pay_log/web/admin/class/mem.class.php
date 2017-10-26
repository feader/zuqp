<?php

class memClass {
	private $mem = null;
	
	public function connect($config)
	{
		if (!is_resource($this->mem)) {
			$host = $config['host'];
			$port = $config['port'];
			$mem = new Memcache;
			if(!$mem->connect($host,$port));
				throw new Exception("memcache 链接失败");	
			$this->mem = $mem;
		}
	}
	
	public function set($key,$value,$time=0){
		if(!$this->mem){
			global $memConfig;
			$this->connect($memConfig);
		}
		$this->mem->set($key,$value,0,$time);
	}
	
	public function get($key){
		if(!$this->mem){
			global $memConfig;
			$this->connect($memConfig);
		}
		return $this->mem->get($key);
	}
}
?>