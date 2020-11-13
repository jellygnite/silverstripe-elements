<div class="section-items section-downloads uk-divider-h">
	<div class="content">
		<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
		<% if $Content %><div class="element__content content">$Content</div><% end_if %>
	</div>
<% if $Files %>
    <% loop $Files %>
		<% if $File %><div class="item my-4">
			<div class="uk-grid uk-grid-medium" data-uk-grid-margin>
				<div class="uk-width-2-10 uk-width-large-1-10">
					<div class="item-image"><i class="uk-icon-file-o uk-icon-file-{$File.Extension}-o uk-icon-xlarge"></i></div>
				</div>
				<div class="uk-width-8-10 uk-width-large-6-10 content">
					<div class="item-heading">$Title</div>
					<% if $Description %><div class="item-description<% if $DescriptionLength > 20 %> collapsible<% end_if %>">$DescriptionForTemplate</div><% end_if %>
				</div>
				<div class="uk-width-1-1 uk-width-large-3-10">
					<% if $File.canView %>
					<a href="$File.URL" class="btn btn-secondary btn-small uk-width-1-1" title="Download $Title.ATT"><span>Download ($File.Size)</span></a>
					<% else %>
					<a href="Security/login?BackURL={$Up.Link}" class="btn btn-secondary btn-small uk-width-1-1" title="Download $Title.ATT"><span>Log in to view</span></a>
					<% end_if %>
				</div>
			</div>
		</div><% end_if %>
    <% end_loop %>
<% end_if %>
</div>
