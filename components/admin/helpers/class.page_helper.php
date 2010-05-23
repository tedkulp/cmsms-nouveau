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

use \silk\display\HelperBase;

class PageHelper extends HelperBase
{
	function page_template_dropdown_options($params, $smarty)
	{
		$opt = array();
		foreach (orm('CmsTemplate')->find_all_by_active(true) as $tpl)
		{
			$opt[$tpl->id] = $tpl->name;
		}
		return forms()->create_input_options(array('items' => $opt, 'selected_value' => $params['selected']));
	}
	
	function content_type_dropdown_options($params, $smarty)
	{
		$opt = array();
		$opt['CmsHtmlContent'] = 'HTML Content';
		$opt['CmsOtherContent'] = 'Other Content';
		return forms()->create_input_options(array('items' => $opt, 'selected_value' => $params['selected']));
	}
}

# vim:ts=4 sw=4 noet
?>