<?php
// require_once(__DIR__ . "../../../lib/functions.php");
require(__DIR__ . "/../../partials/nav.php");

$query = "SELECT cart.item_id, cart.id, item.stock, item.name, cart.unit_price, (cart.unit_price * cart.desired_quantity) as subtotal, cart.desired_quantity
FROM RM_Items as item JOIN RM_Cart_Alt as cart on item.id = cart.item_id
 WHERE cart.user_id = :uid";
$db = getDB();
$stmt = $db->prepare($query);
$cart = [];
try {
    $stmt->execute([":uid" => get_user_id()]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        $cart = $results;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error fetching cart", "danger");
}
?>
<!-- hide nav bar for checkout page -->
<script>
    $(document).ready(function() {
        $("nav").css("display", "none");
    });
</script>
<div class="content">
    <div class="wrap">
        <div class="left_main">
            <div class="checkout_form">
                <form autocomplete="off">
                    <div>
                        <div class="section__header">
                            <h2 class="section__title" id="section-delivery-title">
                                Shipping address
                            </h2>
                        </div>
                        <div class="section__content">
                            <div class="fieldset">
                                <div>
                                    <div class="field">
                                        <div>
                                            <label>Country/region</label>
                                            <select size="1" class="field__input" placeholder="Country/region">
                                                <option selected="selected" value="United States">United States</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Canada">Canada</option>
                                                <option disabled="disabled" value="---">---</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Virgin Islands, British">British Virgin Islands</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Chile">Chile</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Peru">Peru</option>
                                                <option value="United States Minor Outlying Islands">U.S. Outlying Islands</option>
                                                <option value="United States">United States</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_first_name">First name</label>
                                            <input class="field__input" aria-required="true" size="30" type="text" placeholder="First name" name="checkout_[shipping_adress][first_name]" id="checkout_shipping_address_first_name">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_last_name">Last name</label>
                                            <input class="field__input" placeholder="Last name" aria-required="true" size="30" type="text" name="checkout[shipping_address][last_name]" id="checkout_shipping_address_last_name">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_address1">Address</label>
                                            <input class="field__input" placeholder="Address" autocomplete="shipping address-line1" autocorrect="off" size="30" type="text" name="checkout[shipping_address][address1]" id="checkout_shipping_address_address1">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_address2">Apartment, suite, etc. (optional)</label>
                                            <input class="field__input" placeholder="Apartment, suite, etc. (optional)" size="30" type="text" name="checkout[shipping_address][address2]" id="checkout_shipping_address_address2">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_city">City</label>
                                            <input placeholder="City" autocorrect="off" class="field__input" size="30" type="text" name="checkout[shipping_address][city]" id="checkout_shipping_address_city">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_province">State</label>
                                            <select placeholder="State" class="field__input" name="checkout[shipping_address][province]" id="checkout_shipping_address_province">
                                                <option disabled="">State</option>
                                                <option data-alternate-values="[&quot;Alabama&quot;]" value="AL">Alabama</option>
                                                <option data-alternate-values="[&quot;Alaska&quot;]" value="AK">Alaska</option>
                                                <option data-alternate-values="[&quot;American Samoa&quot;]" value="AS">American Samoa</option>
                                                <option data-alternate-values="[&quot;Arizona&quot;]" value="AZ">Arizona</option>
                                                <option data-alternate-values="[&quot;Arkansas&quot;]" value="AR">Arkansas</option>
                                                <option data-alternate-values="[&quot;California&quot;]" value="CA">California</option>
                                                <option data-alternate-values="[&quot;Colorado&quot;]" value="CO">Colorado</option>
                                                <option data-alternate-values="[&quot;Connecticut&quot;]" value="CT">Connecticut</option>
                                                <option data-alternate-values="[&quot;Delaware&quot;]" value="DE">Delaware</option>
                                                <option data-alternate-values="[&quot;Florida&quot;]" value="FL">Florida</option>
                                                <option data-alternate-values="[&quot;Georgia&quot;]" value="GA">Georgia</option>
                                                <option data-alternate-values="[&quot;Guam&quot;]" value="GU">Guam</option>
                                                <option data-alternate-values="[&quot;Hawaii&quot;]" value="HI">Hawaii</option>
                                                <option data-alternate-values="[&quot;Idaho&quot;]" value="ID">Idaho</option>
                                                <option data-alternate-values="[&quot;Illinois&quot;]" value="IL">Illinois</option>
                                                <option data-alternate-values="[&quot;Indiana&quot;]" value="IN">Indiana</option>
                                                <option data-alternate-values="[&quot;Iowa&quot;]" value="IA">Iowa</option>
                                                <option data-alternate-values="[&quot;Kansas&quot;]" value="KS">Kansas</option>
                                                <option data-alternate-values="[&quot;Kentucky&quot;]" value="KY">Kentucky</option>
                                                <option data-alternate-values="[&quot;Louisiana&quot;]" value="LA">Louisiana</option>
                                                <option data-alternate-values="[&quot;Maine&quot;]" value="ME">Maine</option>
                                                <option data-alternate-values="[&quot;Marshall Islands&quot;]" value="MH">Marshall Islands</option>
                                                <option data-alternate-values="[&quot;Maryland&quot;]" value="MD">Maryland</option>
                                                <option data-alternate-values="[&quot;Massachusetts&quot;]" value="MA">Massachusetts</option>
                                                <option data-alternate-values="[&quot;Michigan&quot;]" value="MI">Michigan</option>
                                                <option data-alternate-values="[&quot;Federated States of Micronesia&quot;]" value="FM">Micronesia</option>
                                                <option data-alternate-values="[&quot;Minnesota&quot;]" value="MN">Minnesota</option>
                                                <option data-alternate-values="[&quot;Mississippi&quot;]" value="MS">Mississippi</option>
                                                <option data-alternate-values="[&quot;Missouri&quot;]" value="MO">Missouri</option>
                                                <option data-alternate-values="[&quot;Montana&quot;]" value="MT">Montana</option>
                                                <option data-alternate-values="[&quot;Nebraska&quot;]" value="NE">Nebraska</option>
                                                <option data-alternate-values="[&quot;Nevada&quot;]" value="NV">Nevada</option>
                                                <option data-alternate-values="[&quot;New Hampshire&quot;]" value="NH">New Hampshire</option>
                                                <option data-alternate-values="[&quot;New Jersey&quot;]" value="NJ">New Jersey</option>
                                                <option data-alternate-values="[&quot;New Mexico&quot;]" value="NM">New Mexico</option>
                                                <option data-alternate-values="[&quot;New York&quot;]" value="NY">New York</option>
                                                <option data-alternate-values="[&quot;North Carolina&quot;]" value="NC">North Carolina</option>
                                                <option data-alternate-values="[&quot;North Dakota&quot;]" value="ND">North Dakota</option>
                                                <option data-alternate-values="[&quot;Northern Mariana Islands&quot;]" value="MP">Northern Mariana Islands</option>
                                                <option data-alternate-values="[&quot;Ohio&quot;]" value="OH">Ohio</option>
                                                <option data-alternate-values="[&quot;Oklahoma&quot;]" value="OK">Oklahoma</option>
                                                <option data-alternate-values="[&quot;Oregon&quot;]" value="OR">Oregon</option>
                                                <option data-alternate-values="[&quot;Palau&quot;]" value="PW">Palau</option>
                                                <option data-alternate-values="[&quot;Pennsylvania&quot;]" value="PA">Pennsylvania</option>
                                                <option data-alternate-values="[&quot;Puerto Rico&quot;]" value="PR">Puerto Rico</option>
                                                <option data-alternate-values="[&quot;Rhode Island&quot;]" value="RI">Rhode Island</option>
                                                <option data-alternate-values="[&quot;South Carolina&quot;]" value="SC">South Carolina</option>
                                                <option data-alternate-values="[&quot;South Dakota&quot;]" value="SD">South Dakota</option>
                                                <option data-alternate-values="[&quot;Tennessee&quot;]" value="TN">Tennessee</option>
                                                <option data-alternate-values="[&quot;Texas&quot;]" value="TX">Texas</option>
                                                <option data-alternate-values="[&quot;Virgin Islands&quot;]" value="VI">U.S. Virgin Islands</option>
                                                <option data-alternate-values="[&quot;Utah&quot;]" value="UT">Utah</option>
                                                <option data-alternate-values="[&quot;Vermont&quot;]" value="VT">Vermont</option>
                                                <option data-alternate-values="[&quot;Virginia&quot;]" value="VA">Virginia</option>
                                                <option data-alternate-values="[&quot;Washington&quot;]" value="WA">Washington</option>
                                                <option data-alternate-values="[&quot;District of Columbia&quot;]" value="DC">Washington DC</option>
                                                <option data-alternate-values="[&quot;West Virginia&quot;]" value="WV">West Virginia</option>
                                                <option data-alternate-values="[&quot;Wisconsin&quot;]" value="WI">Wisconsin</option>
                                                <option data-alternate-values="[&quot;Wyoming&quot;]" value="WY">Wyoming</option>
                                                <option data-alternate-values="[&quot;Armed Forces Americas&quot;]" value="AA">Armed Forces Americas</option>
                                                <option data-alternate-values="[&quot;Armed Forces Europe&quot;]" value="AE">Armed Forces Europe</option>
                                                <option data-alternate-values="[&quot;Armed Forces Pacific&quot;]" value="AP">Armed Forces Pacific</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_zip">ZIP code</label>
                                            <input placeholder="ZIP code" autocomplete="shipping postal-code" autocorrect="off" data-backup="zip" data-autocomplete-trigger="true" data-autocomplete-title="Suggestions" data-autocomplete-single-item="1 item available" data-autocomplete-multi-item="{{number}} items available" data-autocomplete-item-selection="{{number}} of {{total}}" data-autocomplete-close="Close suggestions" class="field__input field__input--zip" aria-required="true" size="30" type="text" name="checkout[shipping_address][zip]" id="checkout_shipping_address_zip">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div>
                                            <label for="checkout_shipping_address_phone">Phone</label>
                                            <input placeholder="Phone" autocorrect="off" class="field__input" size="30" type="tel" name="checkout[shipping_address][phone]" id="checkout_shipping_address_phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step__footer">
                        <button name="button" type="submit" id="continue_button" class="btn">Continue to Payment</button>
                        <a class="step__footer__previous-link" href="cart_alt.php">
                            <span class="step__footer__previous-link-content">Return to cart</span></a>
                    </div>
                </form>
            </div>
        </div>
        <aside class="sidebar">
            <div class="section__header">
                <h2>
                    Cart
                </h2>
            </div>
            <table class="table">
                <?php $total = 0; ?>
                <tbody>
                    <?php foreach ($cart as $c) : ?>
                        <tr>
                            <td class='item_name'> <a href="product_page.php?id=<?php se($c, "item_id"); ?>" target=_blank><?php se($c, "name"); ?></a></td>
                            <td class='cost'>$<?php se($c, "subtotal"); ?></td>
                            <?php $total += (int)se($c, "subtotal", 0, false); ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr id='total'>
                        <td class='item_name' style='text-align:start'>Total:</td>
                        <td id='total_cost'>$<?php se($total, null, 0); ?></td>
                    </tr>
                </tbody>
            </table>
        </aside>
    </div>
</div>
<style>
    body {
        background-image: url(https://images.unsplash.com/photo-1501127122-f385ca6ddd9d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format);
        backdrop-filter: blur(7px);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

    }

    body {
        background-color: #26272b;
        padding: 0;
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #fff;
    }

    .section__header {
        color: #fff;
    }

    .content {
        background: rgba(0, 0, 0, 0.8);
        height: 100%;
        display: flex;
        flex: 1 0 auto;
    }

    .wrap {
        display: flex;
        flex-direction: row;
        flex: 1 0 auto;
        z-index: 1;
        margin: 100px auto;
        width: 90%;
        max-width: 1200px;
    }

    .left_main {
        display: flex;
        flex-direction: column;
        flex: 1 0 auto;
        float: left;
        width: 52%;
        padding-right: 4%;
        border-right: .5px solid #fff;
    }

    .sidebar {
        padding-top: 20px;
        width: 38%;
        padding-left: 6%;
        float: right;
        background-position: left top;

    }

    .item_name {
        text-align: start;
    }

    .cost {
        text-align: end;
    }

    table {
        margin: 0 auto;
        border: none;
        height: 60%;
        overflow: scroll;
    }

    tr {
        color: white;
        border: none;
        height: 10%;
    }

    td {
        border: none;
    }

    #total {
        border-top: 1px solid white;
    }

    #total td {
        font-weight: bold;
        font-size: 1.5em;
        text-align: end;
    }

    .checkout_form {
        z-index: 1;
        height: 100%;
        width: 100%;
    }

    form {
        margin: 0 auto;
        width: 100%;
        background: inherit;
        color: rgb(212, 212, 213);
        display: block;
        font-size: 14px;
        line-height: 18.2px;
        overflow-wrap: break-word;
        box-shadow: none;
    }

    label {
        color: rgb(177, 177, 179);
        font-size: 12px;
        font-weight: 400;
        margin: 5px 0;
        position: absolute;
        text-align: start;
        padding-top: 9px;
        padding-left: 10px;
        line-height: 18.2px;
        width: fit-content;
    }

    .field__input {
        margin: 10px 0;
        color: white;
        padding-top: 1.5em;
        padding-bottom: 0.35em;
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px #515255 solid;
        border-radius: 5px;
        line-height: 19px;
    }

    select {
        padding-left: 5px;
    }
</style>