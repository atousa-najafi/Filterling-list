<?php 
// ------------------------------------------------
// ---------- Creat shortcodes ----------
// ------------------------------------------------
  function filterlist_function($atts) {
    extract( shortcode_atts( array (
        'type' => 'post',      
    ), $atts ) );
    //Load ACF filters based on post type and get post type slug to further use in custom endpoints
    if($type== 'online_banking') { 
        $filters = acf_get_fields('group_60caf6a8d706a');      
        wp_localize_script('affiliate-js','site',array(      
            'post_type_slug'  => 'online_banking'
        ));
    }elseif($type== 'insurance') { 
        $filters = acf_get_fields('group_60c9e52b7dc12');  
        wp_localize_script('affiliate-js','site',array(      
            'post_type_slug'  => 'insurance'
        ));

    }elseif($type== 'bitcoins_ira') { 
        $filters = acf_get_fields('group_60e949987ca10');  
        wp_localize_script('affiliate-js','site', array(
            'post_type_slug'  => 'bitcoins_ira'
        ));  
    }elseif($type== 'gold_ira') { 
        $filters = acf_get_fields('group_60caf59b0ffff');  
        wp_localize_script('affiliate-js','site', array(
            'post_type_slug'  => 'gold_ira'
        ));  
    }elseif($type== 'mortgage_refinance') { 
        $filters = acf_get_fields('group_60caf43dadf15');   
        wp_localize_script('affiliate-js','site',array(      
            'post_type_slug'  => 'mortgage_refinance'
        )); 
    }elseif($type== 'personal_loans') { 
        $filters = acf_get_fields('group_60c9e658821fc');  
        wp_localize_script('affiliate-js','site',array(      
            'post_type_slug'  => 'personal_loans'
        ));
    }elseif($type== 'business_loans') { 
        $filters = acf_get_fields('group_60c9e65f31bff');     
        wp_localize_script('affiliate-js','site', array(      
            'post_type_slug'  => 'business_loans'
        ));
    }else{
    $filters = 'No filter is available for this post';
    }
    

    $content =  "<div class='affiliate-wrapper'>";
    $content .= "<div class='filter-results-title'>Filter Results</div>";
    $content .= "<form action='' method='get' id='affiliate-form'>";
    $content .= "<div class='custom-filters'>";
    //Create wordpress meta_query array
    $items = array();
    $checkboxItems = array();
    $master_items['relation'] = 'AND';
    //loop through ACF fields and create meta_query
    foreach ( $filters as $filter )
    {
        $label = $filter['label'];
        $name = $filter['name'];
        $choices = $filter['choices'];
        $range_min = $filter['min'];
        $range_max = $filter['max'];
        $min =  number_format( $range_min, 0, ',', ',');
        $max =  number_format( $range_max, 0, ',', ',');
        $step = $filter['step'];     
        

        if ( isset($_GET[$name]) && ($_GET[$name]!= null) ) {           
            $items[key] = $name;

            /**************Business Loans************/
            if ($name == 'credit_score'){   
                $items[value] = $_GET[$name];
                $items[type] = 'NUMERIC';
                $items[compare] = "<=";
             }
             elseif ($name == 'loan_amount') {
                $items[value] = $_GET[$name];
                $items[type] = 'NUMERIC';
                $items[compare] = "<=";                 
             }
             elseif($name == 'business_age') {
                $items[value] = $_GET[$name];
                $items[type] = 'NUMERIC';
                $items[compare] = "<=";
             }
             elseif($name == 'monthly_revenue') {
                $items[type] = 'NUMERIC';
                $items[value] = $_GET[$name];
                $items[compare] = "<=";
             }
              /**************Personal Loans************/
                elseif ($name == 'loan_purpose_pr'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                elseif ($name == 'credit_score_pr'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                elseif($name == 'loan_amount_pr') {
                    $items[type] = 'NUMERIC';
                    $items[value] = $_GET[$name];
                    $items[compare] = "<=";
                }
              /************** Mortgage Refinance************/
                elseif ($name == 'mo_credit_score'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
              /**************Gold IRA************/
                elseif ($name == 'gold_account_type'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                elseif($name == 'gold_account_value') {
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                 /**************Bitcoin IRA************/
                 elseif ($name == 'bitcoin_account_type'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                elseif($name == 'bitcoin_account_value') {
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
              /**************Insurance************/
                elseif ($name == 'policy_term'){   
                    $items[value] = $_GET[$name];
                    $items[type] = 'NUMERIC';
                    $items[compare] = "<=";
                }
                elseif($name == 'coverage_amount') {
                    $items[type] = 'NUMERIC';
                    $items[value] = $_GET[$name];
                    $items[compare] = "<=";
                }
            /************** Online Banking************/
             elseif ($name == 'purpose'){   
                $items[value] = $_GET[$name];
                //$items[type] = 'NUMERIC';
                $items[compare] = "=";
             }
             elseif ($name == 'online_account_types'){ 
                $types = $_GET[$name];
                foreach( $types as $i => $type ){
                    $types[$i] = '"' . $type . '"';
                }
                 
                $items[key] = $name;
                $items[value] = implode('|', $types);
                $items[compare] = 'REGEXP';
             }
            else{            
                $items[value] = $_GET[$name];
                $items[compare] = "=";
            }          
            array_push($master_items, $items);
        }        
        $content .= "<div>";
        $content .= "<div class='filter-title'>$label</div>";
        //Check the fields type and create proper HTML on frontend
         if(($filter['type'] == 'select') && ($name !== 'online_account_types')) {
            $content .= "<select name='$name' id='$name' class='affiliate-opt'>";
            foreach( $choices as $key => $value ) { 
                $the_selected = '';
                if ($_GET[$name] == $key) {
                    $the_selected = 'selected';
                }
                 $content .= "<option value='$key' $the_selected>$value</option> ";
            }
             $content .= "</select>";  
             $content .= "<div class='val'></div>";
             $content .= "<div class='name'></div>";
             $content .= "<div class='test2'></div>";
        } 
        if ($filter['type'] == 'range'){
            $the_default_value = '';
            if ( isset($_GET[$name]) ) {
                $the_default_value = $_GET[$name];
            } 
            else {
                $the_default_value = $filter['default_value'];
            }            
            $content .= '<div class="range-wrap"><input type="range" name ="'.$name.'" min="'.$range_min.'"  step="'.$step.'" max="'.$range_max.'" value="'. $the_default_value .'" id="'.$name.'" class="range-slider"><div id="range-slider-value">'. $_GET[$name].'</div></div>';
            $content .= '<div class="all-ranges"><span class"range-min">$'.$min.'</span><span class"range-max">$'.$max.'</span></div>';
        }
        if( ($filter['type'] == 'select') && ($name == 'online_account_types')) {

            foreach( $choices as $key => $value ) { 
                
                if(!empty($_GET[$name])) {
                    $the_checked = '';
                    foreach($_GET[$name] as $names){
                        if ($names == $key) {
                            $the_checked = 'checked';
                        }
                    }        
                }          
                $content .= "<div class='checkbox-div'><label class='checkbox-label'><input class='mycheckbox' type='checkbox' name='$name" . "[]" . "' value='$key' $the_checked> $value</label></div>";    
                
            }        
        } 
        $content .= "</div>" ;
    } 
    $content .= "</div>";
    $content .= "<div class='form-btns'>";
    $content .= "<span id='clear-list'>Remove Filters</span>";
    $content .= "<input type='submit' name='SubmitButton' class='filter-btn' id='submit-filter'/>";
    $content .= "</div>";
    $content .= "</form>";

    //Find shortcode attributes, in this case we only have 'type' attribute
    //Use meta_qury array which built earlier
    $options = array(
        'post_type' => $atts['type'],    
        'meta_query' => $master_items,
    );
	// update meta query
    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { 
        $upload_dir = site_url();
        $content .="<link rel='stylesheet' id='tcb-style-base-thrive_template-7382' href='$upload_dir/wp-content/uploads/thrive/tcb-base-css-7382-1623525522.css' type='text/css' media='all'>";
        $content .= "<div class='show-post'>";
        while ( $query->have_posts() ) {
            $query->the_post(); 
            $mycont =  tve_editor_content(get_the_content(), 'tcb_content' );
            $content .= $mycont;
            $custom_css = trim( tve_get_post_meta( get_the_ID(), 'tve_custom_css', true ) . tve_get_post_meta( get_the_ID(), 'tve_user_custom_css', true ) );
            $content .= '<style>';
            $content .= $custom_css;
            $content .='</style>';
              
            }
           
         $content .= "</div>";  
                 
    } 
    else{
        $content .= "<div>No content matches the filters!</div>";
    }

    $content .= "</div>";
    wp_reset_query();
    return $content;

    
 } 
 function register_affiliate_list_shortcodes(){
	add_shortcode('filterlist', 'filterlist_function');  
 }      
 add_action( 'init', 'register_affiliate_list_shortcodes');
