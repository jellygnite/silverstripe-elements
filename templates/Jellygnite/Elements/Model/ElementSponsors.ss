<div class="uk-container uk-container-center">
	<div class="content">
		<% if $Title && $ShowTitle %><h2 class="element__title uk-text-center">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content uk-text-center">$Content</div><% end_if %>
	</div>
	<% if $SponsorList %>
		<% if $isCarousel %>
		<div data-uk-slider="{center: false,infinite: true,autoplay:true,autoplayInterval:2000,pauseOnHover:true}">
			<div class="uk-slider-container">
				<div class="uk-slider uk-slider-slow uk-grid uk-grid-xlarge uk-flex-middle uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-6@m mt-5" data-uk-grid>
					<% include Jellygnite/Elements/SponsorsGrid %>
				</div>
			</div>
		</div>
		<% else %>
			<div class="uk-grid uk-grid-xlarge uk-flex-middle uk-flex-center uk-child-width-1-2 uk-grid-width-1-3@s uk-child-width-1-4@m mt-5" data-uk-grid>
				<% include Jellygnite/Elements/SponsorsGrid %>
			</div>
		<% end_if %>
		
	<% end_if %>
</div>