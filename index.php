<?php
$config = parse_ini_file("config.ini", true);
?>

<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <title><?php echo($config['main']['name']); ?></title>
</head>
<body>
  <div class="main-container">
    <h1><?php echo($config['main']['name']); ?></h1>
    <h2><?php echo(strftime($config['main']['date_format'])); ?></h2>
    <form method="get" action="http://www.google.com/search">

    <input type="text"   name="q" size="25" style="color:#808080;"
    maxlength="255" value="<?php echo($config['main']['search_text']); ?>"
    onfocus="if(this.value==this.defaultValue)this.value=''; this.style.color='black';" onblur="if(this.value=='')this.value=this.defaultValue; "/>
    <input type="submit" value="<?php echo($config['main']['search_button']); ?>" />
    </form>
    <div class="sites" style="width:<?php echo((132 * count($config['links']))); ?>px;">
      <?php foreach($config['links'] as $link){ ?>
        <a href="<?php echo($link['url']); ?>" style="background-color:<?php echo($link['bg']); ?>"><?php echo($link['title']); ?></a>  
      <?php } ?>
    </div>
    
    <div class="aup">
      <h3><?php echo($config['aup']['title']); ?></h3>
      <ul>
        <?php foreach($config['aup']['line'] as $line){ ?>
          <li><?php echo($line); ?></li>
        <?php } ?>
      </ul>
    </div>
    <div class="printers">
      <h3>Printers</h3>
      <ul>
        <?php foreach($config['printers'] as $printer){ ?>
        <li><?php echo($printer['name']); ?> - <?php
    $sock = @fsockopen($printer['ip'], $printer['port'], $errno, $errstr, 1);
    if($sock){
      echo "<span class=\"on\">" . $config['main']['on_text'] . "</span>";
    }else{
      echo "<span class=\"off\">" . $config['main']['off_text'] . "</span>";
    }
    ?></li>
      <?php } ?>
      </ul>
    </div>
    <div class="printers">
      <h3>Servers</h3>
      <ul>
        <?php foreach($config['servers'] as $server){ ?>
        <li><?php echo($server['name']); ?> - <?php
    $sock = @fsockopen($server['ip'], $server['port'], $errno, $errstr, 1);
    if($sock){
      echo "<span class=\"on\">" . $config['main']['on_text'] . "</span>";
    }else{
      echo "<span class=\"off\">" . $config['main']['off_text'] . "</span>";
    }
    ?></li>
    <?php } ?>
      </ul>
    </div>
  </div>
</body>