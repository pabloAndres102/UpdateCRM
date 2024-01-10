<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
  Widget Name: Total projects by tags
  Description: Total projects by tags
*/
?>

<?php
$fn_get_data = function () {
    $sql = "
    SELECT 
        TBLTags.id AS tag_id,
        TBLTags.name AS tag_name,
        COUNT(*) AS total_projects
    FROM
        " . db_prefix() . "tags TBLTags
            INNER JOIN
            " . db_prefix() . "taggables TBLTaggable ON TBLTags.id = TBLTaggable.tag_id
            AND TBLTaggable.rel_type = 'project'
            INNER JOIN
            " . db_prefix() . "projects TBLProjects ON TBLTaggable.rel_id = TBLProjects.id
    WHERE TBLTags.id = 7
    GROUP BY tag_id, tag_name
    ORDER BY total_projects DESC
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
          <span><?= _l('PROYECTOS SIN CONTRATO') ?></span>
          <span class="count-numbers"><?php print_r($data_row['total_projects']) ?></span>
          <span class="count-name"><?= _l('General') ?></span>
        </div>
      </div>
    <?php } ?>
  </ul>
</div>

<script>
  window['perfex_dashboard_widget_<?= $widget['id'] ?>_data'] = <?= json_encode($widget_data) ?>;
</script>
