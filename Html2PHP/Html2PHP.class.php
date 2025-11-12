<?php
/**
 * Html2PHP.class.php
 * @author Ed Lomonaco
 * @copyright  (c) 2006-2011
 * @license https://opensource.org/license/mit
 * @version 9/14/2011
*/

class Html2PHP{

    #declare data members


    private $output;
    private $tags = array();

	/**
	 * Open template file and prepares it for parsing.
	 * @param string $file template file to open.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function __construct($file){

		#see if template file exists.
		if (!file_exists($file)){
			die('Template file ('.$file.') was not found.');
		}else{
			#get the contents of the template file
			$contents = file_get_contents($file);

			#see if template file is empty.
			if(empty($contents)){
				die('Template file is empty.');
			}else{
				#Add template contents into output variable.
				$this->output = $contents;
			}
		}
	}

	/**
	 * cleans object for next use.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function __destruct(){

	    unset($this->output);
	    unset($this->tags);
	}

	/**
	 * Parsing function that will parse the tags used in the template engine.
	 * @param string $tags tags that will be parsed.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function parseTags($tags){

		if(count($tags)<1){
            die('No tags were found to be parsed.');
        }

		foreach($tags as $tag=>$data){
			#if data is array, traverse recursive array of tags
            if(is_array($data)){
            	$this->output = preg_replace("/\{$tag/",'', $this->output);
            }
            $this->output = str_replace('{'.$tag.'}', $data, $this->output);
        }
	}

	/**
	 * Removes a block of code from output.
	 * @param string $blockName block that will removed from the template output.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function removeBlock($blockName){

    	#search a match for the expression
    	preg_match ('#<!-- START ' . $blockName . ' -->([^*]+)<!-- END ' . $blockName . ' -->#', $this->output, $emptyBlock);

    	#replace the match with an empty string
    	$this->output = str_replace($emptyBlock, '', $this->output);
	}

	/**
	 * Look for and parse blocks.
	 * @param string $block name of block to look for.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function getBlock($block){

		preg_match ('#<!-- START '. $block . ' -->([^.]+)<!-- END '. $block . ' -->#',$this->output,$this->return);
		$code = str_replace ('<!-- START '. $block . ' -->', "", $this->return[0]);
		$code = str_replace ('<!-- END '  . $block . ' -->', "", $code);
		return $code;
	}

	/**
	 * Simple MySQL addition to getBlock that will parse simple MySQL-based blocks.
	 * @param string $blockName name of block to look for.
	 * @param string $q MySQL query to use.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function replaceBlockTags($blockName, $q) {

		while ($tags = mysql_fetch_assoc($q)) {
			$block = $this->getBlock($blockName);
			foreach ($tags as $tag => $data) {
				$block = str_replace("{" . $tag . "}", $data, $block);
			}
			$blockPage .= $block;
		}
		$this->output = str_replace($this->return[0], $blockPage, $this->output);
		unset($blockPage);
	}

	/**
	 * Output final product after final parsing.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function outputHtml(){
		return $this->output;
	}
}
?>
