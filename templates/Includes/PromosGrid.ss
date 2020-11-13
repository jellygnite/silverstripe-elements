<div class="uk-grid uk-grid-xlarge uk-flex-top uk-grid-width-1-1 uk-grid-width-medium-1-3 mt-5" data-uk-grid-margin>
    <% loop $PromoList %>
        <div class="item uk-text-center<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>">
			<% if $ElementLinkID %>
				<div class="item-image-holder" data-mh="mh-image{$Up.ID}"><a href="$ElementLink.LinkURL"{$ElementLink.TargetAttr}><% if $SVGImage %><img src="$SVGImage.URL" class="img-fluid mb-2" alt="<% if $SVGImage.Title %>$SVGImage.Title.ATT<% else %>$Title.ATT<% end_if %>"><% else_if $Image %><img src="$Image.ScaleMaxWidth(640).URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></a></div>
			<% else %>
				<div class="item-image-holder" data-mh="mh-image{$Up.ID}"><% if $SVGImage %><img src="$SVGImage.URL" class="img-fluid mb-2" alt="<% if $SVGImage.Title %>$SVGImage.Title.ATT<% else %>$Title.ATT<% end_if %>"><% else_if $ImageID %><img src="$Image.URL" class="img-fluid mb-2" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></div>
			<% end_if %>
			<div class="item-content-holder">
				<% if $Title && $ShowTitle %><div class="item-title mt-3"><h3 class="text-primary"><% if $ElementLink.LinkURL %><a href="$ElementLink.LinkURL"{$ElementLink.TargetAttr}>$Title</a><% else %>$Title<% end_if %></h3></div><% end_if %>
				<% if $Content %><div class="item-content content">$Content</div><% end_if %>
			</div>
			<% with $ElementLink %><% if $LinkURL %><div class="pt-3"><a href="$LinkURL"{$TargetAttr} class="$Classes btn btn-secondary">$Title</a></div><% end_if %><% end_with %>
        </div>
    <% end_loop %>
</div>

