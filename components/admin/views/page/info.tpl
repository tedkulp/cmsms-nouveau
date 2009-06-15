<label>Id:</label> <span id="page_id">[[$page.id]]</span><br />
<label>Page Name:</label> [[textbox name='page[page_name]' value=$page.page_name]]<br />
<label>Menu Text:</label> [[textbox name='page[menu_text]' value=$page.menu_text]]<br />
<label>Page Template:</label> [[select name='page[template_id]']][[page_template_dropdown_options selected=$page.template_id]][[/select]]<br />
<label>Active:</label> <span><a href="#">True</a></span><br />
<label>Show In Menu:</label> <span><a href="#">True</a></span><br />
<label>Path to Page:</label> /[[textbox html_id='alias' name='page[alias]' autocomplete="off" value=$page.alias]]&nbsp;&nbsp;<span id="alias_ok" style="color: green;">Ok</span><br />
<label>Unique Alias:</label> [[textbox html_id='unique_alias' name='page[unique_alias]' autocomplete="off" value=$page.unique_alias]]&nbsp;&nbsp;<span id="unique_alias_ok" style="color: green;">Ok</span><br />
