[[if $page->template]]
	[[foreach from=$page->template->get_page_blocks() key='name' item='block' name='foo']]
		[[assign var=block_obj value=$page->get_content_block($name, true)]]
		[[if $block_obj]]
			<h3>[[$name]]</h3>
			<label>Content Type:</label> [[select class='content_type_picker' html_id="block_select_`$smarty.foreach.foo.index`" name="block_type[$name]"]][[content_type_dropdown_options selected=$block_obj.type]][[/select]]<br />
			<div id="block_[[$smarty.foreach.foo.index]]">
				[[$block_obj->get_edit_form($name)]]
			</div>
		[[/if]]
	[[/foreach]]
[[/if]]
