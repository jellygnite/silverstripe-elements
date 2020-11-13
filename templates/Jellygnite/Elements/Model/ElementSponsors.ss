<div class="uk-container uk-container-center">
	<div class="content">
		<% if $Title && $ShowTitle %><h2 class="element__title uk-text-center">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content uk-text-center">$Content</div><% end_if %>
	</div>
	<% if $SponsorList %>
		<% if $isCarousel %>
		<div data-uk-slider="{center: false,infinite: true,autoplay:true,autoplayInterval:2000,pauseOnHover:true}">
			<div class="uk-slider-container">
				<div class="uk-slider uk-slider-slow uk-grid uk-grid-xlarge uk-flex-middle uk-grid-width-1-2 uk-grid-width-small-1-3 uk-grid-width-medium-1-6 mt-5" data-uk-grid-margin>
					<% include SponsorsGrid %>
				</div>
			</div>
		</div>
		<% else %>
			<div class="uk-grid uk-grid-xlarge uk-flex-middle uk-grid-width-1-2 uk-grid-width-small-1-3 uk-grid-width-medium-1-4 mt-5" data-uk-grid-margin>
				<% include SponsorsGrid %>
			</div>
		<% end_if %>
		
	<% end_if %>
</div>