			;(function($) {

			var do_import = function() {

				var success_step,data_index =0,ids=[],response,index=0 ;

			    var loader = $("#sample-data-installer .tasks li .loader");

				$("#install-sample-data").on("click",function(){
				    loader.eq(0).removeClass('hide_load');

					import_data('reset','');
					$(this).css({'opacity':'0.5', 'pointer-events': 'none'});

				});

				function task_complete(response) {

					switch(response.step) {

						case 'file_not_found':

							loader.eq(0).parent().text('Error! file not found');

						break;

						case 'reset':
							import_data('reset');
						case 'preload':
					        import_data("preload");
					        loader.eq(0).parent().find("progress").show();
						break;

						case 'import_small_data':
						    success_step = 'import_small_data';
							import_data('import_small_data');
					        break;

						case 'import_content':
							loader.eq(0).parent().find("progress").attr('max',response.max -1).show();
						    success_step = 'import_content';

							loader.eq(0).parent().find("progress").attr('value',response.current);

							import_data('import_content');

					        break;

				       	case 'update_data':

					        import_data("update_data",'');

					        break;

					    case 'get_ids':

					        ids = response.attachment_ids;

					        import_data('get_ids');

					        index ++;

					        break;

					    case 'download-attachment':

					    success_step = 'download-attachment';

					    loader.eq(0).addClass("hide_load").parent().addClass("line-through");
				    	loader.eq(0).parent().find("progress").hide();
					    loader.eq(1).removeClass('hide_load');
						loader.eq(1).parent().find("progress").attr('max',response.media_ids -1).show();
						loader.eq(1).parent().find("progress").attr('value',response.media_index -1).show();
						    import_data('download-attachment');
						    break;
					    case 'complete':

							    loader.eq(1).addClass('hide_load').parent().addClass('line-through');
							    loader.eq(1).parent().find("progress").hide();
							    $("#sample-data-installer .media-status").addClass('hide_load');

							    $(".finish-actions").show();

					        break;

					}

				}



				function import_data(step,params) {



					$.ajax( ajaxurl, {

						data: { action: 'sample_data', step: step, params: params },

						type: 'post',

				        success:function(response) {

				        	task_complete(response);

				        },

				        error:function(){

				        	var response;

				        	switch(success_step) {

				        		case 'preload':

					        		response = jQuery.parseJSON( '{ "step": "preload" }' );

				        		break;

				        		case 'download-attachment':

					        		response = jQuery.parseJSON( '{ "step": "download-attachment" }' );

				        		break;

				        		case 'import_content':

					        		response = jQuery.parseJSON( '{ "step": "import_content" }' );

				        		break; 
				        		case 'import_small_data':

					        		response = jQuery.parseJSON( '{ "step": "import_small_data" }' );

				        		break; 

				        	}

				        		task_complete(response);

				        },

						complete: function(response, status){

						}



					} );

				}

			}



			// Dom Ready

			$(function() { 

				do_import();

			})



			})(jQuery);



			