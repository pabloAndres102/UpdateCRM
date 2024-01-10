<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
  Widget Name: Total projects
  Description: Total projects
  
*/
?>

<?php
$fn_get_data = function () {
  $widget_req_from = DateTime::createFromFormat('Y-m-d', $this->input->get('period_from'));
  if ($widget_req_from !== false) {
    $widget_req_from = $widget_req_from->format('Y-m-d');
  } else {
    $widget_req_from = null;
  }

  $widget_req_to = DateTime::createFromFormat('Y-m-d', $this->input->get('period_to'));
  if ($widget_req_to !== false) {
    $widget_req_to = $widget_req_to->format('Y-m-d');
  } else {
    $widget_req_to = null;
  }

  $sql = "
    SELECT *
    FROM " . db_prefix() . "proposals TBLProposals
";
if (isset($widget_req_from) && isset($widget_req_to)) {
    $sql .= "
        WHERE TBLProposals.datecreated >= '" . $widget_req_from . " 00:00:00' AND TBLProposals.datecreated <= '" . $widget_req_to . " 23:59:59'
    ";
}
  return $this->db->query($sql)->result_array();
};

$widget_data = $fn_get_data();
?>
<?php 
$approved = 0;
  foreach ($widget_data as $proposal ) {
    if($proposal['status'] == 4){
    $approved = $approved + 1;
    }
  }
  ?>
  
<div class="widget widget-projects-total-tasks" data-widget-id="<?= $widget['id'] ?>">
  <div class="widget-dragger"></div>
  <div class="card-counter primary">
    <i class="fa fa-file-powerpoint-o"></i>
    <span class="count-numbers"><?php print_r($approved) ?></span>
    <span class="count-name"><?= _l('Sent proposals') ?></span>
  </div>
</div>