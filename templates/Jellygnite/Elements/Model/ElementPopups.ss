<div class="uk-container uk-container-center">
	<% if $Content || $ShowTitle %>
	<div class="content content-holder">
		<% if $Title && $ShowTitle %><h2 class="element__title uk-text-center">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content">$Content</div><% end_if %>
	</div>
	<% end_if %>
	<% if $PopupList %>
		<% include Jellygnite/Elements/PopupsGrid %>
	<% end_if %>
</div>