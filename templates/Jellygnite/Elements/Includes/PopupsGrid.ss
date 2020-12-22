<div class="uk-grid uk-grid-xlarge uk-flex-top uk-child-width-1-1 uk-child-width-medium-1-3 mt-5" data-uk-grid>
    <% loop $PopupList %>
        <div class="item uk-text-center<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>">
			<div class="item-image-holder mb-2<% if $ImageRollover %> hasrollover<% end_if %>" style="<% if $ImageRollover %>background: url('{$ImageRollover.FillMax(400,400).Link}') no-repeat center center; background-size: contain;<% end_if %>" data-mh="mh-image{$Up.ID}"><a href="#popup_{$ID}" data-uk-modal="{center:true}"><% if $SVGImage %><img src="$SVGImage.URL" class="img-fluid" alt="<% if $SVGImage.Title %>$SVGImage.Title.ATT<% else %>$Title.ATT<% end_if %>"><% else_if $Image %><img src="$Image.ScaleMaxWidth(640).URL" class="img-fluid" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>"><% end_if %></a></div>
			<div class="item-content-holder">
				<% if $Title && $ShowTitle %><div class="item-title mt-3"><h3 class="text-primary">$Title</h3></div><% end_if %>
				<% if $SubTitle %><div class="item-subTitle">$SubTitle</div><% end_if %>
				<% if $Content %><div class="item-content content">$Content</div><% end_if %>
			</div>
        </div>
    <% end_loop %>
</div>