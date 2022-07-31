<?php
add_action( 'rest_api_init', 'insurance_route');

function insurance_route() {            
  register_rest_route( 'my-route/v2', 'insurance', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'insurance_posts',
  ));
           
}
function insurance_posts($data) {
  
  $meta[relation] = 'AND';
  if ( isset($_GET['policy_term']) && ($_GET['policy_term']!= null) ) {   
   $params = array (
      'key' => 'policy_term',
      'value' => $data['policy_term'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  }
  if ( isset($_GET['coverage_amount']) && ($_GET['coverage_amount']!= null) ) {   
    $params = array (
       'key' => 'coverage_amount',
       'value' => $data['coverage_amount'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
  }  
  $list = new Wp_Query(array(
    'post_type' => 'insurance',
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
      'policy_term' => get_field('policy_term', $post->id),
      'coverage_amount' => get_field('coverage_amount', $post->id),

    ));
  }
  return $returning_list; 

}