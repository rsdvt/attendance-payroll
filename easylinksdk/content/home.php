<form method="post" action="content/action.php">
<?php 
include 'koneksidb.php';
$sql = mysql_query("SELECT * FROM tb_device");
$jml = mysql_num_rows($sql);
if ($jml>0) {  }else
  {
  echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Device</button>';
  }
?>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-sm">
  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Device</h4>
      </div>
      <div class="modal-body">
      <label>Server IP</label><div class="input-group"><span class="input-group-addon">http://</span>
      <input name="i_serverIP" type="text" class="form-control"></div>
      <label>Server Port</label><input name="i_serverPort" type="text" class="form-control">
      <label>Device SN</label><input name="i_devSN" type="text" class="form-control">
      </div>
      <div class="modal-footer">
        <input class="btn btn-info" type="submit" name="b_addDev" value="Save">
        <button class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
</form>