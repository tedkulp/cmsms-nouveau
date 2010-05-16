<?php
#CMS - CMS Made Simple
#(c)2004-2006 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

function smarty_function_cms_validation_errors($params, $smarty)
{
	$default_params = array(
		'for' => coalesce_key($params, 'for', null),
		'params' => coalesce_key($params, 'params', array())
	);
	
	$params = array_merge($default_params, forms()->strip_extra_params($params, $default_params, 'params'));
	unset($params['params']);
	
	if ($params['for'] != null && is_object($params['for']))
	{
		if (isset($params['for']->validation_errors) && is_array($params['for']->validation_errors) && count($params['for']->validation_errors) > 0)
		{
			echo '<div class="pagemcontainer">';
			echo '<p class="pagemessage">';
			foreach ($params['for']->validation_errors as $err)
			{
				echo '<img class="systemicon" title="Sucesso" alt="Sucesso" src="' . $smarty->getTemplateVars('layout_root_url') . '/images/icons/system/stop.gif" />'.$err.'<br />';
			}
			echo '</p>';
			echo '</div>';
		}
	}
}

?>
