<?php 
include('init.inc.php');
  $server_ip = $config['servers']['0'][0];
  $server_port = $config['servers']['0'][1];
  $info = fetch_server_info($server_ip, $server_port);
 ?>

<?php if ($info === false){ echo '<p>Players: - / -</p>'; }else{ echo '<p>Players: ', $info['players'], ' /  ', $info['max_players'], '</p>';  } ?>