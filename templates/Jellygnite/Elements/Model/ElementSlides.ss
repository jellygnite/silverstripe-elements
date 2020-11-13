<% if $SlidesList %>
    <% include SlidesList %>
	<% if $hasCustomCSSClass('hero') %>
		<div class="uk-container uk-container-center uk-position-relative">
			<div class="scroll"><a href="#$NextElement.Anchor" data-uk-smooth-scroll="{offset: 74}"><span class="uk-text-uppercase">Scroll for more</span><i class="uk-icon-angle-down" aria-hidden="true"></i></a></div>
		</div>
	<% end_if %>
<% end_if %>