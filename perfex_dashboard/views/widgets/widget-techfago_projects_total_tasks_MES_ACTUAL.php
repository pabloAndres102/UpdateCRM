<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
  Widget Name: Total projects by tags
  Description: Total projects by tags
*/
?>

<?php
$fn_get_data = function () {
  // Obtener el primer y último día del mes actual
  $first_day_of_month = date('Y-m-01');
  $last_day_of_month = date('Y-m-t');

  $sql = "
  SELECT 
      TBLTags.id AS tag_id,
      TBLTags.name AS tag_name,
      COUNT(*) AS total_tasks
  FROM
      " . db_prefix() . "tags TBLTags
          INNER JOIN
          " . db_prefix() . "taggables TBLTaggable ON TBLTags.id = TBLTaggable.tag_id
          AND TBLTaggable.rel_type = 'task'
          INNER JOIN
          " . db_prefix() . "tasks TBLTasks ON TBLTaggable.rel_id = TBLTasks.id
  WHERE TBLTags.id IN (9, 10, 11, 12) 
    AND TBLTasks.duedate BETWEEN '$first_day_of_month' AND '$last_day_of_month'
  GROUP BY tag_id, tag_name
  ORDER BY total_tasks DESC
  LIMIT 0, 10
";

    return $this->db->query($sql)->result_array();
};

$widget_data = $fn_get_data();
?>

<div>
  <ul>
    <?php foreach ($widget_data as $data_row) { ?>
      <div class="widget widget-projects-total-tasks" data-widget-id="<?= $widget['id'] ?>">
      <div class="widget-dragger"></div>
        <div class="card-counter success">
          <i class="fa fa-shield"></i>
          <span><?= _l('MES ACTUAL') ?></span>
          <span class="count-numbers"><?php print_r($data_row['total_tasks']) ?></span>
          <span class="count-name"><?= $data_row['tag_name'] ?></span>
        </div>
      </div>
    <?php } ?>
  </ul>
</div>

<script>
  window['perfex_dashboard_widget_<?= $widget['id'] ?>_data'] = <?= json_encode($widget_data) ?>;
</script>
