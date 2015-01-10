<div class="wrap">
    <h2><?php _e('Checkout form setup', $this->car_share) ?></h2>    
    <form action="<?php echo admin_url('admin.php') ?>?page=checkout-form-setup" method="post">
        <table class="form-table">
            <tbody>
                <?php foreach ($this->checkout_inputs as $input_key => $input_label): ?>    
                    <tr>
                        <th>
                            <?php _e($input_label, $this->car_share) ?>
                        </th>
                        <td>
                            <label><input type="checkbox" value="1" name="billing_inputs[<?php echo $input_key ?>][enabled]" <?php echo isset($input_options[$input_key]['enabled']) && 1 == $input_options[$input_key]['enabled'] ? ' checked="checked" ' : '' ?>> <?php _e('Enabled', $this->car_share) ?></label><br>
                            <label><input type="checkbox" value="1" name="billing_inputs[<?php echo $input_key ?>][required]" <?php echo isset($input_options[$input_key]['required']) && 1 == $input_options[$input_key]['required'] ? ' checked="checked" ' : '' ?>> <?php _e('Required', $this->car_share) ?></label>
                        </td>
                    </tr>    
                <?php endforeach; ?>    
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="button button-primary button-hero load-customize hide-if-no-customize" name="save_checkout_form_setup" value="<?php _e("Save", $this->car_share) ?>">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

