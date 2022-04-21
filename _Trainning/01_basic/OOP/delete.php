<?php
include 'model.php';
$model = new Model;
$id = $_GET['id'];
$delete = $model->delete($id);
echo "<script type='text/javascript'>alert('Deleted successfully!');window.location.href='records.php';</script>";