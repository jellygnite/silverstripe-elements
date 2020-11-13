<% loop $PopupList %>
<div id="popup_{$ID}" class="popup-content uk-modal">
	<div class="uk-modal-dialog">
		<div class="uk-grid" data-uk-grid data-uk-grid-margin data-uk-grid-match>
			<div class="uk-width-1-1 uk-width-small-1-3 uk-width-medium-2-5 uk-width-large-1-2">
				<div class="popup-image-holder">$ImagePopup.FillMax(550,650)</div>
			</div>
			<div class="uk-width-1-1 uk-width-small-2-3 uk-width-medium-3-5 uk-width-large-1-2">
				<div class="popup-description-container">
					<h4 class="popup-title">$Title</h4>
					<div class="popup-subtitle">$SubTitle</div>
					<div class="popup-description uk-text-justify">$PopupContent</div>
				</div>
			</div>
		</div>
		<div class="modal-close"><a class="uk-modal-close hamburger hamburger-close"><span>Close</span></a></div>
	</div>
</div>
<% end_loop %>

