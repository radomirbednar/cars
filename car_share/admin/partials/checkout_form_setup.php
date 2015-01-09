<div class="wrap">
    <h2><?php _e('Checkout form setup', $this->car_share) ?></h2>    
    <table class="form-table">
        <thead>
            <tr>
                <th></th>
                <th><?php _e("Visible", $this->car_share) ?></th>
                <th><?php _e("Required", $this->car_share) ?></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($this->inputs as $input_key => $input_label): ?>    
        <tr>
            <th>
                <?php _e($input_label, $this->car_share) ?>
            </th>
            <td>
                <input type="checkbox" value="1" name="_billing_inputs[<?php echo $input_key ?>][enable]">
            </td>
            <td>
                <input type="checkbox" value="1" name="_billing_inputs[<?php echo $input_key ?>][required]">
            </td>
        </tr>    
    <?php endforeach; ?>    
        </tbody>
        <thead>
            <tr>
                <td colspan="3">
                    <input type="submit" class="button button-primary button-hero load-customize hide-if-no-customize" name="save_checkout_form_setup" value="<?php _e("Save", $this->car_share) ?>">
                </td>
            </tr>
        </thead>
    </table>
</div>

