<?php

add_action( 'rest_api_init', 'bitcoin_route');

function bitcoin_route() {           
  register_rest_route( 'my-route/v2', 'bitcoins_ira', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'bitcoin_ira_posts',
  ));      
}

function bitcoin_ira_posts($data) {
  
  $meta[relation] = 'AND';
  if ( isset($_GET['bitcoin_account_type']) && ($_GET['bitcoin_account_type']!= null) ) {   
   $params = array (
      'key' => 'bitcoin_account_type',
      'value' => $data['bitcoin_account_type'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  }
  if (  isset($_GET['bitcoin_account_value']) && ($_GET['bitcoin_account_value']!= null)) {   
    $params = array (
       'key' => 'bitcoin_account_value',
       'value' => $data['bitcoin_account_value'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
   }
  
  $list = new Wp_Query(array(
    'post_type' => 'bitcoins_ira',
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
      'bitcoin_account_type' => get_field('bitcoin_account_type', $post->id),
      'bitcoin_account_value' => get_field('bitcoin_account_value', $post->id),

    ));
  }
  return $returning_list; 

}