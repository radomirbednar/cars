<div class="wrap">
    <h2><?php _e('Checkout form setup', $this->car_share) ?></h2>    
    <table class="form-table">
        <tbody>
    <?php foreach($this->inputs as $input_key => $input_label): ?>    
        <tr>
            <th>
                <?php _e($input_label, $this->car_share) ?>
            </th>
            <td>
                <label><input type="checkbox" value="1" name="billing_inputs[<?php echo $input_key ?>][enable]"> <?php _e('Enabled', $this->car_share) ?></label><br>
                <label><input type="checkbox" value="1" name="billing_inputs[<?php echo $input_key ?>][required]"> <?php _e('Required', $this->car_share) ?></label>
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
</div>

