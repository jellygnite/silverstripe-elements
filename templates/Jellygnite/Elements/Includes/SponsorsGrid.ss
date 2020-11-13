<% loop $SponsorList %>
	<div class="item uk-text-center<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>">
		<% if $ElementLinkID %>
			<a href="$ElementLink.LinkURL"{$ElementLink.TargetAttr}><% if $Image %><img src="$Image.FitMax(480,290).Pad(480,290).URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></a>
		<% else %>
			<% if $Image %><img src="$Image.URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %>
		<% end_if %>
	</div>
<% end_loop %>