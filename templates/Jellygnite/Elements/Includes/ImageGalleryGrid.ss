<div class="uk-grid uk-flex-top $StyleByLocation(grid) mt-5" data-uk-grid>
    <% loop $ImagesList %>
		<% if $Me %>
			<div class="item uk-text-center<% if $StyleVariant %> $StyleVariant<% end_if %>">
				<div class="item-image-holder" data-mh="mh-image{$Up.ID}"><% if $Me %><img src="$Me.ScaleMaxWidth(640).URL" class="img-fluid" alt="<% if $Me.Title %>$Me.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></div>
			</div>
		<% end_if %>
    <% end_loop %>
</div>

