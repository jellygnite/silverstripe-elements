<section class="element<% if $StyleVariant %> $StyleVariant<% end_if %> $StyleByLocation('element.class')" id="$Anchor">
	<% include Jellygnite/Elements/Background %>
	$Element
</section>
<% with $Element %>
<% if $PopupList %>
	<% include Jellygnite/Elements/PopupsContent %>
<% end_if %>
<% end_with %>
