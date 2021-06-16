<?php 
// Include Modal on History Page
add_action('give_after_recurring_history', 'gr_cancel_reason_modal' );

function gr_cancel_reason_modal(){
    give_get_template_part('cancel', 'confirmation-modal' );
}
// Process Cancel Subscription
add_action('give_cancel_subscription_with_reason', 'gr_process_cancellation');

function gr_process_cancellation( $postdata ){
    // Return If Id Empty 
    if( empty( $postdata['subscription_id'] ) ){
        return;
    }
    /**
     *  Return If 
     * user Not logged In
     * user has no active donation session
     * email access is not enabled
     */  
    if( !is_user_logged_in() && Give_Recurring()->subscriber_has_email_access() == false  && ! give_get_purchase_session() ){
        return;
    }
    // Change to Absolute Integer Number 
    $postdata['subscription_id'] = absint( $postdata['subscription_id'] );

    // Get Reason Of Cancelling The Subscription
    $cancel_reason = $postdata['give_cancel_reason'];
    // Get Custom Reason 
    if( $cancel_reason == 'other' ){
        $cancel_reason = $postdata['give_other_cancel_reason'];
    }

    // Verify Nonce for Security

    if ( ! wp_verify_nonce( $postdata['_wpnonce_cancel_subscription'], "cancel_subscription_with_reason" ) ) {
        wp_die( __( 'Nonce verification failed.', 'cancel-subscription' ), __( 'Error', 'cancel-subscription' ), [ 'response' => 403 ] );
    }

    // Access Give_Subscription Class
    $subscription = new Give_Subscription( $postdata['subscription_id'] );

    try {

        do_action( 'before_cancel_subscription',  $subscription );
        
        $subscription->cancel();
        // Add Reason in Subscription and Donation Note
        $notes = sprintf( '<strong>%1$s: </strong>%2$s',
            __('Subscription cancel reason', 'cancel-subscription'),
            $cancel_reason
        );
        $subscription->add_note( $notes );
        $subscription->donor->add_note( $notes );

        if ( is_admin() ) {

            wp_redirect( admin_url( 'edit.php?post_type=give_forms&page=give-subscriptions&give-message=cancelled&id=' . $subscription->id ) );
            exit;

        } else {

            $args = ! give_get_errors() ? [ 'give-message' => 'cancelled' ] : [];

            wp_redirect(
                remove_query_arg(
                    [
                        '_wpnonce',
                        'give_action',
                        'subscription_id',
                    ],
                    add_query_arg( $args )
                )
            );

            exit;

        }

    } catch ( Exception $e ) {
        wp_die( $e->getMessage(), __( 'Error', 'cancel-subscription' ), [ 'response' => 403 ] );
    }
    print_r( $subscription_id );
    exit;
}
