<?php global $wpalchemy_media_access,$wpdb; ?>
<?php
$all_locations = $wpdb->get_col("SELECT meta_value
    FROM $wpdb->postmeta WHERE meta_key = '_date_event_location'" );
    $location_values = array_unique($all_locations);
    asort($location_values);
    ?>
<div class="meta_control">
    <div class="table">
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_start_datestamp'); ?>
                <input type="hidden" class="start_datestamp datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <label>Event Start</label>
                <?php $metabox->the_field('event_start_date'); ?>
                <input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_end_datestamp'); ?>
                <input type="hidden" class="end_datestamp datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <label>Event End</label>
                <?php $metabox->the_field('event_end_date'); ?>
                <input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($){
    $( ".datepicker" ).datepicker({
    onSelect : function(dateText, inst)
    {
        var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
        $(this).parents('.cell').find('.datestamp').val(epoch);
    }
    });
});

</script>