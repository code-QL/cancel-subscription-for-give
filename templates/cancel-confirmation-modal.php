<?php 
/**
 * Give - Cancel Reccuring Donation Modal Template
 * @package give-recurring
 * @subpackage give-recurring-cancellation
 * @since 0.0.1
 */

// Modal Container Initialize
 ?>
 <div class="gr-cancel-subscription-modal fade">
    <div class="gr-modal-container">
        <div class="gr-cancel-subscription-content">
            <span class="gr-close-confirm-modal">&times;</span>
            <div class="gr-cancel-subscription-head">
                <?php do_action('gr_before_confirm_cancel_title_text'); ?>
                <h2 class="gr-title"> <?php echo apply_filters( 'gr_confirm_cancel_title_text', __('Please confirm your cancellation', 'cancel-subscription' ) ); ?></h2>
                <?php do_action('gr_after_confirm_cancel_title_text'); ?>
            </div>
            <?php do_action('gr_bofore_confirm_cancel_body'); ?>
            <div class="gr-cancel-subscription-body">
                <p class="gr-subtitle">
                    <?php 
                        $cancel_subtitle = __('Please tell us why you are cancelling', 'cancel-subscription');
                        echo apply_filters('gr_confirm_cancel_subtitle_text', $cancel_subtitle );
                    ?>
                </p>
                <?php 
                    $cancel_reasons = array(
                        __('My financial circumstances have changed', 'cancel-subscription'),
                        __('I\'ve changed my giving options', 'cancel-subscription' ),
                        __('The OM worker/project no longer needs my support', 'cancel-subscription'),
                        __('I\'m changing the amount', 'cancel-subscription')             
                    );
                    $cancel_reasons = apply_filters('give_cancel_subscription_reasons', $cancel_reasons );
                ?>
                <form action="<?php the_permalink() ?>" method="post" class="gr-cancel-subscription-form">
                    <input type="hidden" name="subscription_id" value="0" id="gr-subscription-id"/>
                    <input type="hidden" name="give_action" value="cancel_subscription_with_reason" />
                    <?php wp_nonce_field('cancel_subscription_with_reason', '_wpnonce_cancel_subscription'); ?>
                    <div class="gr-form-group">
                        <select name="give_cancel_reasons" class="give_cancel_reasons gr-form-field">
                            <?php 
                                foreach( $cancel_reasons as $cancel_reason ):
                                    ?>
                                        <option value="<?php echo $cancel_reason ?>"><?php echo $cancel_reason ?></option>
                                    <?php 
                                endforeach;
                            ?>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="gr-form-group gr-other-reason gr-hide">
                        <textarea rows="3" columns="10" placeholder="Write here..." class="gr-form-field gr-other-reason" name="give_other_cancel_reason"></textarea> 
                    </div>
                    <div class="gr-form-group">
                        <?php do_action('gr_before_confirm_cancel_subscription_button'); ?>
                        <button class="give-confirm-cancel-subscription give-form-button gr-button"><?php echo apply_filters('cancel_subscription_confirm_button_text', __('Confirm Cancellation', 'cancel-subscription') );?></button>      
                        <?php do_action('gr_after_confirm_cancel_subscription_button'); ?>
                    </div>
                </form>
            </div>
            <?php do_action('gr_after_confirm_cancel_body'); ?>
        </div>
    </div>
 </div>


