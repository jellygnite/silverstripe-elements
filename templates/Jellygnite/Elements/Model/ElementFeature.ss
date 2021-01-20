<div class="uk-container uk-container-center">
	<div class="uk-child-width-1-2@s uk-text-center" data-uk-grid>
		<div class="image-holder $StyleByLocation(image)">
		<img src="$Image.URL" alt="$Image.Title.ATT" />
		</div>
		<div class="content-holder p-5">
			<div class="content">
				<% if $Title && $ShowTitle %><h3 class="element__title uk-h2">$Title</h3><% end_if %>
				<% if $Content %><div class="element__content">$Content</div><% end_if %>
				<% with $ElementLink %><% if $LinkURL %><div class="mt-3"><a href="$LinkURL"{$TargetAttr} class="$Classes btn btn-secondary">$Title</a></div><% end_if %><% end_with %>
			</div>			
		</div>
	</div>
</div>