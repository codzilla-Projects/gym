<?php
       
/**
 * Display Coash abscence .
 */
function coach_abscence_callback() {     
    $coaches_data = get_coaches_abscence();
?> 
    <h1 class="text-center">Pullit Coaches Abscence</h1>
    <table id="abscenceTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Coach</th>
                <th>Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($coaches_data as $coach_data) {  $coach=get_userdata($coach_data->coach_id); ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $coach->first_name." ".$coach->last_name;  ?></td>
                <td><?= $coach_data->date; ?></td>
                <td><?= $coach_data->created_at;  ?></td>
            </tr>            
            <?php $i++; } ?>
        </tbody>
 
    </table>
<?php
}