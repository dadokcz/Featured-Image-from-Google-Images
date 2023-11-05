<?php
/*
Plugin Name: Featured Image from External Sources
Plugin URI: http://wordpress.org/extend/plugins/featured-image-from-external-sources/
Description: Fastest way to choose thumbnail for your posts.
Version: 1.0
Author: Ondřej Dadok
Author URI: http://www.dadok.cz/
*/

load_plugin_textdomain( 'featured-image-from-external-sources', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if(get_option('fi_zdroj') == '' && get_locale() == 'cs_CZ'){update_option('fi_zdroj', 'seznam'); }
if(get_option('fi_zdroj') == '' && get_locale() != 'cs_CZ'){update_option('fi_zdroj', 'yahoo'); }
if(get_option('fi_terms_of_use') == ''){update_option('fi_terms_of_use', 0); }
if(get_option('fi_blinded_on') == ''){update_option('fi_blinded_on', 0); }
if(get_option('fi_blinded_assistent_email') == ''){update_option('fi_blinded_assistent_email', get_bloginfo( 'admin_email' )); }


if(get_option('fi_email_subject') == ''){update_option('fi_email_subject', __("Request for photo selection", 'featured-image-from-external-sources')); }
if(get_option('fi_email_body') == ''){update_option('fi_email_body', __("Hello, <br/> <br/>
you were prompted to select a suitable opening photo for <strong> %%ARTICLE%% </strong>. <br/> <br/>
To select a photo, just click on the photo. <br/> <br/>
%%HTMLCONTENT%%", 'featured-image-from-external-sources')); }

if(get_option('fi_email_notification_subject') == ''){update_option('fi_email_notification_subject', __("Preview photo was selected", 'featured-image-from-external-sources')); }
if(get_option('fi_email_notification_body') == ''){update_option('fi_email_notification_body', __("Hello, <br/> <br/>
preview photo for <strong> %%ARTICLE%% </strong> were just added.", 'featured-image-from-external-sources')); }



add_action( 'init', 'fifes_wpa80246_init' );
// add_action( 'init', 'myplugin_save_postdata' );

function fifes_wpa80246_init(){


  $postnum = intval($_GET['post']);

  if(isset($_GET['changepicto']) && isset($_GET['post'])){

  $clanek = get_post($postnum);

  fifes_save_postdata_external( $postnum, base64_decode($_GET['changepicto']), base64_decode($_GET['title']) );

    
  $headers = array('Content-Type: text/html; charset=UTF-8');

  $message = get_option('fi_email_notification_body');

  $email = get_the_author_meta( 'user_email', $clanek->post_author );

  // $message = str_replace('%%HTMLCONTENT%%', $html, $message);
  $message = str_replace('%%ARTICLE%%', $clanek->post_title, $message);

  wp_mail(sanitize_email($email), get_option('fi_email_notification_subject'), $message, $headers);

        header('location:/?p='.$clanek->ID.'&preview=true&timestamp='.time().'');
    die();



      // echo 'fotka: '.get_the_post_thumbnail_url($clanek->ID, 'full');
      // die();
    // if($clanek->post_status == 'publish'){
    // }else{

    //   die('Děkujeme, fotografie byla přidána a článek bude zveřejněn po jeho schválení.');

    // }

  }




}






if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['SCRIPT_FILENAME'])){

$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));

}; };

if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['PATH_TRANSLATED'])){

$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])));

}; };


add_theme_support('post-thumbnails');


add_action( 'admin_print_footer_scripts', 'fifes_remove_save_button' );
function fifes_remove_save_button()
{   

global $post;

if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php') ) {
?>

<style type="text/css">
  .gst-title{
    color: #a0a0a0;
    float: right;
    font-size: 80%;
    line-height: 150% !important;
    text-align: right;
  }
  .gst-holder{
    height: auto;
    position: inherit;
  }
  .gst-holder img{
    width: auto;
    height: 120px;
    /*border-radius: 7px;*/
  }
  .gstthumbimg-cont{
    text-align: center;
    float: left;
    display: block;
    width: auto;
    height: 120px;
    margin: 5px 5px 5px 5px;
    overflow: hidden;
    border-radius: 7px;
  }
  .gstthumbimg-cont:hover{
    border-radius: 7px;
    cursor: pointer;
  }


  #preview img{
    vertical-align: middle;
    margin: auto;
    padding: auto;
    max-height: 130px;
    width: auto;
  }
 .gstlabel{
    padding: 7px;
    font-size: 100%;
    opacity: 0.8;
    position: absolute;
    color: #fff;
    line-height: 450%;
    text-align: center;
    text-shadow: 1px 1px 1px #000;
    width: 80px;
  }
   #preview {
    text-align: center;
    display: none;
    background-color: #fff0a0;
    background-image: -webkit-linear-gradient(top, hsla(0,0%,100%,.5), hsla(0,0%,100%,0));
    background-image:    -moz-linear-gradient(top, hsla(0,0%,100%,.5), hsla(0,0%,100%,0));
    background-image:     -ms-linear-gradient(top, hsla(0,0%,100%,.5), hsla(0,0%,100%,0));
    background-image:      -o-linear-gradient(top, hsla(0,0%,100%,.5), hsla(0,0%,100%,0));
    background-image:         linear-gradient(top, hsla(0,0%,100%,.5), hsla(0,0%,100%,0));
    border-radius: 5px;
    box-shadow: inset 0 1px 1px hsla(0,0%,100%,.5),
                3px 3px 0 hsla(0,0%,0%,.1);
    color: #333;
    font: 16px/25px sans-serif;
    padding: 15px 25px;

    position: absolute;
    z-index: 4000000;

    text-shadow: 0 1px 1px hsla(0,0%,100%,.5);
}
 #preview:after,  #preview:before {
    border-bottom: 25px solid transparent;
    border-right: 25px solid #fff0a0;
    bottom: -25px;
    content: '';
    position: absolute;
    right: 25px;
}
 #preview:before {
    border-right: 25px solid hsla(0,0%,0%,.1);
    bottom: -28px;
    right: 22px;
}
.gst-holder-loading{
  display: none;
  text-align: center;
  width: 100%;
}
.gst-holder-loading img{
  vertical-align: middle;
  text-align: center;
  height: 40px;
  width: 180px;
  margin: auto;
  padding: auto;
}
</style>



