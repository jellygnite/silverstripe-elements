<div class="slide-holder">
	<div class="uk-slidenav-position" data-uk-slideshow>
		<ul class="uk-slideshow-items">
		<% loop $SlidesList %>
			<li class="slide<% if $Image.IsDark %> invert<% end_if %> $PanelPosition.LowerCase<% if $LinkURL || $Title || $SubTitle %> hasoverlay<% end_if %>">
				 <div class="slide-img"><picture>
  <source srcset="$Image.FillMax(1920,640).URL" media="(min-width: 1440px)" />
  <source srcset="$Image.FillMax(1440,640).URL" media="(min-width: 960px)" />
  <source srcset="$Image.FillMax(960,640).URL" media="(min-width: 768px)" />
  <img src="$Image.ScaleMaxHeight(768).FillMax(508,768).URL" alt="$Image.Title.ATT" class="uk-fluid">
</picture></div>
				<div class="overlay">
					<div class="wrapper">
					<div class="uk-container uk-container-center">
						<div class="slide-panel">
							<div class="s-title"><div class="uk-h1 m-0"><% if $LinkURL %><a href="$ElementLink.LinkURL" class="uk-link-heading">$Title</a><% else %>$Title<% end_if %></div></div>
							<div class="s-subtitle pb-3">$SubTitle</div>
							<% with $ElementLink %><% if $LinkURL %><div class="s-button"><a href="$Link" class="$LinkTypeClass btn btn-tertiary">$Title</a></div><% end_if %><% end_with %>
						</div>
					</div>
					</div>
				</div>
			</li>
		<% end_loop %>
		</ul>
		<% if $SlidesList.Count > 1 %>
		<div class="uk-slidenav-container">
			<a href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
			<a href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
		</div>
		<ul class="uk-dotnav">
		<% loop $SlidesList %>
			<li data-uk-slideshow-item="{$Pos(0)}"><a href=""></a></li>
		<% end_loop %>
		</ul>
		<% end_if %>
	</div>
</div>