<?php
add_action( 'rest_api_init', 'business_loans_route');

function business_loans_route() {            
  register_rest_route( 'my-route/v2', 'business_loans', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'business_loans_posts',
  ));      
}
function business_loans_posts($data) {  
  $meta[relation] = 'AND';
  if ( isset($_GET['credit_score']) && ($_GET['credit_score']!= null) ) {   
   $params = array (
      'key' => 'credit_score',
      'value' => $data['credit_score'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  }
  if ( isset($_GET['loan_amount']) && ($_GET['loan_amount']!= null) ) {   
    $params = array (
       'key' => 'loan_amount',
       'value' => $data['loan_amount'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
   }
  
   if ( isset($_GET['business_age']) && ($_GET['business_age']!= null) ) {   
    $params = array (
       'key' => 'business_age',
       'value' => $data['business_age'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
   }
   if ( isset($_GET['monthly_revenue']) && ($_GET['monthly_revenue']!= null) ) {   
    $params = array (
       'key' => 'monthly_revenue',
       'value' => $data['monthly_revenue'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
  }
  $list = new Wp_Query(array(
    'post_type' => 'business_loans',
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
      'credit_score' => get_field('credit_score', $post->id),
      'loan_amount' => get_field('loan_amount', $post->id),
      'business_age' => get_field('business_age', $post->id),
      'monthly_revenue' => get_field('monthly_revenue', $post->id),
    ));
  }
  return $returning_list; 

}