<script>





jQuery(document).ready(function(){




  jQuery('.send-cooperator-email').click(function(){ 
        // alert(jQuery('.gst-holder-cont').html());
         fifes_doAjaxRequest2( jQuery('input[name="send-to"]').val() );

  });




  jQuery('#gst-holder-submit').click(function(){ 
         
         jQuery(".gst-holder").css("display", "none");
         jQuery(".gst-holder-loading").css("display", "block");


         var val = jQuery('#json_click_handler').val();
           fifes_doAjaxRequest(val);

  });

});

function fifes_fixedEncodeURIComponent(str){
     return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}



function fifes_doAjaxRequest2(val){

      jQuery.ajax({
          url: '<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php',
          data:{
               'action':'do_ajax',
               'fn':'email_to_coop',
               'email':val,
               'htmldata':jQuery("#json_click_handler").val(),
               'postid':jQuery("#postid").val(),
               },
          dataType: 'JSON',
          success:function(data){
            alert('Odesláno');
          }

 
     });
            

}


// function fifes_b64_to_utf8( str ) {
//   return decodeURIComponent(escape(window.atob( str )));
// }


function fifes_doAjaxRequest(val){
     var val = fifes_fixedEncodeURIComponent(val);

     jQuery.ajax({
          url: '<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php',
          data:{
               'action':'do_ajax',
               'fn':'get_latest_posts',
               'val':val
               },
          dataType: 'JSON',
          success:function(data){
     
             jQuery(".gst-holder").css("height", "auto");
             jQuery(".gst-holder").css("float", "left");
     
             jQuery('.gst-holder').hide();
             jQuery(".gst-holder-loading").hide();
             

             // data_decoded = fifes_b64_to_utf8(data);


             jQuery('.gst-holder').html(data);
             

             
             // alert(data);

             jQuery('.gst-holder').fadeIn('slow');
     



             var pocetObrazku = jQuery('.gstthumbimg-cont');
             jQuery('.info-count').html('<?php _e("Found", 'featured-image-from-external-sources');?> '+pocetObrazku.length+' <?php _e("results", 'featured-image-from-external-sources');?>');
             jQuery('.coop').show();
             

             if(pocetObrazku.length > 0){
             var audio = new Audio('<?php echo plugins_url( basename( __DIR__ ) . '/loaded.mp3'  );?>');
             audio.play();
             }else{
              var audio = new Audio('<?php plugins_url( basename( __DIR__ ) . '/error.mp3'  );?>');
             audio.play();
          }
            


        jQuery.getScript("<?php echo get_home_url(); ?>/wp-content/plugins/featured-image-from-external-sources/js.js", function(data, textStatus, jqxhr) 
             {
             console.log(data); //data returned
             console.log(textStatus); //success
             console.log(jqxhr.status); //200
             console.log('Load was performed.');
            });

          },
          error: function(errorThrown){
               alert('<?php _e("External Source timeout. Please try again later.", 'featured-image-from-external-sources');?>');
               console.log(errorThrown);
          }
           
 
     });

   
}

</script>



<?php
  }
}




function fifes_wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','fifes_wpse27856_set_content_type' );





function fifes_email_to_coop($email, $data, $postid){
  // mail($email, 'x', 'x');
  $post = get_post($postid);
  $html = ajax_get_latest_posts($data, 'email', $postid);

  $headers = array('Content-Type: text/html; charset=UTF-8');

  $message = get_option('fi_email_body');

  $message = str_replace('%%HTMLCONTENT%%', $html, $message);
  $message = str_replace('%%ARTICLE%%', $post->post_title, $message);

  wp_mail(sanitize_email($email), get_option('fi_email_subject'), $message, $headers);
}









