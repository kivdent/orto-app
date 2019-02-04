<span class = 'head3'>Расчёт по проценту от выручки</span><br />
<table width = '100%' border = '1' cellpadding = '1' cellspacing = '0' bordercolor = '#999999'>
    <?php foreach ($salaryTable as $key => $row): ?>

        <?php if ($key == 0) : ?>
            <tr>
                <?php foreach ($row as $salaryItem): ?>
                    <td class = 'menutext'><?php echo $salaryItem ?></td>
                <?php endforeach; ?>
            </tr>
        <?php else : ?>

            <tr> 
                <?php foreach ($salaryTable[0] as $itemKey => $salaryItem): ?>

                    <td><?php echo $row[$itemKey] ?></td>

                <?php endforeach; ?>
            </tr>

        <?php endif; ?>
    <?php endforeach; ?>
</table>
<br />