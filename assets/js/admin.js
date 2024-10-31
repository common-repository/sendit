  jQuery(document).ready(function($) {
    //ajax
    jQuery(document).on('click','.save_contact',
      function (e) {
	   $form = $('.senditcontactform');
	   idcontact = $form.find( "input[name='id_email']" ).val();
	   newcontact = $form.find( "input[name='email']" ).val();
	   newstatus  = $form.find( "select[name='accepted']" ).val();
        jQuery.post(sendit_ajaxurl, {
					action: 'update_contact',
					id_contact:  idcontact,
					email: newcontact,
					accepted: newstatus
				}, function(output) {
				//jQuery('#sendit_modal_response').html(output);
				alert(output);
			});

        tb_remove();
        $('#sendit-contact-'+idcontact).html(newcontact).css('color', '#5cb85c').css('font-weight', 'bold');
        $('#sendit-contact-status-'+idcontact).html(newstatus).css('color', '#5cb85c').css('font-weight', 'bold');

      }
    );

    jQuery(document).on('click','.destroy_contact',
     function (e) {
	   $form = $('.senditdeleteform');
	   idcontact = $form.find( "input[name='id_email']" ).val();
        jQuery.post(sendit_ajaxurl, {
					action: 'destroy_contact',
					id_contact:  idcontact,
				}, function(output) {
				//jQuery('#sendit_modal_response').html(output);
				alert(output);
			});

        tb_remove();
        $('#sendit-contact-'+idcontact).css('color', 'red').css('font-weight', 'bold');
        $('#sendit-contact-status-'+idcontact).css('color', 'red').css('font-weight', 'bold');

      }
    );

    jQuery(document).on('click','.insert_contacts',
     function (e) {
     jQuery('#contacts_modal_response').spin('start');
	   $form = $('.senditcontactaddform');
	   emails = $form.find( "textarea[name='emails']" ).val();
     list_id = $('#list_id').val();
        jQuery.post(sendit_ajaxurl, {
					action: 'insert_contacts',
					emails:  emails,
          list_id: list_id
				}, function(output) {
				jQuery('#contacts_modal_response').html(output);
				//alert(list_id);
			});

        //tb_remove();
        //$('#sendit-contact-'+idcontact).css('color', 'red').css('font-weight', 'bold');
        //$('#sendit-contact-status-'+idcontact).css('color', 'red').css('font-weight', 'bold');

      }
    );

  });

  jQuery(document).ready(function(){
  	//datatable
  	jQuery('#email_all').click(function(){
  	    jQuery('input:checkbox').each(function(){
  	        jQuery(this).prop('checked',true);
  	   })
  	});

  jQuery('#email_none').click(function(){
      jQuery('input:checkbox').each(function(){
          jQuery(this).prop('checked',false);
     })
  });


  jQuery('.rm_options').slideUp();
  // place meta box before standard post edit field


  jQuery('#template_choice').insertBefore('#titlewrap');


  jQuery(".scroll").click(function(event){
  	event.preventDefault();
  	jQuery('html,body').animate({scrollTop:jQuery(this.hash).offset().top}, 500);
  });




  jQuery('.rm_section h3').click(function(){
  	if(jQuery(this).parent().next('.rm_options').css('display')=='none')
  		{	jQuery(this).removeClass('inactive');
  			jQuery(this).addClass('active');
  			jQuery(this).children('img').removeClass('inactive');
  			jQuery(this).children('img').addClass('active');

  		}
  	else
  		{	jQuery(this).removeClass('active');
  			jQuery(this).addClass('inactive');
  			jQuery(this).children('img').removeClass('active');
  			jQuery(this).children('img').addClass('inactive');
  		}

  	jQuery(this).parent().next('.rm_options').slideToggle('slow');

  });
  });

  jQuery(document).ready(function($) {

        $(".send_to_editor").click( function() {
  		   var clicked_link = $(this);
        	   post_id= clicked_link.data("post-id");
        	   clicked_link.siblings('span.spinner').css('display','inline');
        	   content_type = clicked_link.data("content-type");
  		   ajaxURL = ajaxurl;//SingleAjax.ajaxurl

      $.ajax({
      	type: 'POST',
  		url: ajaxURL,
  		data: {"action": "sendit-load-single","post_id": post_id,"content_type": content_type},
  		success: function(response) {
  			send_to_editor(response);
        	    clicked_link.siblings('span.spinner').css('display','none');

          }
      });

        });
  });
