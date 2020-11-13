<div class="uk-grid uk-flex-top $StyleByLocation(grid) mt-5" data-uk-grid data-uk-grid-margin>
    <% loop $MediaItemsList %>
        <div class="item uk-text-center<% if $StyleVariant %> $StyleVariant<% end_if %>">
			<% if $MediaType == 'image' %>
				<div class="item-image-holder" data-mh="mh-image{$Up.ID}"><% if $Image %><img src="$Image.ScaleMaxWidth(640).URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></div>
			<% else_if $MediaType == 'html5video' %>
				<div class="item-image-holder item-video-holder" data-mh="mh-image{$Up.ID}">
					<div class="videowrap"><video width="100%" height="100%"<% if $Image %> poster="$Image.FillMax(1920,1080).URL"<% end_if %> controls><source src="$HTML5Video.URL" type="video/mp4"></video></div>
				</div>
			<% else_if $MediaType == 'video' %>
				<div class="item-image-holder item-video-holder" data-mh="mh-image{$Up.ID}">
					<div class="videowrap">
						<div class="$Provider">
							<iframe width="100%" height="100%" src="$EmbedURL" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			<% end_if %>
			<div class="item-content-holder">
				<% if $Title && $ShowTitle %><div class="item-title mt-3"><h3>$Title</h3></div><% end_if %>
				<% if $SubTitle %><div class="item-subtitle">$SubTitle</div><% end_if %>
			</div>
        </div>
    <% end_loop %>
</div>