function search_file_inmedia( $file_url ){
  global $wpdb;
  $filename = basename( $file_url );

  $rows = $wpdb->get_var("
  SELECT     COUNT(*)
  FROM       wp_postmeta 
             WHERE wp_postmeta.meta_key = '_wp_attached_file'
             AND wp_postmeta.meta_value LIKE '%".like_escape($filename)."%'
  ");

  return $rows;

}

function search_file_inmedia_id( $file_url ){
  global $wpdb;
  $filename = basename( $file_url );

  $rows = $wpdb->get_row("
  SELECT     post_id
  FROM       wp_postmeta 
             WHERE wp_postmeta.meta_key = '_wp_attached_file'
             AND wp_postmeta.meta_value LIKE '%".like_escape($filename)."%'
  ");

  return $rows->post_id;
}





function save_image($url, $title) {

    global $post; 

    
    $filename = explode("/", $url);
    $filename = array_reverse($filename);

    $filename = $filename[0];

    if(search_file_inmedia( $filename ) > 0){

    set_post_thumbnail( $post, search_file_inmedia_id($filename) );
  
    }else{

      //$youtube_url = get_post_meta( $post->ID, 'videobox', true );
      //$youtubeid = youtubeid($youtube_url);
        //$thumb_url = 'http://img.youtube.com/vi/'. $youtubeid .'/0.jpg';
    $thumb_url = $url;


        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        @set_time_limit(300);

        if ( ! empty($thumb_url) ) {
            // Download file to temp location
            $tmp = download_url( $thumb_url );

            // Set variables for storage
            // fix file filename for query strings
            preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;

            // If error storing temporarily, unlink
            if ( is_wp_error( $tmp ) ) {
                @unlink($file_array['tmp_name']);
                $file_array['tmp_name'] = '';
            }
            $desc = $title;
            // do the validation and storage stuff
            $thumbid = media_handle_sideload( $file_array, $post->ID, $desc );
            // If error storing permanently, unlink
            if ( is_wp_error($thumbid) ) {
                @unlink($file_array['tmp_name']);
                return $thumbid;
            }
        }

        set_post_thumbnail( $post, $thumbid );

      }


}



function save_image_external($url, $postid, $title) {
    $post = get_post($postid);

    
    $filename = explode("/", $url);
    $filename = array_reverse($filename);

    $filename = $filename[0];

    if(search_file_inmedia( $filename ) > 0){

    set_post_thumbnail( $post, search_file_inmedia_id($filename) );
  
    }else{

      //$youtube_url = get_post_meta( $post->ID, 'videobox', true );
      //$youtubeid = youtubeid($youtube_url);
        //$thumb_url = 'http://img.youtube.com/vi/'. $youtubeid .'/0.jpg';
    $thumb_url = $url;


        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        @set_time_limit(300);

        if ( ! empty($thumb_url) ) {
            // Download file to temp location
            $tmp = download_url( $thumb_url );

            // Set variables for storage
            // fix file filename for query strings
            preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;

            // If error storing temporarily, unlink
            if ( is_wp_error( $tmp ) ) {
                @unlink($file_array['tmp_name']);
                $file_array['tmp_name'] = '';
            }
            $desc = $title;
            // do the validation and storage stuff
            $thumbid = media_handle_sideload( $file_array, $post->ID, $desc );
            // If error storing permanently, unlink
            if ( is_wp_error($thumbid) ) {
                @unlink($file_array['tmp_name']);
                return $thumbid;
            }
        }

        set_post_thumbnail( $post, $thumbid );

      }


}




add_action( 'add_meta_boxes', 'fifes_add_custom_box' );




add_action( 'save_post', 'fifes_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function fifes_add_custom_box() {
    $screens = array( 'post', 'side');
    foreach ($screens as $screen) {
        add_meta_box(
            'myplugin_sectionid',
            __( 'Featured Image from External Sources', 'featured-image-from-external-sources' ),
            'fifes_inner_custom_box',
            $screen
        );
    }
}

add_action('wp_ajax_nopriv_do_ajax', 'fifes_our_ajax_function222');
add_action('wp_ajax_do_ajax', 'fifes_our_ajax_function222');

function fifes_our_ajax_function222(){
 
   // the first part is a SWTICHBOARD that fires specific functions
   // according to the value of Query Var 'fn'
 
     switch($_REQUEST['fn']){
          case 'email_to_coop':
          // alert('ok');


          $allowed_html = array(
  'a' => array(
    // 'href' => array(),
  ),
  'br' => array(),
  'strong' => array(),
  'img' => array()
);
$str = wp_kses( $_REQUEST['htmldata'], $allowed_html );


               $output = fifes_email_to_coop(sanitize_email($_REQUEST['email']), $str, intval($_REQUEST['postid']));
          break;
          case 'get_latest_posts':
          // alert('ok');

               $output = ajax_get_latest_posts($_REQUEST['val']);
          break;
          default:
              $output = 'No function specified, check your jQuery.ajax() call';
          break;
 
     }
 
   // at this point, $output contains some sort of valuable data!
   // Now, convert $output to JSON and echo it to the browser 
   // That way, we can recapture it with jQuery and run our success function
 
          $output=json_encode($output);
         if(is_array($output)){
        print_r($output);   
         }
         else{
        echo $output;
         }
         die;
 
}

function ajax_get_latest_posts($val, $type = '', $postid = ''){


include "simple_html_dom.php";

   $q = urlencode($val);


   if(get_option('fi_zdroj') == 'yahoo'){
   
    // YAHOO
    
    $url="https://images.search.yahoo.com/search/images;_ylt=AwrJ4NZ5zxheaN0AWWqJzbkF;_ylu=X3oDMTBsZ29xY3ZzBHNlYwNzZWFyY2gEc2xrA2J1dHRvbg--;_ylc=X1MDOTYwNjI4NTcEX3IDMgRhY3RuA2NsawRjc3JjcHZpZANpSWxVdURFd0xqSU0xSVJOWGdGUkFneXBNVEE1TGdBQUFBQVR6SzU1BGZyA3NmcARmcjIDc2EtZ3AEZ3ByaWQDQzB5M2Q0Y0tRZ2E0MUhueGdsanpnQQRuX3N1Z2cDMTAEb3JpZ2luA2ltYWdlcy5zZWFyY2gueWFob28uY29tBHBvcwMwBHBxc3RyAwRwcXN0cmwDBHFzdHJsAzEwBHF1ZXJ5A2tvJUM0JThEa2EEdF9zdG1wAzE1Nzg2ODQyODM-?p=".$q."&imgsz=large&fr=sfp&fr2=sb-top-images.search&ei=UTF-8&n=60&x=wrt&y=Search";

   }elseif(get_option('fi_zdroj') == 'unsplash'){

   // SEZNAM

    $url = "https://unsplash.com/s/photos/".$q."";
 
    }elseif(get_option('fi_zdroj') == 'freepik'){

   // SEZNAM

    $url = "https://www.freepik.com/search?dates=any&format=search&page=1&query=".$q."&selection=1&sort=popular&type=photo";

   }else{

   // SEZNAM

    $url = "https://obrazky.seznam.cz/?q=".$q."&size=any&color=any&pornFilter=1&sgId=MjIyODI3NyAxNTc5MTI2NzU2LjI3NA%3D%3D&oq=karel+giebisch&aq=-1&su=e#id=c8f6c4a563f750fd";

  
  }

    $response = wp_remote_get( $url );
    $result = $response['body'];

    // curl_close($ch2);

    // echo $result;



    $html = fifes_str_get_html($result);


$titles = $html->find('a');

// $pics = array_filter($pics, function($value) { return !is_null($value) && $value !== ''; });
$i = -1;
foreach($titles as $element) {
  // echo $element->src;
       if(strlen($element->attr['aria-label']) > 5)
       $i++;
       // $newurl = $element->src.'&h=800';
       // if(@getimagesize($newurl))
       // echo '<img src="'.$newurl.'">';

       $titles22[$i]['title'] = $element->attr['aria-label'];
       $titles22[$i]['href'] = $element->attr['href'];

    }


$pics = $html->find('img');
unset($i);

foreach($pics as $element) {
        // echo $element->src;
      if( strpos($element->src, '1px') ){continue;}

       if(strlen($element->src) > 5){
       $qq++;
        $newurl = $element->src.'&h=800';
        $alt = $element->alt;
       // if(@getimagesize($newurl))
       // echo '<img src="'.$newurl.'">';

       $results[$qq]['src'] = $newurl;
       // $div = $html->find('h1', 0)->parent();

       $results[$qq]['title'] = $titles22[$qq]['title'];
       $results[$qq]['alt'] = $alt;
       $results[$qq]['href'] = 'https://images.search.yahoo.com/'.$titles22[$qq]['href'];
       
       }
    }





$results = uniqueAssocArray($results, 'src');
// echo '<pre>';
//     print_r($results);


// echo '</pre>';

foreach ($results as $key => $value) {


  // echo '<a href="'.$value['href'].'"><img src="'.$value['src'].'" title="'.$value['title'].'"> <br/>';
  if($type == 'email'){
      $style= 'height:100px;width:auto;';
      $imgs.= '&nbsp; .<a href="http://'.$_SERVER['HTTP_HOST'].'/?post='.$postid.'&changepicto='.base64_encode($value['src']).'&title='.base64_encode($value['alt']).'" target="_blank">';  
  }else{
      $imgs.= '<div class="gstthumbimg-cont">';  
    
  }
      $imgs.= '<img src="'.$value['src'].'" attr-big="'.$value['href'].'" class="gstthumbimg" title="'.$value['title'].'" alt="'.$value['alt'].'" style="'.$style.'" />';
      // $imgs = stripslashes($imgs);
      // $imgs.= '<img src="".$value["src"]."" />';
  // $imgs.= 'x';
   
   if($type == 'email'){
      $imgs.= '</a>';  
  }else{
      $imgs.='</div>';

  }

    }






// die('x');



  return $imgs;

}




function uniqueAssocArray($array, $uniqueKey) {
    if (!is_array($array)) {
        return array();
    }
    $uniqueKeys = array();
    foreach ($array as $key => $item) {
        $groupBy=$item[$uniqueKey];
        if (isset( $uniqueKeys[$groupBy]))
        {
            //compare $item with $uniqueKeys[$groupBy] and decide if you 
            //want to use the new item
            // $replace= ... 
        }
        else
        {
            $replace=true;
        }
        if ($replace) $uniqueKeys[$groupBy] = $item;   
    }
    return $uniqueKeys;
}

// function get_url_contents($url) {
//     $crl = curl_init();

//     curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
//     curl_setopt($crl, CURLOPT_URL, $url);
//     curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

//     $ret = curl_exec($crl);
//     curl_close($crl);
//     return $ret;
// }


// function GetRandomImageURL($topic='', $min=0, $max=100)
// {
//   // get random image from Google
//   if ($topic=='') $topic='image';
//   $ofs=mt_rand($min, $max);

//   //WHEN WE NEED RAND RESULTS
//   //$geturl='http://www.google.ca/images?q=' . $topic . '&start=' . $ofs . '&gbv=1';
//   $num = rand(1, 100);
//   $data = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . $topic . '' . $num . '');
//   $data = json_decode($data);


//   foreach ($data->responseData->results as $result) {
//      $results[] = array('url' => $result->url, 'alt' => $result->title);
//   }

//    return $results[0]['url'];

// }


function PluginUrl() {

        //Try to use WP API if possible, introduced in WP 2.6
        if (function_exists('plugins_url')) return trailingslashit(plugins_url(basename(dirname(__FILE__))));

        //Try to find manually... can't work if wp-content was renamed or is redirected
        $path = dirname(__FILE__);
        $path = str_replace("\\","/",$path);
        $path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
        return $path;
}



/* Prints the box content */
function fifes_inner_custom_box( $post ) {
  global $post;
  


if(get_option('fi_terms_of_use') != 1){ 

?>

<span style="color:red"><?php _e("You must agree a Terms of Use in", 'featured-image-from-external-sources');?> <a href="/wp-admin/options-general.php?page=fifes"><?php _e("Plugin settings", 'featured-image-from-external-sources');?></a>.</span>

<?php
}else{
  ?>
    <style type="text/css">
      
.coop{
  display: none;
}

    </style>

  <div id="preview"></div>
  <input type="text" id="json_click_handler" size="20" value="<?php echo $post->post_title; ?>"><input type="button" id="gst-holder-submit" value="<?php _e("Search Thumbnails", 'featured-image-from-external-sources');?> &rsaquo;&rsaquo;" style="background: #007cba; color: #fff; border: 0; border-radius: 4px; cursor: pointer; padding: 6px 20px 6px 20px;" /><span class="info-count"></span> 
  <?php
  if(get_option('fi_blinded_on') == 1){
?> <div class="send-to-cooperator coop"><br/><?php _e("Send image suggestions to assistent", 'featured-image-from-external-sources');?>: <input type="text" name="send-to"  placeholder="<?php _e("Publishers E-mail", 'featured-image-from-external-sources');?>" value="<?php echo get_option('fi_blinded_assistent_email');?>" /><input type="button" class="send-cooperator-email" value="Odeslat"></div><?php } ?>
   
<input type="hidden" id="postid" name="postid" value="<?php echo $post->ID;?>">
  <?php


  
  $post_title = urlencode($post->post_title);

  echo '<div class="gst-holder-loading"><center><img src="'.PluginUrl().'/loading.gif" /></center></div><div class="gst-holder gst-holder-cont">';
  
  echo '</div>';

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );


  echo '<input type="hidden" id="gst_myplugin_new_field" name="gst_myplugin_new_field" value="'.get_post_meta( $post->ID, 'gst_myplugin_new_field', true).'" size="25" />';
  echo '<input type="hidden" id="gst_myplugin_new_field_alt" name="gst_myplugin_new_field_alt" value="'.get_post_meta( $post->ID, 'gst_myplugin_new_field_alt', true).'" size="25" />';
  echo '<div id="gst-holder" style=""></div>';


}

}





/* When the post is saved, saves our custom data */
function fifes_save_postdata( $post_id ) {
$gst_myplugin_new_field_sanitized = sanitize_text_field( $_POST['gst_myplugin_new_field']);
$gst_myplugin_new_field_alt_sanitized = sanitize_text_field( $_POST['gst_myplugin_new_field_alt']);

if($gst_myplugin_new_field_sanitized || isset($url)){

  $url = sanitize_text_field( $gst_myplugin_new_field_sanitized );
  $title = sanitize_text_field( $gst_myplugin_new_field_alt_sanitized );

  update_post_meta( $post_id, 'gst_myplugin_new_field', $url);
  update_post_meta( $post_id, 'gst_myplugin_new_field_alt', $title);


  if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php') ) {
   
    // First we need to check if the current user is authorised to do this action. 
    if ( 'page' == $_POST['post_type']) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return;
    }





if($url != ''){
    //sanitize user input
    $mydata = $url.'.jpg';

   // ULOZ FOTKU

    // Gives us access to the download_url() and wp_handle_sideload() functions
    require_once( ABSPATH . 'wp-admin/includes/file.php' );

    // URL to the WordPress logo
    $url = $mydata;
    $timeout_seconds = 5;
    
    $temp_file = 'temp.jpg';

    // Download file to temp dir
    $temp_file = download_url( $url, $timeout_seconds );
    
    if ( !is_wp_error( $temp_file ) ) {

        // Array based on $_FILE as seen in PHP file uploads
        $file = array(
            'name'     => $title, // ex: wp-header-logo.png
            'type'     => 'image/png',
            'tmp_name' => $temp_file,
            'error'    => 0,
            'size'     => filesize($temp_file),
        );

        $overrides = array(
            // Tells WordPress to not look for the POST form
            // fields that would normally be present as
            // we downloaded the file from a remote server, so there
            // will be no form fields
            // Default is true
            'test_form' => false,

            // Setting this to false lets WordPress allow empty files, not recommended
            // Default is true
            'test_size' => true,
        );

        // Move the temporary file into the uploads directory
        $results = wp_handle_sideload( $file, $overrides );

        if ( !empty( $results['error'] ) ) {
            // Insert any error handling here
        } else {

            $filename  = $results['file']; // Full path to the file
            $local_url = $results['url'];  // URL to the file in the uploads dir
            $type      = $results['type']; // MIME type of the file

            // Perform any actions here based in the above results
        }

    }



    // or a custom table (see Further Reading section below)

     save_image($mydata, $title);

    update_post_meta( $post_id, 'gst_myplugin_new_field', '');
    update_post_meta( $post_id, 'gst_myplugin_new_field_alt', '');

   }

}}
}








