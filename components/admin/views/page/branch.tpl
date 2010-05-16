{foreach from=$subpages item='page'}
<ul>
	<li id="node_{$page->id}">
		<a href="#">{$page->alias}</a>
		{if $page->has_children()}
			{render_partial template='branch.tpl' subpages=$page->get_children()}
		{/if}
	</li>
</ul>
{/foreach}