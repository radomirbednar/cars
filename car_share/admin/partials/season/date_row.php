<tr class="item">
    <td>
        <input type="text" value="<?php echo empty($date_from) ? '' : $date_from->format('d.m.Y') ?>" name="_from[]" class="date-from hasDatepicker">
    </td>    
    <td>
        <input type="text" value="<?php echo empty($date_to) ? '' : $date_to->format('d.m.Y') ?>" name="_to[]" class="date-to hasDatepicker">
    </td>
    <td>
        <button type="button" class="remove-row">X</button>
    </td>    
</tr>