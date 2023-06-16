<?php
get_header(); ?>

<div class="wrapper single_books-portal">
    <?php 
    
    if ( have_posts() ) {

        // Load posts loop.
        while ( have_posts() ) {
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if(get_the_post_thumbnail(get_the_ID(),'large')) {
                    echo get_the_post_thumbnail(get_the_ID(),'large');
                } ?>


                <?php 

                //Price
                $price = esc_html(get_post_meta(get_the_ID(),'aleproperty_price', true));
                
                //Location
                $ale_location = '';
                $locations = get_the_terms(get_the_ID(),'location');

                foreach($locations as $location){
                    $ale_location.= " ".$location->name;
                }

                //Agents
                $agent_id = get_post_meta(get_the_ID(),'aleproperty_agent', true);
                $agent = get_post($agent_id);
                
                
                echo do_shortcode('[aleproperty_booking agent="'.esc_html($agent->post_title).'" location="'.esc_html($ale_location).'" price="'.esc_html($price).'"]'); ?>


                <h2><?php the_title(); ?></h2>
                <div class="description"><?php the_content(); ?></div>
                <div class="property_info">
                    <span class="location"><?php esc_html_e('Location:','aleproperty'); 
                    
                    echo esc_html($ale_location);

                    ?> </span>
                    <span class="type"><?php esc_html_e('Type:','aleproperty'); 
                    $types = get_the_terms(get_the_ID(),'property-type');

                    foreach($types as $type){
                        echo " ".esc_html($type->name);
                    }
                    ?> </span>

                    <span class="price"><?php esc_html_e('Price:','aleproperty'); echo ' '.$price;?> </span>

                    <span class="offer"><?php esc_html_e('Offer:','aleproperty'); echo ' '.esc_html(get_post_meta(get_the_ID(),'aleproperty_type', true));?> </span>
                    <span class="agent"><?php esc_html_e('Agent:','aleproperty'); 
                    
                    echo " ".esc_html($agent->post_title);
                    ?> </span>
                </div>

            </article>
        <?php }
    
    
    } 
    ?>
</div>

<?php
get_footer();