<?php
/**
 * View GYM Schedule
 * @param gym_id [int] REQ
 * @param coach_id [int] OPT
 * @return schedule_HTML [string, boolean false]
 */
function gym_schedule_viewer( $gym_id = 0, $coach_id = false ) {

    if( empty($gym_id) ) return false;

    $current_user     = wp_get_current_user();

    $old_data = get_post_meta($gym_id, 'sl_schedule', true);
    $old_data = json_encode($old_data);


    $working_pattern = get_post_meta($gym_id, 'sch_working_pattern', true);
    $starting = get_post_meta($gym_id, 'sch_starting', true);
    $starting = $working_pattern === 'limited' ? intval(explode(':', $starting)[0]) : 0;
    $ending = get_post_meta($gym_id, 'sch_ending', true);
    $ending = $working_pattern === 'limited' ? intval(explode(':', $ending)[0]) : 23;
    echo "<script type='text/javascript'>
    window.calendarData = JSON.parse('{$old_data}');
    window.workingHours = {
        start: {$starting},
        end: {$ending}
    }
    </script>";
    ?>
    <script type="text/javascript" src="<?php echo SH_URL. 'assets/js/show-schedule.js' ?>"></script>
    <div class="schedule-wrapper">			
        <div class="schedule-content">
            <div id="calendar-container">
                <div class="filters">
                    <div class="d-flex justify-content-center">
                        <div class="filter-group">
                            <label> <input type="radio" class="schedule-filter" name="filter" value="all" checked/> All</label>
                        </div>
                        <div class="filter-group">
                            <label> <input type="radio" class="schedule-filter" name="filter" value="male"/> Male</label>
                        </div>
                        <div class="filter-group">
                            <label> <input type="radio" class="schedule-filter" name="filter" value="female"/> Female</label>
                        </div>
                    </div>
                </div>
                <table id="calendar-table">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div><!-- calendar-container -->
        </div><!-- schedule-content -->
    </div><!-- schedule-wrapper -->
    <?php
}