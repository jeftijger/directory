<?php

/**
 * The template for displaying the Checkout page.
 * You can override this file in your active theme.
 * 
 * @package Payments
 * @version 1.0.0 
 * @copyright Incsub 2007-2011 {@link http://incsub.com}
 * @author Ivan Shaovchev (Incsub) {@link http://ivan.sh} 
 * @license GNU General Public License (Version 2 - GPLv2) {@link http://www.gnu.org/licenses/gpl-2.0.html}
 */

$step        = get_query_var('checkout_step') ? get_query_var('checkout_step') : null;
$options     = get_option('module_payments'); 
$text_domain = THEME_TEXT_DOMAIN;  
$plugin_url  = DP_PLUGIN_URL;
$error       = get_query_var('checkout_error'); 

get_header(); ?>

<div id="content"><!-- start #content -->
    <div class="page" id="checkout-page"><!-- start #blog-page -->

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">

            <?php if ( $step == 'disabled' ): ?>

                <?php _e( 'This feature is currently disabled by the system administrator.', $text_domain ); ?>

            <?php elseif ( $step == 'terms' ): ?>

                <form action="" method="post"  class="cf-checkout">
                    <strong><?php _e( 'Cost of Service', $text_domain ); ?></strong>
                    <table <?php do_action( 'billing_invalid' ); ?>>
                        <?php /*
                        <tr>
                            <td><label for="billing"><?php _e( 'Buy Credits', $text_domain ) ?></label></td>
                            <td>
                                <input type="radio" name="billing" value="credits" <?php if ( isset( $_POST['billing_type'] ) && $_POST['billing_type'] == 'credits' ) echo 'checked="checked"'; ?> />
                                <select name="credits_cost">
                                    <?php for ( $i = 1; $i <= 10; $i++ ): ?>
                                    <?php $credits = 10 * $i; ?>
                                    <?php $amount = $credits * ( isset( $options['credits']['cost_credit'] ) ) ? $options['credits']['cost_credit'] : 0; ?>
                                    <option value="<?php echo $amount; ?>" <?php if ( isset( $_POST['credits_cost'] ) && $_POST['credits_cost'] == $amount ) echo 'selected="selected"'; ?> ><?php echo $credits; ?><?php _e( 'Credits for', $text_domain ); ?> <?php echo $amount . ' ' . $options['paypal']['currency']; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                         */ ?>
                        <tr>
                            <td><label for="billing"><?php if ( isset( $options['settings']['recurring_name'] ) ) echo $options['settings']['recurring_name']; ?></label></td>
                            <td>
                                <input type="radio" name="billing_type" value="recurring" <?php if ( isset( $_POST['billing_type'] ) && $_POST['billing_type'] == 'recurring' ) echo 'checked="checked"'; ?> />  
                                <?php 
                                if ( isset(  $options['settings']['recurring_cost'] ) ) 
                                    echo $options['settings']['recurring_cost'] . ' '; 
                                echo $options['paypal']['currency'];  
                                _e( ' per ', $text_domain ); 
                                if ( !empty( $options['settings']['billing_frequency'] ) && $options['settings']['billing_frequency'] != 1 )
                                    echo $options['settings']['billing_frequency'] . ' ';
                                if ( !empty( $options['settings']['billing_period'] ) )
                                    echo $options['settings']['billing_period'];
                                ?>
                                <input type="hidden" name="recurring_cost" value="<?php if ( isset( $options['settings']['recurring_cost'] ) ) echo $options['settings']['recurring_cost']; ?>" />
                                <input type="hidden" name="billing_agreement" value="<?php if ( isset( $options['settings']['billing_agreement'] ) ) echo $options['settings']['billing_agreement']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><label for="billing"><?php if ( isset( $options['settings']['one_time_name'] ) ) echo $options['settings']['one_time_name']; ?></label></td>
                            <td>
                                <input type="radio" name="billing_type" value="one_time" <?php if ( isset( $_POST['billing_type'] ) && $_POST['billing_type'] == 'one_time' ) echo 'checked="checked"'; ?> /> <?php if ( isset( $options['settings']['one_time_cost'] ) ) echo $options['settings']['one_time_cost']; ?> <?php echo $options['paypal']['currency']; ?>
                                <input type="hidden" name="one_time_cost" value="<?php if ( isset( $options['settings']['one_time_cost'] ) ) echo $options['settings']['one_time_cost']; ?>" />
                            </td>
                        </tr>
                    </table>
                    <br />

                    <strong><?php _e( 'Terms of Service', $text_domain ); ?></strong>
                    <table>
                        <tr>
                            <td><div class="terms">
                            <?php 
                            if ( isset( $options['settings']['tos_content'] ) ) 
                                echo nl2br( $options['settings']['tos_content'] ); 
                            ?>
                            </div></td>
                        </tr>
                    </table>
                    <br />

                    <table  <?php do_action( 'tos_invalid' ); ?> >
                        <tr>
                            <td><label for="tos_agree"><?php _e( 'I agree with the Terms of Service', $text_domain ); ?></label></td>
                            <td><input type="checkbox" id="tos_agree" name="tos_agree" value="1" <?php if ( isset( $_POST['tos_agree'] ) ) echo 'checked="checked"'; ?> /></td>
                        </tr>
                    </table>

                    <div class="submit">
                        <input type="submit" name="terms_submit" value="<?php _e( 'Continue', $text_domain ); ?>" />
                    </div>
                </form>

                <form action="" method="post" class="checkout-login">
                    <strong><?php _e( 'Existing client', $text_domain ); ?></strong>
                    <table  <?php do_action( 'login_invalid' ); ?>>
                        <tr>
                            <td><label for="username"><?php _e( 'Username', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="username" name="username" /></td>
                        </tr>
                        <tr>
                            <td><label for="password"><?php _e( 'Password', $text_domain ); ?>:</label></td>
                            <td><input type="password" id="password" name="password" /></td>
                        </tr>
                    </table>

                    <div class="clear"></div>

                    <div class="submit">
                        <input type="submit" name="login_submit" value="<?php _e( 'Continue', $text_domain ); ?>" />
                    </div>
                </form>

                <?php if ( !empty( $error ) ): ?>
                    <div class="invalid-login"><?php echo $error; ?></div>
                <?php endif; ?>

            <?php /* Payment Method Selection */ ?>
            <?php elseif( $step == 'payment_method' ): ?>

                <form action="" method="post"  class="checkout">
                    <strong><?php _e('Choose Payment Method', $text_domain ); ?></strong>
                    <table>
                        <tr>
                            <td><label for="payment_method"><?php _e( 'PayPal', $text_domain ); ?></label></td>
                            <td>
                                <input type="radio" name="payment_method" value="paypal"/>
                                <img  src="https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif" border="0" alt="Acceptance Mark">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="payment_method"><?php _e( 'Credit Card', $text_domain ); ?></label></td>
                            <td>
                                <input type="radio" name="payment_method" value="cc" />
                                <img  src="<?php echo get_template_directory_uri(); ?>/images/cc-logos-small.jpg" border="0" alt="Solution Graphics">
                            </td>
                        </tr>
                    </table>

                    <div class="submit">
                        <input type="submit" name="payment_method_submit" value="<?php _e( 'Continue', $text_domain ); ?>" />
                    </div>
                </form>

            <?php /* Credit Card Details */ ?>
            <?php elseif ( $step == 'cc_details' ): ?>

                <form action="" method="post" class="checkout">
                    <strong><?php _e( 'Payment Details', $text_domain ); ?></strong>
                    <div class="clear"></div>
                    <table>
                        <tr>
                            <td><label for="email"><?php _e( 'Email Adress', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="email" name="email" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="first-name"><?php _e( 'First Name', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="first-name" name="first_name" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="last-name"><?php _e( 'Last Name', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="last-name" name="last_name" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="street"><?php _e( 'Street', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="street" name="street" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="city"><?php _e( 'City', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="city" name="city" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="state"><?php _e( 'State', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="state" name="state" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="zip"><?php _e( 'ZIP', $text_domain ); ?>:</label></td>
                            <td><input type="text" id="zip" name="zip" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="country"><?php _e( 'Country', $text_domain ); ?>:</label></td>
                            <td>
                                <select id="country" name="country_code">
                                    <option value="">Select One</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="">----------</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaidjan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BA">Bosnia-Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="TP">East Timor</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="CS">Former Czechoslovakia</option>
                                    <option value="SU">Former USSR</option>
                                    <option value="FR">France</option>
                                    <option value="FX">France (European Territory)</option>
                                    <option value="GF">French Guyana</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GB">Great Britain</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe (French)</option>
                                    <option value="GU">Guam (USA)</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard and McDonald Islands</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="INT">International</option>
                                    <option value="IR">Iran</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="CI">Ivory Coast (Cote D&#39;Ivoire)</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Laos</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macau</option>
                                    <option value="MK">Macedonia</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique (French)</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia</option>
                                    <option value="MD">Moldavia</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NT">Neutral Zone</option>
                                    <option value="NC">New Caledonia (French)</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="KP">North Korea</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn Island</option>
                                    <option value="PL">Poland</option>
                                    <option value="PF">Polynesia (French)</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Reunion (French)</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="GS">S. Georgia & S. Sandwich Isls.</option>
                                    <option value="SH">Saint Helena</option>
                                    <option value="KN">Saint Kitts & Nevis Anguilla</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="ST">Saint Tome (Sao Tome) and Principe</option>
                                    <option value="VC">Saint Vincent & Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovak Republic</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="KR">South Korea</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syria</option>
                                    <option value="TJ">Tadjikistan</option>
                                    <option value="TW">Taiwan</option>
                                    <option value="TZ">Tanzania</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="MIL">USA Military</option>
                                    <option value="UM">USA Minor Outlying Islands</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VA">Vatican City State</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Vietnam</option>
                                    <option value="VG">Virgin Islands (British)</option>
                                    <option value="VI">Virgin Islands (USA)</option>
                                    <option value="WF">Wallis and Futuna Islands</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="YU">Yugoslavia</option>
                                    <option value="ZR">Zaire</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e( 'Total Amount', $text_domain ); ?>:</td>
                            <td>
                                <strong><?php echo $_POST['cost']; ?> <?php echo $options['paypal']['currency']; ?></strong>
                                <input type="hidden" name="total_amount" value="<?php echo $_POST['cost']; ?>" />
                            </td>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <td><label for="cc_type"><?php _e( 'Credit Card Type', $text_domain ); ?>:</label></td>
                            <td>
                                <select name="cc_type">
                                    <option><?php _e( 'Visa', $text_domain ); ?></option>
                                    <option><?php _e( 'MasterCard', $text_domain ); ?></option>
                                    <option><?php _e( 'Amex', $text_domain ); ?></option>
                                    <option><?php _e( 'Discover', $text_domain ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="cc_number"><?php _e( 'Credit Card Number', $text_domain ); ?>:</label></td>
                            <td><input type="text" name="cc_number" /></td>
                        </tr>
                        <tr>
                            <td><label for="exp_date"><?php _e( 'Expiration Date', $text_domain ); ?>:</label></td>
                            <td><input type="text" name="exp_date" /></td>
                        </tr>
                        <tr>
                            <td><label for="cvv2"><?php _e( 'CVV2', $text_domain ); ?>:</label></td>
                            <td><input type="text" name="cvv2" /></td>
                        </tr>
                    </table>

                    <div class="clear"></div>
                    <div class="submit">
                        <input type="submit" name="direct_payment_submit" value="Continue" />
                    </div>

                </form>

            <?php /* Confirm Payment Step */ ?>
            <?php elseif ( $step == 'confirm_payment' ): ?>

                <?php $transaction_details = get_query_var('checkout_transaction_details'); ?>

                <form action="" method="post" class="checkout">
                    <strong><?php _e( 'Confirm Payment', $text_domain ); ?></strong>
                    <table>
                        <tr>
                            <td><label><?php _e( 'Email Adress', $text_domain ); ?>:</label></td>
                            <td><?php echo $transaction_details['EMAIL']; ?></td>
                        </tr>
                        <tr>
                            <td><label><?php _e( 'Name', $text_domain ); ?>:</label></td>
                            <td><?php echo $transaction_details['FIRSTNAME'] . ' ' . $transaction_details['LASTNAME']; ?></td>
                        </tr>
                        <tr>
                            <td><label><?php _e( 'Address', $text_domain ); ?>:</label></td>
                            <td><?php echo $transaction_details['SHIPTOSTREET']; ?>, <?php echo $transaction_details['SHIPTOCITY']; ?>, <?php echo $transaction_details['SHIPTOSTATE']; ?>, <?php echo $transaction_details['SHIPTOZIP']; ?>, <?php echo $transaction_details['SHIPTOCOUNTRYNAME']; ?></td>
                        </tr>
                        <?php if ( $_SESSION['billing_type'] == 'recurring' ): ?>
                        <tr>
                            <td><label><?php _e( 'Billing Agreement', $text_domain ); ?>:</label></td>
                            <td><?php echo $_SESSION['billing_agreement']; ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td><label><?php _e('Total Amount', $text_domain); ?>:</label></td>
                            <td>
                                <strong><?php if ( isset( $_SESSION['cost'] ) ) echo $_SESSION['cost'] . ' ' . $transaction_details['CURRENCYCODE']; else echo $transaction_details['AMT'] . ' ' . $transaction_details['CURRENCYCODE']; ?></strong>
                                <input type="hidden" name="total_amount" value="<?php if ( isset( $_SESSION['recurring_cost'] ) ) echo $_SESSION['recurring_cost']; else echo $transaction_details['AMT']; ?>" />
                            </td>
                        </tr>
                    </table>

                    <div class="submit">
                        <input type="hidden" name="email" value="<?php echo $transaction_details['EMAIL']; ?>" />
                        <input type="hidden" name="first_name" value="<?php echo $transaction_details['FIRSTNAME']; ?>" />
                        <input type="hidden" name="last_name" value="<?php echo $transaction_details['LASTNAME']; ?>" />
                        <input type="hidden" name="billing_type" value="<?php echo $_SESSION['billing_type']; ?>" />
                        <?php /* <input type="hidden" name="credits" value="<?php echo $_SESSION['credits']; ?>" /> */ ?>
                        <input type="submit" name="confirm_payment_submit" value="Confirm Payment" />
                    </div>

                </form>

            <?php /* API Call Error */ ?>
            <?php elseif ( $step == 'api_call_error' ): ?>

                <?php $error = get_query_var('checkout_error'); ?>

                <ul>
                    <li><?php echo $error['error_call'] . ' API call failed.'; ?></li>
                    <li><?php echo 'Detailed Error Message: ' . $error['error_long_msg']; ?></li>
                    <li><?php echo 'Short Error Message: '    . $error['error_short_msg']; ?></li>
                    <li><?php echo 'Error Code: '             . $error['error_code']; ?></li>
                    <li><?php echo 'Error Severity Code: '    . $error['error_severity_code']; ?></li>
                </ul>

            <?php /* Success */ ?>
            <?php elseif ( $step == 'success' ): ?>

                <div class="dp-submit-txt"><?php _e( 'Thank you for your business. Transaction processed successfully!', $text_domain ); ?></div>
                <span class="dp-submit-txt"><?php _e( 'You can go to your profile and review/change your personal information. You can also go straight to the directory listing submission page.', $text_domain ); ?></span>
                <br /><br />

                <form action="" method="post">
                    <input type="submit" name="redirect_listing" value="Add Listing" />
                </form>
                <form action="" method="post">
                    <input type="submit" name="redirect_profile" value="Go To Profile" />
                </form>

            <?php endif; ?>
            
        </div><!-- #post-## -->

    <?php endwhile; ?>

    </div><!-- end #blog-page -->
</div><!-- end #content -->
<?php get_footer(); ?>
