<?php
/**
 * validation.class.php
 * @author Ed Lomonaco <maggot05@gmail.com>
 * @copyright  (c) 2006-2011
 * @license https://opensource.org/license/mit
 * @version 9/14/2011
*/

class validation{

	/**
	 * Validate Emails by RegEx and by MX Checking.
	 * @param string $str email to validate.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function validateEmail($str){

		#Level 1 - see if anything is there.
		if (!empty($str)){
		    #Level 2 - see if it meets the correct format(name@domain)
			if(preg_match("(\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,3})",$str)){
			    #Level 3 - see if the MX record is valid.
	            if(checkdnsrr(array_pop(explode("@",$str)),"MX")){
					return (true);
				}else{
					return (false);
				}#END L3.
			}else{
				return (false);
			}#END L2.
		}else{
			return (false);
		}#END L1.
	}#END FUNCT.

	/**
	 * Validate string is a number.
	 * @param string $str string to validate.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function validateNumeric($str){

		#Level 1 - see if anything is there.
		if(!empty($str)){
		    #Level 2 - See if the variable is a number.
			if(is_numeric($str)){
			    return (true);
			}else{
			    return (false);
			}#END L2.
		}else{
			return (false);
		}#END L1.
	}#END FUNCT.

	/**
	 * Validate string contains only alpha characters.
	 * @param string $str string to validate.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function validateAlpha($str){

		#Level 1 - check for empty string.
		if(!empty($str)){
			#Level 2 - perform a Regex check to determine the string is all alpha.
			if(preg_match("/^[a-zA-Z]+$/", $str)){
				return (true);
			}else{
			    return (false);
			}#END L2.
		}else{
		    return(false);
		}#END L1.
	}#END FUNCT.

	/**
	 * Validate string contains only alpha and numeric characters.
	 * @param string $str string to validate.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function validateAlphaNumeric($str){

		#Level 1 - check for empty string.
		if(!empty($str)){
		    #Level 2 - perform a Regex check to determine the string is either alpha or numeric.
			if(preg_match("/^[a-zA-Z0-9]+$/", $str)){
			    return(true);
			}else{
			    return(false);
			}#END L2.
		}else{
			return(false);
		}#END L1.
	}#END FUNCT.
}//END CLASS
?>