/* When the post is saved, saves our custom data */
function fifes_save_postdata_external( $post_id, $url, $title ) {

if($_POST['gst_myplugin_new_field'] || isset($url)){

  update_post_meta( $post_id, 'gst_myplugin_new_field', $url);
  update_post_meta( $post_id, 'gst_myplugin_new_field_alt', $title);

  // if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php') ) {
   
    // First we need to check if the current user is authorised to do this action. 
    // if ( 'page' == $_POST['post_type']) {
    //   if ( ! current_user_can( 'edit_page', $post_id ) )
    //       return;
    // } else {
    //   if ( ! current_user_can( 'edit_post', $post_id ) )
    //       return;
    // }





if($url != ''){
    //sanitize user input
    $mydata = $url.'.jpg';

   // ULOZ FOTKU

    // Gives us access to the download_url() and wp_handle_sideload() functions
    require_once( ABSPATH . 'wp-admin/includes/file.php' );

    // URL to the WordPress logo
    $url = $mydata;
    $timeout_seconds = 5;
    
    $temp_file = 'temp.jpg';

    // Download file to temp dir
    $temp_file = download_url( $url, $timeout_seconds );
    
    if ( !is_wp_error( $temp_file ) ) {

        // Array based on $_FILE as seen in PHP file uploads
        $file = array(
            'name'     => basename($url.'jpg'), // ex: wp-header-logo.png
            'type'     => 'image/png',
            'tmp_name' => $temp_file,
            'error'    => 0,
            'size'     => filesize($temp_file),
        );

        $overrides = array(
            // Tells WordPress to not look for the POST form
            // fields that would normally be present as
            // we downloaded the file from a remote server, so there
            // will be no form fields
            // Default is true
            'test_form' => false,

            // Setting this to false lets WordPress allow empty files, not recommended
            // Default is true
            'test_size' => true,
        );

        // Move the temporary file into the uploads directory
        $results = wp_handle_sideload( $file, $overrides );

        if ( !empty( $results['error'] ) ) {
            // Insert any error handling here
        } else {

            $filename  = $results['file']; // Full path to the file
            $local_url = $results['url'];  // URL to the file in the uploads dir
            $type      = $results['type']; // MIME type of the file

            // Perform any actions here based in the above results
        }

    }


    // or a custom table (see Further Reading section below)

     save_image_external($mydata, $post_id, $title);

    update_post_meta( $post_id, 'gst_myplugin_new_field', '');
    update_post_meta( $post_id, 'gst_myplugin_new_field_alt', '');

   }

}
}







