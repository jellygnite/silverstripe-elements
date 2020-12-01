<ul class="uk-list uk-list-line list-person">
    <% loop $PersonList %>
		<li class="item <% if $First %>pb-4<% else %>py-4<% end_if %>">
			<div class="uk-grid uk-flex uk-flex-middle pb-4">
				<div class="title-holder uk-width-2-3 uk-width-1-3@l">
					<% if $Title && $ShowTitle %><h4 class="text-primary uk-text-bold my-0">$Title</h4><% end_if %>
					<% if $SubTitle %><h5 class="text-tertiary element__subtitle my-0">$SubTitle</h5><% end_if %>
				</div>
				<div class="image-holder uk-width-1-3 uk-width-2-3@l">
					<% if $Image %>
						<img src="$Image.FillMax(200,200).URL" class="img-fluid person__image" alt="<% if $Image.Title %>$Image.Title.ATT<% else %>$Title.ATT<% end_if %>">
					<% end_if %>
				</div>
			</div>
				<div class="card">
					<div class="card-body">
						<% if $Content %><div class="card-text">$Content</div><% end_if %>
						<% with $ElementLink %><% if $LinkURL %><p class="pt-3"><a href="$LinkURL"{$TargetAttr} class="$Classes btn btn-secondary">$Title</a></p><% end_if %><% end_with %>
					</div>
				</div>
			</li>
    <% end_loop %>
</ul>