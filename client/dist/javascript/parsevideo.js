(function($) {
	$.entwine('ss', function($) {
		$('#Form_ItemEditForm_VideoURL').entwine({
			onchange: function() {
				var $videoURL = $('#Form_ItemEditForm_VideoURL');
				var $videoCode = $('#Form_ItemEditForm_Code');
				var $videoProvider = $('#Form_ItemEditForm_Provider');
				var $videoImageURL = $('#Form_ItemEditForm_ImageURL');
				if($videoCode.attr('readonly') && $videoProvider.attr('readonly')){
					$('#Form_ItemEditForm_VideoURL_message').remove();
					if ($videoURL.val()) {
						try {
							var urlParserObject = urlParser.parse($videoURL.val());
							if(typeof urlParser !=="undefined"){
								var video_id = urlParserObject.id;
								var video_provider = urlParserObject.provider;
								$videoCode.val(video_id);
								$videoProvider.val(video_provider);
								var thumb_url = '';
								if(video_provider == 'vimeo') {
									$.ajax({
										type:'GET',
										url: 'http://vimeo.com/api/v2/video/' + video_id + '.json',
										dataType: 'json',
										async: false,  // so we can alter the variable thumb_url
										success: function(data){
											thumb_url = data[0].thumbnail_large;
										},
										error:function (xhr, ajaxOptions, thrownError){
											if(xhr.status==404) {
												console.log(thrownError);
											}
										}
									});
								}
								if(video_provider == 'youtube') {
									thumb_url = 'https://img.youtube.com/vi/' + video_id + '/mqdefault.jpg';
								}
								$videoImageURL.val(thumb_url);
							}
						}
						catch(err) {
							$videoURL.after('<div id="Form_ItemEditForm_VideoURL_message" class="warning">Please enter valid video URL.</div>');
							$videoCode.val('');
							$videoProvider.val('');
							$videoImageURL.val('');
							//console.log(err.message);
						}
					} else {
						$videoCode.val('');
						$videoProvider.val('');
						$videoImageURL.val('');
					}
				}
			}
		}); // end video
		
	}); // end entwine ss
})(jQuery);

