<div class="uk-slider-items uk-child-width-1-1" data-uk-grid>
<% loop $CarouselList %>
	<div class="item <% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>">
		<% if $ElementLinkID %>
			<a href="$ElementLink.LinkURL"{$ElementLink.TargetAttr}><% if $Image %><img src="$Image.FitMax(480,290).Pad(480,290).URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></a>
		<% else %>
			<% if $Image %><img src="$Image.URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %>
		<% end_if %>
		<div class="content">
			<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
			<% if $Content %><div class="element__content">$Content</div><% end_if %>
		</div>
	</div>
<% end_loop %>
</div>
