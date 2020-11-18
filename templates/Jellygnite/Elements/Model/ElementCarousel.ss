<div class="uk-container uk-container-center">
	<div class="content">
		<% if $Title && $ShowTitle %><h2 class="element__title uk-text-center">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content uk-text-center">$Content</div><% end_if %>
	</div>
	<% if $CarouselList %>
		<div class="uk-position-relative " data-uk-slider>
			<% include Jellygnite/Elements/CarouselGrid %>
			
					
		<a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
		<a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>

		</div>
	<% end_if %>
</div>