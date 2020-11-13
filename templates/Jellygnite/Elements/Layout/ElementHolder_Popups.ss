<section class="element<% if $StyleVariant %> $StyleVariant<% end_if %>" id="$Anchor">
	$Element
</section>
<% with $Element %>
<% if $PopupList %>
	<% include Jellygnite/Elements/PopupsContent %>
<% end_if %>
<% end_with %>
