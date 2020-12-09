<ul class="list-accordion" data-uk-accordion>
    <% loop $AccordionList %>
		<li class="item">
			<div class="uk-accordion-title">$Title</div>
			<div class="uk-accordion-content">
				<% if $Content %><div class="item-content">$Content</div><% end_if %>
				<% with $ElementLink %><% if $LinkURL %><div class="item-link"><a href="$LinkURL"{$TargetAttr} class="$Classes btn btn-secondary">$Title</a></div><% end_if %><% end_with %>
			</div>
		</li>
    <% end_loop %>
</ul>