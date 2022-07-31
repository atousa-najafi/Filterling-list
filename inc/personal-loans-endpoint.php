<?php
add_action( 'rest_api_init', 'personal_loans_route');

function personal_loans_route() {            
  register_rest_route( 'my-route/v2', 'personal_loans', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'personal_loans_posts',
  ));
      
}
function personal_loans_posts($data) {  
  $meta[relation] = 'AND';
  if ( isset($_GET['loan_purpose_pr']) && ($_GET['loan_purpose_pr']!= null) ) {   
   $params = array (
      'key' => 'loan_purpose_pr',
      'value' => $data['loan_purpose_pr'],
      'type' => 'NUMERIC',
       'compare' => '<='
   );    
  array_push($meta,$params);
  }
  if ( isset($_GET['credit_score_pr']) && ($_GET['credit_score_pr']!= null) ) {   
    $params = array (
       'key' => 'credit_score_pr',
       'value' => $data['credit_score_pr'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
  } 
  if ( isset($_GET['loan_amount_pr']) && ($_GET['loan_amount_pr']!= null) ) {   
    $params = array (
       'key' => 'loan_amount_pr',
       'value' => $data['loan_amount_pr'],
       'type' => 'NUMERIC',
        'compare' => '<='
    );    
   array_push($meta,$params);
  }
  $list = new Wp_Query(array(
    'post_type' => 'personal_loans',
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
      'loan_purpose_pr' => get_field('loan_purpose_pr', $post->id),
      'credit_score_pr' => get_field('credit_score_pr', $post->id),
      'loan_amount_pr' => get_field('loan_amount_pr', $post->id),

    ));
  }
  return $returning_list; 

}