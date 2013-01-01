<?php

    include('core/init.inc.php');

    $server_ip = $config['servers']['0'][0];
    $server_port = $config['servers']['0'][1];
    $info = fetch_server_info($server_ip, $server_port);

    define( 'MQ_SERVER_NAME', 'Jack\'s Survival Server');
    define( 'MQ_SERVER_ADDR', 'mc.modeconkey.com' );
    define( 'MQ_SERVER_PORT', 25565 );
    define( 'MQ_TIMEOUT', 1 );

    require ('core/MinecraftQuery.class.php');

    $Timer = MicroTime( true );
    $Query = new MinecraftQuery( );

    try {
        $Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
    }
        catch( MinecraftQueryException $e )
    {
        $Error = $e->getMessage( );
    }
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <title><?php echo $info['players'] ?> players online</title>
    <meta name="viewport" content="width=device-width" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
    <script src="ext/js/jquery.tweet.js" type="text/javascript"></script>
    <script src="ext/js/jquery.fittext.js" type="text/javascript"></script>

    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="ext/stylesheets/app.css" />
    <link rel="stylesheet" href="ext/stylesheets/style.css" />

    <script type='text/javascript'>
        jQuery(function($){
            $(".tweet").tweet({
                avatar_size: 32,
                count: 5,
                username: "modeconkey",
                loading_text: "Loading updates...",
                template: "{text} {time}",
                refresh_interval: 60
            });
        });
        $(document).ready(function(){
            $(".stats").hide();
            $(".show_hide").show();

            $('.show_hide').click(function(){
                $(".stats").slideToggle();
            });
        });
    </script>
    <script type="text/javascript">
        var auto_refresh = setInterval(
            function ()
            {
                $('.Players').load('core/playerListReload.php').fadeIn("slow");
                $('.PlayerCount').load('core/playerCountReload.php').fadeIn("slow");
            }, 100000
        );
    </script>

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
    <div class="row">

        <header class="twelve columns">
            <a href="http://modeconkey.com/minecraft"><h2 class="text-center six columns title">Minecraft Hub</h2></a>

            <script type="text/javascript">
                $(".title").fitText(1.5, {maxFontSize: '30px' });
            </script>

            <nav class="six columns">
                <ul class="nav-bar">
                    <li>
                        <a href="http://www.modeconkey.com/minecraft">Home</a>
                    </li>
                    <li class="active">
                        <a href="http://www.modeconkey.com/minecraft/view_server.php">Server</a>
                    </li>
                    <li>
                        <a href="http://news.modeconkey.com/">News</a>
                    </li>
                    <li class="has-flyout">
                        <a href="http://www.modeconkey.com/minecraft/gallery">Gallery</a>
                        <a href="#" class="flyout-toggle"><span> </span></a>
                        <ul class="flyout">
                            <li><a href="/minecraft/gallery/maps">World Map</a></li>
                            <li><a href="/minecraft/gallery/inspiration">Inspiration</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://www.reddit.com/r/modeconkeyserver">Sub-Reddit</a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>

    <div class="row">
        <div class="twelve columns">
            <table class="twelve">
                <thead>
                    <tr>
                        <th>Server</th>
                        <th>Slots</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <td><p><strong><?php echo MQ_SERVER_NAME; ?></strong> - <?php echo MQ_SERVER_ADDR; ?><button href="#" class="show_hide button small">More info</button></p></td>
                <td class="PlayerCount"><?php if ($info === false){ echo '<p>Players: - / -</p>'; }else{ echo '<p>Players: ', $info['players'], ' / ', $info['max_players'], '</p>';  } ?></td>
                <?php if( isset( $Error ) ) { echo '<td id="offline"';} else { echo '<td id="online"';}?> > <?php if( isset( $Error ) ) { echo '<p>Status: Offline</p>'; }else{ echo '<p>Status: Online</p>';} ?></td>
                </tr>
                </tbody>
                <td>
                    <table class="twelve">
                        <thead>
                            <tr>
                                <th>Who's Online</th>
                            </tr>
                        </thead>
                        <tbody class="Players">
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
                        </tbody>
                    </table>
                </td>
            </table>

            <div class="stats">
                <p>
                    <a href="https://docs.google.com/spreadsheet/viewform?formkey=dHg0UXVfcEhlWkZaVTlvM202OW44ekE6MQ"><button class="button small center">Send us your feedback</button></a>
                </p>
                <div>
                    <?php if( isset( $Error ) ): ?>
                        <div class="alert alert-info">
                        <h4 class="alert-heading">Exception:</h4>
                        <?php echo htmlspecialchars( $Error ); ?>
                        </div>
                        <?php else: ?>
                        <div class="row">
                            <div class="module">
                                <table class="inner six">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Server info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if( ( $Info = $Query->GetInfo( ) ) !== false ): ?>
                                            <?php foreach( $Info as $InfoKey => $InfoValue ): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars( $InfoKey ); ?></td>
                                                    <td>
                                                        <?php
                                                        if( Is_Array( $InfoValue ) ) {
                                                            echo "<pre>";
                                                            print_r( $InfoValue );
                                                            echo "</pre>";
                                                        } else {
                                                            echo htmlspecialchars( $InfoValue );
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <h2>Server Uptime</h2>
                <img src="http://minecraft-mp.com/statistics/chart/daily/checks/2631/" border="0">
                <h2>Player Count</h2>
                <img src="http://minecraft-mp.com/statistics/chart/daily/players/2631/" border="0">

                <div id="rules">
                    <h2>Rules</h2>
                    <ul>
                        <li>No hacks, duping or mods of any sort that give you an unfair advantage over other players. Yes this includes x-ray and transparent texture packs. However, you are allowed to use mods such as a mini-map, mapper, etc.</li>
                        <li>No spamming or advertising</li>
                        <li>No harrassment or griefing of any kind</li>
                        <li>No taking other people's resources or possessions without their permission.</li>
                        <li>No killing other players unless they are willing to fight with you.</li>
                    </ul>
                </div>

                <h2>Server Specs</h2>
                <table class="twelve">
                    <thead>
                        <th>Server</th>
                        <th>CPU</th>
                        <th>RAM</th>
                        <th>OS</th>
                        <th>Misc.</th>
                    </thead>
                    <tbody>
                        <td>Dell PowerEdge 2850</td>
                        <td>[x2] Intel Xeon dual core 2.8 GHz</td>
                        <td>8.0 GB DDR2 ECC</td>
                        <td>CentOS 6.3</td>
                        <td>Backup: Every midnight <br />Map: Rendered daily</td>
                    </tbody>
                </table>
                <div class="module">
                    <button class="button small show_hide">Hide</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="eight columns">
            <div class="module">
                <div class="inner">
                    <h2 class="twitter">Instant updates via <a href="http://twitter.com/modeconkey">@modeconkey</a></h2>
                    <div class="tweet"></div>
                </div>
            </div>
        </div>

        <div class="four columns">
            <div class="module">
                <div class="inner">
                    <h2>White-List Request</h2>
                    <div>
                        <p>We are always looking for more creative crafters to join our server!  Complete this form about your experiences here to be added to the white-list queue.</p>
                        <p><a href="https://docs.google.com/spreadsheet/viewform?formkey=dF85cUk3cVpoVER3dXFFbXFQOWk2QkE6MQ">White-List Application</a></p>
                        <p>You must read our <em>server rules before submitting an application,</em> found under the "More info" tab</p>
                    </div>
                </div>
            </div>
            <div class="module">
                <div class="inner">
                    <h2>What is this page for?</h2>
                    <div>
                        <p>The Minecraft server is monitored for uptime and logs the number of users logged on throughout the day.  If the server should go offline, the status will change and a note will be posted here.</p>
                        <p>If you are experiencing problems connecting with the server and do not see a note addressing it, please email <a href="mailto:support@modeconkey.com">support@modeconkey.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>