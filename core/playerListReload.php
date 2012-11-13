<?php

  define( 'MQ_SERVER_NAME', 'Jack\'s Survival Server');
  define( 'MQ_SERVER_ADDR', 'mc.modeconkey.com' );
  define( 'MQ_SERVER_PORT', 25565 );
  define( 'MQ_TIMEOUT', 1 );
  
  require 'MinecraftQuery.class.php';
  
  $Timer = MicroTime( true );
  $Query = new MinecraftQuery( );
  
  try
  {
    $Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
  }
  catch( MinecraftQueryException $e )
  {
    $Error = $e->getMessage( );
  }
?>

<?php if( ( $Players = $Query->GetPlayers( ) ) !== false ): ?>
  <?php foreach( $Players as $Player ): ?>
    <tr>
      <?php if( $Player === "c0smic"): ?>
        <td id="admin">
          <iframe src="http://marcuswhybrow.github.com/minecraft-widgets/skin.html?playername=<?php echo $Player ?>&amp;scale=1" width="16" height="33" frameborder="0" scrolling="0" allowtransparency="true" class="player_skin"></iframe>
          <span class="player_name"><?php echo htmlspecialchars( $Player ); ?></span>
        </td>
      <?php else: ?>
        <td>
          <iframe src="http://marcuswhybrow.github.com/minecraft-widgets/skin.html?playername=<?php echo $Player ?>&amp;scale=1" width="16" height="33" frameborder="0" scrolling="0" allowtransparency="true" class="player_skin"></iframe>
          <span class="player_name"><?php echo htmlspecialchars( $Player ); ?></span>
        </td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td><em>No players in da' house!</em></td>
  </tr>
<?php endif; ?>