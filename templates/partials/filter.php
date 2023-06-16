<div class="wrapper filter_form">
    <?php $aleProperty = new aleProperty(); ?>

    <?php $options = get_option('aleproperty_settings_options');
    
    if(isset($options['filter_title'])){ echo esc_html($options['filter_title']); }
    
    ?>

    <form method="post" action="<?php get_post_type_archive_link('property'); ?>">
        <select name="aleproperty_location">
            <option value="">Select Location</option>
            <?php echo $aleProperty->get_terms_hierarchical('location', $_POST['aleproperty_location']); ?>
        </select>

        <select name="aleproperty_property-type">
            <option value="">Select Type</option>
            <?php echo $aleProperty->get_terms_hierarchical('property-type', $_POST['aleproperty_property-type']); ?>
        </select>

        <input type="text" placeholder="Maximum Price" name="aleproperty_price" value="<?php  if(isset($_POST['aleproperty_price'])){echo esc_attr($_POST['aleproperty_price']);} ?>" />
        <select name="aleproperty_type">
            <option value="">Select Offer</option>
            <option value="sale" <?php if(isset($_POST['aleproperty_type']) and $_POST['aleproperty_type'] == 'sale') { echo 'selected'; } ?>>For Sale</option>
            <option value="rent" <?php if(isset($_POST['aleproperty_type']) and $_POST['aleproperty_type'] == 'rent') { echo 'selected'; } ?>>For Rent</option>
            <option value="sold"  <?php if(isset($_POST['aleproperty_type']) and $_POST['aleproperty_type'] == 'sold') { echo 'selected'; } ?>>Sold</option>
        </select>
        <select name="aleproperty_agent">
            <option value="">Select Agent</option>
            <?php
            $agents = get_posts(array('post_type'=>'agent','numberposts'=>-1));

            $selected = '';
            if(isset($_POST['aleproperty_agent'])){
                $agent_id = $_POST['aleproperty_agent'];
            }

            foreach($agents as $agent){
                echo '<option value="'.$agent->ID.'" '.selected($agent->ID, $agent_id,false).' >'.$agent->post_title.'</option>';
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Filter" />
    </form>
</div>