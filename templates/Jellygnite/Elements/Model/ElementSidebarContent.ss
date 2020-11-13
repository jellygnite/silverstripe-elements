<div class="uk-container uk-container-center">
	<div class="content-holder p-5">
		<div class="content">
			<% if $Title && $ShowTitle %><h3 class="element__title uk-h2">$Title</h3><% end_if %>
			<div class="uk-grid uk-grid-collapse mt-5" data-uk-grid-margin>
				<% if $Content %><div class="element__content uk-width-1-1 uk-width-medium-6-10">$Content</div><% end_if %>
				<% if $Sidebar %><div class="element__sidebar uk-width-medium-3-10 uk-push-1-10">$Sidebar</div><% end_if %>
			</div>
		</div>			
	</div>
</div>