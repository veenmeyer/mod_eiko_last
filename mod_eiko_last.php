<?php
/**
 * @version     1.0.0
 * @package     mod_eiko_last
 * @copyright   Copyright (C) 2013 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <webmaster@feuerwehr-veenhusen.de> - http://einsatzkomponente.de
 */
defined('_JEXEC') or die;
//print_r ($params);
//if ($params->def('prepare_content', 1))
//{
//	JPluginHelper::importPlugin('content');
//	$module->content = JHtml::_('content.prepare', $module->content, '', 'mod_eiko_last.content');
//}
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_eiko_last', $params->get('layout', 'default'));

