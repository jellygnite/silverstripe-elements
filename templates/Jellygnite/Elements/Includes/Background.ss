<% if $BackgroundImageID || $BackgroundVideoID %>  
<div class="background-holder uk-cover-container">
	<% if $BackgroundVideoID %>
		<video<% if $BackgroundImageID %> poster="$BackgroundImage.FitMax(1920,1080).URL"<% end_if %> playsinline="" autoplay="" muted="" loop="" data-uk-cover>
			<source src="$BackgroundVideo.URL" type="video/mp4">
		</video>
	<% else %>
		<img srcset="$BackgroundImage.ScaleMaxHeight(768).ScaleMaxWidth(508,768).URL 480w,  
					$BackgroundImage.ScaleMaxWidth(768).URL 768w,
					$BackgroundImage.ScaleMaxWidth(960).URL 960w,
					$BackgroundImage.ScaleMaxWidth(1440).URL 1440w,
					$BackgroundImage.ScaleMaxWidth(1920).URL 1920w"
			 sizes="100vw"
			src="$BackgroundImage.ScaleMaxWidth(1920).URL" alt="" data-uk-cover>
	<% end_if %>
</div>
<% end_if %>