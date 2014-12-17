<?php
/**
 * Description of clases
 * Class to work with folders into a directory given
 * @author Alejandro Diego
 */
class directories{
	
	public $directory;
	public $names=array();
	
	function __construct($directory){
		$this->directory=$directory;
	}
	function getDirectory(){
		return $this->directory;
	}
	function getNames(){
		return $this->names;
	}
	
	/**
	 * Returns the size of the directory given in $directory in megabytes
	 * @return number
	 */
	function directorySize(){
		$size = 0;
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory)) as $file){
			$size+=$file->getSize();
		}
		// convert the size from bytes to megas
		$size=$size/(1024*1024);
		return round($size , 2);
	}
	
	/**
	 * Inserts the folder names in the $directory into an array $names and returns true if successful
	 */
	function directoryNames($dirName){    
        if (is_dir($dirName)){
            if($handler= opendir($dirName)){
                while (($name= readdir($handler))!== FALSE){                    
                    if(is_dir($dirName.$name) and ($name!='.') and ($name!='..')){                    	
                        array_push($this->names, $dirName.$name);                        
                        $this->directoryNames($dirName.$name."/");
                    }
                }
            }
            closedir($handler);
        }
    }
    
    /**
     * Returns the day of the last modification
     * @return string
     */
    function lastModif(){
    	$mod_time = stat($this->directory);
    	return date('Y-m-d',$mod_time['mtime']);
    }
    
    /**
     * Creates a folder into the directory $directory
     * @param unknown $direcName
     */
    function directoryCreate($direcName){
    	mkdir($this->directory."/".$direcName, 0700);
    }
    
    /**
     * Deletes a folder into the directory $directory
     * @param unknown $direcName
     */
    function directoryDelete($direcName){
    	if(is_dir($this->directory."/".$direcName)){
    		rmdir($this->directory."/".$direcName);
    	}
    }
	
}
