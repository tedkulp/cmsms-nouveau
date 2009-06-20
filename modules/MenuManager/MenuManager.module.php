<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
#CMS - CMS Made Simple
#(c)2004-2009 by Ted Kulp (ted@cmsmadesimple.org)
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
#
#$Id$

class MenuManager extends CmsModuleBase
{
	function __construct()
	{
		parent::__construct();
	}
	
	function setup()
	{
		$this->register_module_plugin('menu_children', 'menu_children_plugin_callback');
	}
	
	public function menu_children_plugin_callback($params, &$smarty)
	{
		$orig_params = $smarty->get_template_vars('orig_params');
		$params = array_merge($orig_params, $params);
		
		if (!isset($params['node']))
		{
			return;
		}

		if ($params['node']->has_children())
		{
			$this->current_depth++;
			
			//Handle number_of_levels param
			if (!isset($params['number_of_levels']) || $params['number_of_levels'] > $this->current_depth)
			{
				//Handle collapse param
				if (!isset($params['collapse']) || $params['collapse'] != true || starts_with(cmsms()->variables['position'] . '.', $params['node']->hierarchy . '.'))
				{
					$this->display_menu($params['node']->get_children(), $params, false);
				}
			}
			
			$this->current_depth--;
		}
	}
	
	public function display_menu(&$nodes, $params, $first_call = true)
	{
		$usefile = true;
		//$lang = CmsMultiLanguage::get_client_language();
		$lang = 'en_US';
		$mdid = md5('12345'); //md5(cmsms()->variables['content_id'].implode('|', $params).$lang);
		$tpl_name = coalesce_key($params, 'template', '');

		if (!ends_with($tpl_name, '.tpl'))
		{
			$usefile = false;
		}

		if (is_array($nodes))
		{
			$count = 0;
			
			foreach ($nodes as &$node)
			{
				$this->add_fields_to_node($node);
				$node->show = $this->should_show_node($node, $params);

				//Numeric Stuff
				$node->first = ($count == 0);
				$node->last = ($count + 1 == count($nodes));
				$node->index = $count;

				$count++;
			}
			
			$smarty = smarty();
			$smarty->assign('count', count($nodes));
			$smarty->assign_by_ref('nodelist', $nodes);

			if ($first_call)
			{
				$smarty->assign('orig_params', $params);
				$this->current_depth = 1;
			}

			//echo $this->process_template_from_database($id, $return_id, 'menu_template', $tpl_name);
			echo $this->process_template_from_data($this->get_default_template());
		}
	}
	
	public function add_fields_to_node(&$node)
	{
		$node->url = $node->get_url(true, $lang);
		$node->menutext = $node->get_property_value('menu_text', $lang);
		$node->haschildren = $node->has_children();
		$node->target = '';
		if ($node->has_property('target'))
			$node->target = $node->get_property_value('target');
		$node->depth = $this->current_depth;
	}
	
	public function should_show_node(&$node, $params)
	{
		$include = true;
		$exclude = false;

		if (isset($params['includeprefix']))
		{
			$include = false;
			$prefixes = explode(',', $params['includeprefix']);
			foreach ($prefixes as $oneprefix)
			{
				if (starts_with(strtolower($node->alias), strtolower($oneprefix)))
				{
					$include = true;
					break;
				}
			}
		}
		
		if (isset($params['excludeprefix']))
		{
			$prefixes = explode(',', $params['excludeprefix']);
			foreach ($prefixes as $oneprefix)
			{
				if (starts_with(strtolower($node->alias), strtolower($oneprefix)))
				{
					$exclude = true;
					break;
				}
			}
		}

		$should_show = $node->active && $node->show_in_menu && ($include && !$exclude);
		
		//Override is show_all is true
		if (isset($params['show_all']) && $params['show_all'])
			$should_show = true;
		
		return $should_show;
	}

	function get_default_template()
	{
		return '[[if $count > 0]]
<ul>
	[[foreach from=$nodelist item=node]]
	[[if $node->show]]
		<li>
			<a href="[[$node->url]]">[[$node->menutext]]</a>
			[[menu_children node=$node]]
		</li>
	[[/if]]
	[[/foreach]]
</ul>
[[/if]]
';
	}

}

# vim:ts=4 sw=4 noet
?>