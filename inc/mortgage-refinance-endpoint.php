<?php
add_action( 'rest_api_init', 'mortgage_route');

function mortgage_route() {            
  register_rest_route( 'my-route/v2', 'mortgage_refinance', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'mortgage_posts',
  ));              
}
function mortgage_posts($data) {
  
  $meta = array();
  if ( isset($_GET['mo_credit_score']) && ($_GET['mo_credit_score']!= null) ) {   
   $params = array (
      'key' => 'mo_credit_score',
      'value' => $data['mo_credit_score'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  } 
  $list = new Wp_Query(array(
    'post_type' => 'mortgage_refinance',
    's' => sanitize_text_field( $data['term'] ),
    'p' => $data['id'],
    'title' => $data['title'],
    'meta_query' => $meta    
  ));  
  $returning_list = array();
  while($list->have_posts()){
    $list->the_post();
    $correctContent = tve_editor_content(get_the_content(), 'tcb_content' );
    $correctContent .= '<style>';
    $correctContent .= trim( tve_get_post_meta( get_the_ID(), 'tve_custom_css', true ) . tve_get_post_meta( get_the_ID(), 'tve_user_custom_css', true ) );
    $correctContent .= '</style>';
    array_push($returning_list,array(
      'id' => get_the_id(),
      'title' => get_the_title(),
      'content' => $correctContent,
      'mo_credit_score' => get_field('mo_credit_score', $post->id)
    ));
  }
  return $returning_list; 

}