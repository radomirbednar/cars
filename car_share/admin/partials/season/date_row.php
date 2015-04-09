<tr class="item">
    <td>
        <input type="text" value="<?php echo empty($date_from) ? '' : $date_from->format('d.m.Y') ?>" name="_from[]" class="date-from">
        <select name="from_hour[]">
            <?php for($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
        <select name="from_min[]">
            <?php for($i = 0; $i < 60; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>    
    </td>    
    <td>
        <input type="text" value="<?php echo empty($date_to) ? '' : $date_to->format('d.m.Y') ?>" name="_to[]" class="date-to">
        <select name="to_hour[]">
            <?php for($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
        <select name="to_min[]">
            <?php for($i = 0; $i < 60; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>            
    </td>
    <td>
        <button type="button" class="remove-row">X</button>
    </td>    
</tr>