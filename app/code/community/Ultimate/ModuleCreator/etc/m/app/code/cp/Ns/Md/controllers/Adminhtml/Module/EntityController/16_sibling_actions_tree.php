	/**
	 * get {{siblings}} action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{siblings}}Action(){
		$this->_init{{Entity}}();
		$this->loadLayout();
		$this->renderLayout();
	}
	/**
	 * get child {{siblings}}  action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{siblings}}JsonAction(){
		$this->_init{{Entity}}();
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('{{module}}/adminhtml_{{entity}}_edit_tab_{{sibling}}')
				->get{{Sibling}}ChildrenJson($this->getRequest()->getParam('{{sibling}}'))
		);
	}
