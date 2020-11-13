<ul class="nav nav-horizontal">
<% loop $LinksList %>
<li><a href="$LinkURL"{$TargetAttr} title="$Title.ATT" class="$Classes btn btn-secondary">$Title</a></li>
<% end_loop %>
</ul>