function fi_settings() {
  global $time;
  //register our settings
  register_setting( 'fi-settings-group', 'fi_zdroj', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_text_field') );
  register_setting( 'fi-settings-group', 'fi_terms_of_use' );
  register_setting( 'fi-settings-group', 'fi_blinded_on' );
  register_setting( 'fi-settings-group', 'fi_blinded_assistent_email', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_email') );
  register_setting( 'fi-settings-group', 'fi_email_subject', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_text_field') );
  register_setting( 'fi-settings-group', 'fi_email_body', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_text_field') );
  register_setting( 'fi-settings-group', 'fi_email_notification_subject', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_text_field') );
  register_setting( 'fi-settings-group', 'fi_email_notification_body', array( 'type' => 'string',  'sanitize_callback' => 'sanitize_text_field') );
}
  

  function fifes_safely_add_stylesheet_to_admin() {
    if($_GET['page'] == 'fifes'){
    wp_enqueue_style( 'fifes', plugins_url('in-admin-panel/', __FILE__).'/style.css', array(), '3.1' );
    }
  }
  add_action( 'admin_enqueue_scripts', 'fifes_safely_add_stylesheet_to_admin' );
  
  




function fifes_register_options_page() {
  add_options_page(__("Featured Image from External Sources", 'featured-image-from-external-sources'), __("Featured Image from External Sources", 'featured-image-from-external-sources'), 'manage_options', 'fifes', 'fifes_options_page');

  add_action( 'admin_init', 'fi_settings' );
}
add_action('admin_menu', 'fifes_register_options_page');


function fifes_options_page()
{
?>



<div class="wrap twitter2posts">

<div id="main_container">

<div class="header">
    <div class="logo"><?php _e("Featured Image from External Sources", 'featured-image-from-external-sources');?></div>
    
    <div class="right_header"><a href="http://www.dadok.cz" target="_blank" class="nounderline">© Ondřej Dadok, </a> <a href="http://www.dadok.cz" target="_blank"><?php _e("Visit site", 'featured-image-from-external-sources');?></a> <a href="mailto:info@dadok.cz" class="messages"><?php _e("Email me", 'featured-image-from-external-sources');?></a> <a href="#" class="beer" rel="modal-profile"><?php _e("Buy me a beer", 'featured-image-from-external-sources');?></a></div>
    <div id="clock_a"></div>
</div>
    
<div id="donate">
  
    

</div>

<div class="main_content">
               <div class="menu">
                    <ul>
                    <li><a href="#" class="current"><?php _e("Settings", 'featured-image-from-external-sources');?></a></li>
                    </ul>
               </div> 
                    
                    
    <div class="center_content">  
    
    <div class="right_content">            
        
         <div class="form">
         
     
     
    <script type="text/javascript">
     jQuery(document).ready(function () {
      
      jQuery.noConflict();
      
      // Position modal box in the center of the page
      jQuery.fn.center = function () {
        this.css("position","absolute");
        this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
        this.css("left", ( jQuery(window).width() - this.width() ) / 2+jQuery(window).scrollLeft() + "px");
        return this;
        }
      
      jQuery(".modal-profile").center();
      
      // Set height of light out div  
      jQuery('.modal-lightsout').css("height", jQuery(document).height());  
     
      // Fade in modal box once link is clicked
      jQuery('a[rel="modal-profile"]').click(function() {
        jQuery('.modal-profile').fadeIn("slow");
        jQuery('.modal-lightsout').fadeTo("slow", .5);
      });
      
      // closes modal box once close link is clicked, or if the lights out divis clicked
      jQuery('a.modal-close-profile, .modal-lightsout').click(function() {
        jQuery('.modal-profile').fadeOut("slow");
        jQuery('.modal-lightsout').fadeOut("slow");
      });
     
     
     
      jQuery(".donate-table td").click(function() {
        //jQuery("#amount_cont").hide();
          jQuery(".donate-table td").removeClass("current-donate");
        jQuery(this).addClass("current-donate");
        jQuery("#amount").val(jQuery(".current-donate span.price strong").html());
        jQuery('#amount_cont *').css("color", "#bcdeec");
         });
     
      jQuery(".customprice").click(function() {
        jQuery(".donate-table td").removeClass("current-donate");
          jQuery("#amount").val('').select();
          jQuery("#amount_cont").fadeIn();
          jQuery('#amount_cont *').css("color", "#fff");  
         });
        
     });
     
     
     </script>








<form method="post" action="options.php" class="niceform">

    <?php settings_fields( 'fi-settings-group' ); ?>
    <?php //do_settings( 'baw-settings-group' ); ?>
    
         <style type="text/css">
         h2, h3{
          color: #256c89;
          font-size: 150%;
          font-weight: bold;
         }
    .blinded-tr{
<?php if( get_option('fi_blinded_on') != 1){ ?> display:none<?php }?>
}
  </style>    
  


        <table class="form-table">
       

        <tr valign="">

        <th colspan="2">

       <h2><?php _e("Global Settings", 'featured-image-from-external-sources');?></h2>
        
        </th>
        </tr>
      






      


                <tr valign="top">
        <th scope="row"><?php _e("Source of external search", 'featured-image-from-external-sources');?>:<br /> <small><?php _e("Photos will be loaded from this server", 'featured-image-from-external-sources');?></small></th>
      <td><select name="fi_zdroj">
          <option value="seznam"<?php if(get_option('fi_zdroj') == 'seznam'){echo ' selected';} ?>>Seznam.cz</option>
          <option value="yahoo"<?php if(get_option('fi_zdroj') == 'yahoo'){echo ' selected';} ?>>Yahoo.com</option>
          <!-- <option value="unsplash"<?php if(get_option('fi_zdroj') == 'unsplash'){echo ' selected';} ?>>Unsplash.com</option> -->
          <option value="freepik"<?php if(get_option('fi_zdroj') == 'freepik'){echo ' selected';} ?>>Freepik.com</option>
          <option value="google"<?php if(get_option('fi_zdroj') == 'google'){echo ' selected';} ?> disabled>Google.com (not supported)</option>
      </select>

    </td>
        </tr>


                <tr valign="top">
        <th scope="row" colspan="2"><?php _e("Terms of Use", 'featured-image-from-external-sources');?>
           <p class="advice"><img src="<?php echo plugins_url('in-admin-panel/', __FILE__) ?>images/warning.png" />
   <?php _e("WARNING: All images & photos from commercial sources have reserved rights, so don't use them without a valid license! Author of this plugin are not liable for any damages arising from its use.", 'featured-image-from-external-sources');?>
   </p>

</th>
            </tr>

        <tr valign="top">
        <th scope="row" style="color:<?php if( get_option('fi_terms_of_use') == 1){ ?>green<?php }else{?>red<?php }?>;"><?php _e('I Agree this Terms of Use', 'featured-image-from-external-sources');?></th>
        <td><input type="checkbox" name="fi_terms_of_use" value="1" <?php if( get_option('fi_terms_of_use') == 1){ ?> checked<?php }else{ ?>style="border: 2px solid red;"<?php } ?> /></td>
        </tr>




     
     <tr valign="top">
           <th scope="row"></th>
           <td><input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
           </td>
           </tr>


        <tr valign="">

        <th colspan="2">

       <h3><?php _e('Support for the blind users', 'featured-image-from-external-sources');?></h3>
        
        </th>
        </tr>
              <tr valign="">
<td colspan="2">
  <p><?php _e('Never again articles without featured photos. Even for the blind. The plugin allows a blind user to enter a keyword to find a number of thumbnail suggestions and send this selection to the seeing assistant by e-mail. The assistant simply clicks on the best photo directly in the email and the photo is safely matched to the article preview.', 'featured-image-from-external-sources');?></p>
 </td>
        </tr>
      





        <tr valign="top">
        <th scope="row"><?php _e('Turn on blind support', 'featured-image-from-external-sources');?></th>
        <td><input type="checkbox" name="fi_blinded_on" value="1" <?php if( get_option('fi_blinded_on') == 1){ ?> checked<?php } ?> /></td>
        </tr>


        <tr valign="top">
        <th scope="row"></th>
        <td><input type="submit" class="button-primary" value="<?php _e('Save') ?>" <?php if( get_option('fi_blinded_on') == 1){ ?> style="display:none;"<?php } ?> />
</td>
        </tr>


        <tr class="blinded-tr"><td colspan="2"><hr/</tr>
      
          <tr valign="top" class="blinded-tr">
           <th scope="row"><?php _e('Default email', 'featured-image-from-external-sources');?><br /> <small><?php _e('Email for sending draft article previews', 'featured-image-from-external-sources');?>: </strong></small></th>
           <td><input type="text" name="fi_blinded_assistent_email" value="<?php echo get_option('fi_blinded_assistent_email'); ?>" /></td>
           </tr>




      <tr valign="top" class="blinded-tr">
          <td colspan="2"><h3><?php _e('Co-op assistant notifications', 'featured-image-from-external-sources');?></h3></td>
          </tr>
          
 


      <tr valign="top" class="blinded-tr">
          <th scope="row"><?php _e('Email subject', 'featured-image-from-external-sources');?> <br /> <small><?php _e('for an assistant', 'featured-image-from-external-sources');?> :</small></th>
          <td><input type="text" name="fi_email_subject" value="<?php echo get_option('fi_email_subject'); ?>" /></td>
          </tr>
          
 


      <tr valign="top" class="blinded-tr">
          <th scope="row"><?php _e('Email body', 'featured-image-from-external-sources');?><br /> <small><?php _e('for an assistant', 'featured-image-from-external-sources');?>:</small></th>
          <td><textarea id="fi_email_body" name="fi_email_body" rows="4" cols="40" /><?php echo get_option('fi_email_body'); ?></textarea><br/>%%HTMLCONTENT%% - <?php _e('Table of suggested photos', 'featured-image-from-external-sources');?><br/>%%ARTICLE%% - <?php _e('Article title', 'featured-image-from-external-sources');?></td>
          </tr>
          
 
       



      <tr valign="top" class="blinded-tr">
          <td colspan="2"><h3><?php _e('Notification for post author', 'featured-image-from-external-sources');?></h3></td>
          </tr>
          
 


      <tr valign="top" class="blinded-tr">
          <th scope="row"><?php _e('Email Subject <br /> <small> for assistant: </small>', 'featured-image-from-external-sources');?></th>
          <td><input type="text" name="fi_email_notification_subject" value="<?php echo get_option('fi_email_notification_subject'); ?>" /></td>
          </tr>
          
 


      <tr valign="top" class="blinded-tr">
          <th scope="row"><?php _e('Email body <br /> <small> for  assistant: </small>', 'featured-image-from-external-sources');?></th>
          <td><textarea id="fi_email_body" name="fi_email_notification_body" rows="4" cols="40" /><?php echo get_option('fi_email_notification_body'); ?></textarea><br/>%%ARTICLE%% - <?php _e('Article title', 'featured-image-from-external-sources');?><br/></td>
          </tr>
          

     
     
     <tr valign="top" class="blinded-tr">
           <th scope="row"></th>
           <td><input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
           </td>
           </tr>
     
        
    </table>
    

  
  
   
  
</form>
         </div>  
      
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div>
    


</div>
</div>



<div class="modal-lightsout"></div>
<div class="modal-profile">
    <img src="<?php echo plugins_url('in-admin-panel/images/donate/ondrejdadok.jpg', __FILE__) ?>" style="width: auto; height: 270px; float: right; display: inline !important; margin: 30px 0 0 -230px; border-radius: 7px; position: absolute;">

    <h2 style=""><strong><?php _e('I love to develop plugins</strong> to you <strong>for free!</strong>', 'featured-image-from-external-sources');?></h2>
    <?php _e("<p><strong>But if you like this plugin and want to give me some bounty</strong> or you wish to sponsor some specific feature, you're welcome to <strong>send me a donation</strong>. All sponsors are published on the plugin page at the bottom. <strong>Thank you!</strong></p>", 'featured-image-from-external-sources');?>
    
    <a href="#" title="Close donation" class="modal-close-profile"><img src="<?php echo plugins_url('in-admin-panel/images/donate/close.png', __FILE__) ?>" alt="Close donation" /></a>
    
    <a href="#" class="customprice"><?php _e("Custom amount", 'featured-image-from-external-sources');?></a>
    
    <table class="donate-table">
    <tr>
      
      <td>
          <img src="<?php echo plugins_url('in-admin-panel/images/donate/gambrinus.png', __FILE__) ?>">
          <h3>GAMB</h3> <span class="price"><strong>0.5</strong>€</span>
      </td>
      <td>
        <img src="<?php echo plugins_url('in-admin-panel/images/donate/heineken.png', __FILE__) ?>">
        <h3>HEINEKEN</h3> <span class="price"><strong>1.0</strong>€</span>
      </td>
      <td class="current-donate">
        <img src="<?php echo plugins_url('in-admin-panel/images/donate/pilsner12.png', __FILE__) ?>">
        <h3>PLZEŇ</h3> <span class="price"><strong>2.0</strong>€</span>
      </td>
            
      <td>
        <img src="<?php echo plugins_url('in-admin-panel/images/donate/pilsnerandpopcorn.png', __FILE__) ?>">
        <h3>Cool pack</h3> <span class="price"><strong>4.5</strong>€</span>
        </td>
      <td>
        <img src="<?php echo plugins_url('in-admin-panel/images/donate/pilsnerandpopcornandmac.png', __FILE__) ?>">
        <h3>Upgrade pack!</h3> <span class="price"><strong>9.5</strong>€</span>
        </td>
    
          </tr>

          

    </table>
    
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donate_form">
      <input type="hidden" name="cmd" value="_donations">
      <input type="hidden" name="business" value="info@dadok.cz">
      <input type="hidden" name="lc" value="US">
      <input type="hidden" name="item_name" value="Featured thumbnails from Yahoo/Seznam Donation">
      <div id="amount_cont">
      <input type="text" name="amount" value="2.0" id="amount" size="2" maxlength="4"> <span>€</span>
      </div>
      <input type="text" name="item_number" value="First & Last Name, message.." id="name" onclick="this.value=''">
      <input type="hidden" name="no_note" value="0">
      <input type="hidden" name="currency_code" value="EUR">
      <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" id="submit_donate">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    
</div>

<style type="text/css">
  .logo{
    font-size: 200%;
    color: #fff;
    line-height: 120%;
  }
.form-table th,.form-table td{
  color: #000;
  padding: 7px 14px 7px 0 !important;
}
.form-table th small{
  color: #393939;
}

</style>








<?php
include "sponsors.php";

}



