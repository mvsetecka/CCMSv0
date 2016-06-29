<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "<?php echo $this->get_settings('web_url'); ?>/admin/includes/swfupload/swfupload/swfupload.swf",
				upload_url: "<?php echo $this->get_settings('web_url'); ?>/admin/gallery-upload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>",
								"path" : "<?php echo $galerie['path'] ?>",
								"path_thumbs" : "<?php echo $galerie['path_thumbs'] ?>",
								"gid" : "<?php echo $galerie['id'] ?>"
								},
				file_size_limit : "3 MB",
				file_types : "*.jpg",
				file_types_description : "JPG Images",
				file_upload_limit : 0,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: true,

				// Button settings
				button_image_url : "<?php echo $this->get_settings('web_url'); ?>/admin/includes/swfupload/js/SmallSpyGlassWithTransperancy_17x18.png",
				button_width: "180",
				button_height: "18",
				button_text : '<span class="button">Zvolte fotografie<span class="buttonSmall">(3 MB Max)</span></span>',
				button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
				button_text_top_padding: 0,
				button_text_left_padding: 18,
				button_placeholder_id : "spanButtonPlaceHolder",

				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
</script>