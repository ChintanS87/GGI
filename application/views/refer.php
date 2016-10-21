<?php

$refer_num = array(
        'name'          => 'refer_num',
        'id'            => 'refer_num',
        'value'         => '',
        'maxlength'     => '10',
        'size'          => '50',
        'style'         => 'width:50%'
);

?>

<?php echo form_open($this->uri->uri_string()); ?>
<table>
    <tr>
        <td><?php echo form_label('Referal Number', $refer_num['id']); ?></td>
        <td><?php echo form_input($refer_num); ?></td>
        <td style="color: red;"><?php echo form_error($refer_num['name']); ?></td>
    </tr>   
</table>


<?php echo form_submit('submit_referal','Submit Post!'); ?>
<?php echo form_close(); ?>




