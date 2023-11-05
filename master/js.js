
jQuery(document).ready(function($){	



	$("#remove-post-thumbnail").click(
	  function () {
	  	alert('s');
	    $("#gst_myplugin_new_field").val('');
	    $("#gst_myplugin_new_field_alt").val('');
	  }
	);

	
	function getImgSize(imgSrc){
	    var newImg = new Image();
	    newImg.src = imgSrc;
	    var height = newImg.height;
	    var width = newImg.width;
	    p = $(newImg).ready(function(){
	        return {width: newImg.width, height: newImg.height};
	    });
	    
	    return (p[0]['width']+"x"+p[0]['height']);
		
	}




	$(".gstthumbimg").mouseout(
	  function () {
	    //alert('x');
		// $("#postimagediv .inside .newimg").hide('');
		// $("#postimagediv .inside .hide-if-no-js img").show();
	 //    $("#gst_myplugin_new_field").val('');
	    //$("form#post").submit();
	  	//gst-holder
	  }
	);




	jQuery(".gstthumbimg-cont img").click(
	  function () {

	  	  var link = jQuery(this).attr("src");
	  	  // var dataimg = '<p class="hide-if-no-js newimg"><a title="Zvolit náhledový obrázek" href="/wp-admin/media-upload.php?post_id=48&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=337" id="set-post-thumbnail" class="thickbox"><img width="266" height="199" src="'+link+'" class="attachment-266x266" alt="Animals_Dogs_Wearing_glasses_Dog_005508_"></a></p>';

          $("#gst_myplugin_new_field").val($(this).attr("src"));
          $("#gst_myplugin_new_field_alt").val($(this).attr("alt"));
                    // $("#gst_myplugin_new_field").val($(this).attr("attr-big"));

		  // $("#postimagediv .inside .hide-if-no-js img").hide();
		  // $("#postimagediv .inside .newimg").html('');
		  // $("#postimagediv .inside .newimg").remove('');
		  // $(".editor-post-featured-image ").html('');
		  // $(".editor-post-featured-image ").prepend('<img src="'+$(this).attr("src")+'">');
		  // $(".editor-post-featured-image button").remove();
		  // $('.editor-post-featured-image img').attr("src", $(this).attr("src"));
		  // $('.editor-post-featured-image .components-responsive-wrapper span').css('padding', 'auto');

var audio = new Audio('/wp-content/plugins/featured-image-from-external-sources/completed.mp3');
             audio.play();



// IF CONCEPT EXISTS
if ( jQuery(".editor-post-save-draft").length > 0 ) {   

jQuery(".editor-post-save-draft").click();

	  }else{

// ELSEIF PUBLISH


	jQuery(".editor-post-publish-button").click();

	  }


setTimeout(function(){ 

// IF CONCEPT EXISTS
if ( jQuery(".editor-post-save-draft").length > 0 ) {   

jQuery(".editor-post-save-draft").click();

	  }else{

// ELSEIF PUBLISH


	jQuery(".editor-post-publish-button").click();

	  }



	}, 5000);



// $.ajax({
//     url: "/wp-admin/admin-ajax.php",
//     type: "POST",
//     data: {
//         action: "update_button",
//         button:  $( this ).val()
//     }
// });
//     //       //



	  	//   var link = $(this).attr("src");
	  	//   var title = $(this).attr("title");
	  	  
	  	//   // var parentOffset = $(this).parent().offset(); 
	  	//   // var parentOffsetHolder = $('.gst-holder').offset(); 
	  	//   // var relX = parentOffset.left-370;
	   //   //  var relY = parentOffset.top-parentOffsetHolder.top-170;
		  
		  // $(".gst-title").fadeIn();
	  	  
	  	// //   $(".gst-title").css("margin-left", relX+"px");
		  // // $(".gst-title").css("margin-top", relY+"px");
		  
		  // // $("#preview").css('zIndex', '3000');

		  // var imgsizes = getImgSize(link);
		  
		  // if(imgsizes != 0){
		  // 	$("#postimagediv h3.hndle .gst-title").remove();                                
   	// 	  	$("#postimagediv h3.hndle").append("<span class=\"gst-title\">Original: "+imgsizes+"px</span>");                                
   	// 	  }


	  	 //  var imgsizes = getImgSize(link);
		  
     //      if(imgsizes != 0){
		  	// $(this).parent().prepend("<div class='gstlabel'>"+imgsizes+"px</div>");                                
     //      }else{
     //      	$(this).parent().prepend("<div class='gstlabel'>Unknown</div>");                                
     //      }

	  }
	);


	$(".gstthumbimg").click(
	  function () {
	    $("form#post").submit();
	  }
	);



	// $(".gstthumbimg").hover(function($){
	// 	this.t = this.title;
 //        this.title = "";    
 //        var c = (this.t != "") ? "<br/>" + this.t : "";
        
 //        $("#preview").html("<p id=''><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");                                
 //        $("#preview")
 //            .css("top",(e.pageY - xOffset) + "px")
 //            .css("left",(e.pageX + yOffset) + "px")
 //            .fadeIn("fast");                        
 //    },
 //    function(){
 //        this.title = this.t;    
 //        $("#preview p").remove();
 //    }); 


});




