<div class="uk-container $StyleByLocation(container)">
	<div class="content">
		<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content">$Content</div><% end_if %>
	</div>
	<% if $CarouselList %>
		<div class="uk-position-relative" data-uk-slider>
			<div class="uk-slider-container">
				<% include Jellygnite/Elements/CarouselGrid %>
			</div>
			<div class="uk-slidenav-container">
				<a class="uk-position-center-left-out uk-position-large" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
				<a class="uk-position-center-right-out uk-position-large" href="#" uk-slidenav-next uk-slider-item="next"></a>
			</div>			
		</div>
	<% end_if %>
</div>