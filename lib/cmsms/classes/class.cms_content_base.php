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

use \silk\orm\ActiveRecord;

class CmsContentBase extends ActiveRecord
{
	var $table = 'content';

	function __construct()
	{
		parent::__construct();
		$this->type = get_class();
	}
	
	function get_content()
	{
		return '';
	}
	
	function get_edit_form($block_name = 'default')
	{
		$file_name = underscore(get_class($this));
		$tpl_file = join_path(dirname(__FILE__), 'content_types', 'templates', 'edit.' . $file_name . '.tpl');
		if (is_file($tpl_file))
		{
			smarty()->assignByRef('obj', $this);
			smarty()->assign('block_name', $block_name);
			return smarty()->fetch($tpl_file);
		}
		return '';
	}
}

# vim:ts=4 sw=4 noet
?>