<% if $Title && $ShowTitle %><h2 class="element__title text-primary">$Title</h2><% end_if %>
<% if $Content %><div class="element__content uk-h6 text-tertiary my-0">$Content</div><% end_if %>
<% if $PersonList %>
    <% include Jellygnite/Elements/PersonList %>
<% end_if %>