<?php
add_action( 'rest_api_init', 'online_banking_route');

function online_banking_route() {            
  register_rest_route( 'my-route/v2', 'online_banking', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'online_banking_posts',
  ));      
}

function online_banking_posts($data) {
  $meta[relation] = 'AND';
  if ( isset($_GET['purpose']) && ($_GET['purpose']!= null) ) {   
      $params = array (
      'key' => 'purpose',
      'value' => $data['purpose'],
      'type' => 'NUMERIC',
       'compare' => '='
   );    
  array_push($meta,$params);
  }
  if (  isset($_GET['online_account_types']) && ($_GET['online_account_types']!= null)) {   
    $types = $_GET['online_account_types'];
    foreach( $types as $i => $type ){
        $types[$i] = '"' . $type . '"';
    }
        $params = array (
          'key' => 'online_account_types',
          'value' =>  implode('|', $types),
          'compare' => 'REGEXP'
        );      
   array_push($meta,$params);
  }
  
  $list = new Wp_Query(array(
    'post_type' => 'online_banking',
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
      'purpose' => get_field('purpose', $post->id),
      'online_account_types' => get_field('online_account_types', $post->id),
    ));
  }
  wp_reset_query();
  return $returning_list; 

}