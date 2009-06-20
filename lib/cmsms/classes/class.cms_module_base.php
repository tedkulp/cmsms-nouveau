<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
#CMS - CMS Made Simple
#(c)2004-2008 by Ted Kulp (ted@cmsmadesimple.org)
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

class CmsModuleBase extends SilkObject
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_name()
	{
		return get_class($this);
	}
	
	public function get_module_path()
	{
		if (is_subclass_of($this, 'CmsModuleBase'))
		{
			return join_path(ROOT_DIR, 'modules' , $this->get_name());
		}
		else
		{
			return dirname(__FILE__);
		}
	}
	
	public static function cms_module_plugin($params, &$smarty)
	{
		$module_name = coalesce_key($params, 'module', '');
		$action = coalesce_key($params, 'action', 'default');
		if ($module_name != '')
		{
			$module = CmsModuleLoader::get_module_class($module_name);
			if ($module)
			{
				@ob_start();
				
				$id = '1';
				
				$request = $module->create_request_instance($id, $returnid);
				$result = $request->do_action_base($action, $params);
				if ($result !== FALSE)
				{
					echo $result;
				}
				$modresult = @ob_get_contents();
				@ob_end_clean();
				
				return $modresult;
			}
		}
	}
	
	function create_request_instance($id, $return_id = '')
	{
		return new CmsModuleRequest($this, $id, $return_id);
	}
	
    /**
     * Register a plugin to smarty with the
     * name of the module.  This method should be called
     * from the module constructor, or from the setup()
     * method.
     */
	public function register_module_plugin($plugin_name = '', $method_name = 'function_plugin')
	{
		if ($plugin_name == '')
			$plugin_name = $this->get_name();

		smarty()->register_function($plugin_name, array($this, $method_name));
	}

	
	/**
	 * Given a template in a variable, this method processes it through smarty
	 * note, there is no caching involved.
	 */
	public function process_template_from_data($data)
	{
		$smarty = smarty();
		$smarty->_compile_source('temporary template', $data, $_compiled );
		@ob_start();
		$smarty->_eval('?>' . $_compiled);
		$_contents = @ob_get_contents();
		@ob_end_clean();
		return $_contents;
	}

}

# vim:ts=4 sw=4 noet
?>