<?php

add_action( 'rest_api_init', 'gold_route');

function gold_route() {           
  register_rest_route( 'my-route/v2', 'gold_ira', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'gold_ira_posts',
  ));      
}

function gold_ira_posts($data) {
  
  $meta[relation] = 'AND';
  if ( isset($_GET['gold_account_type']) && ($_GET['gold_account_type']!= null) ) {   
   $params = array (
      'key' => 'gold_account_type',
      'value' => $data['gold_account_type'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  }
  if (  isset($_GET['gold_account_value']) && ($_GET['gold_account_value']!= null)) {   
    $params = array (
       'key' => 'gold_account_value',
       'value' => $data['gold_account_value'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
   }
  
  $list = new Wp_Query(array(
    'post_type' => 'gold_ira',
    's' => sanitize_text_field( $data['term'] ),
    'p' => $data['id'],
    'title' => $data['title'],
    'content' => $data['content'],
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
      'gold_account_type' => get_field('gold_account_type', $post->id),
      'gold_account_value' => get_field('gold_account_value', $post->id),

    ));
  }
  return $returning_list; 

}