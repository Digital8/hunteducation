<?php 
{{License}}
/**
 * {{EntityLabel}} view block
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_{{Entity}}_View extends Mage_Core_Block_Template{
	/**
	 * get the current {{entityLabel}}
	 * @access public
	 * @return mixed ({{Namespace}}_{{Module}}_Model_{{Entity}}|null)
	 * {{qwertyuiop}}
	 */
	public function getCurrent{{Entity}}(){
		return Mage::registry('current_{{module}}_{{entity}}');
	}
} 