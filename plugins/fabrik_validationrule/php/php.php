<?php
/**
 * PHP Validation Rule
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.validationrule.php
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// Require the abstract plugin class
require_once COM_FABRIK_FRONTEND . '/models/validation_rule.php';

/**
 * PHP Validation Rule
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.validationrule.php
 * @since       3.0
 */

class PlgFabrik_ValidationrulePhp extends PlgFabrik_Validationrule
{

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	var $_pluginName = 'php';

	/**
	 * Classname used for formatting error messages generated by plugin
	 *
	 * @var string
	 */
	var $_className = 'notempty php';

	/**
	 * If true uses icon of same name as validation, otherwise uses png icon specified by $icon
	 *
	 *  @var bool
	 */
	protected $icon = 'notempty';

	/**
	 * Validate the elements data against the rule
	 *
	 * @param   string  $data           to check
	 * @param   object  &$elementModel  element Model
	 * @param   int     $pluginc        plugin sequence ref
	 * @param   int     $repeatCounter  repeat group counter
	 *
	 * @return  bool  true if validation passes, false if fails
	 */

	public function validate($data, &$elementModel, $pluginc, $repeatCounter)
	{
		// For multiselect elements
		if (is_array($data))
		{
			$data = implode('', $data);
		}
		$params = $this->getParams();
		$domatch = $params->get('php-match');
		$domatch = $domatch[$pluginc];
		if ($domatch)
		{
			$formModel = $elementModel->getFormModel();
			$php_code = $params->get('php-code');
			$retval = eval($php_code[$pluginc]);
			return $retval;
		}
		return true;
	}

	/**
	 * Checks if the validation should replace the submitted element data
	 * if so then the replaced data is returned otherwise original data returned
	 *
	 * @param   string  $data           original data
	 * @param   model   &$elementModel  element model
	 * @param   int     $pluginc        validation plugin counter
	 * @param   int     $repeatCounter  repeat group counter
	 *
	 * @return  string	original or replaced data
	 */

	public function replace($data, &$elementModel, $pluginc, $repeatCounter)
	{
		$params = $this->getParams();
		$domatch = $params->get('php-match');
		$domatch = $domatch[$pluginc];
		if (!$domatch)
		{
			$formModel = $elementModel->getFormModel();
			$php_code = $params->get('php-code');
			return eval($php_code[$pluginc]);
		}
		return $data;
	}
}
