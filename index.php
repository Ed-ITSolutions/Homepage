<?php
$config = parse_ini_file("config.ini", true);
$fsockresponses = parse_ini_file("fsockresp.ini", true);
  
  function write_php_ini($array, $file)
  {
      $res = array();
      foreach($array as $key => $val)
      {
          if(is_array($val))
          {
              $res[] = "[$key]";
              foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
          }
          else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
      }
      safefilerewrite($file, implode("\r\n", $res));
  }
  
  function safefilerewrite($fileName, $dataToSave)
  {    if ($fp = fopen($fileName, 'w'))
      {
          $startTime = microtime();
          do
          {            $canWrite = flock($fp, LOCK_EX);
             // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
             if(!$canWrite) usleep(round(rand(0, 100)*1000));
          } while ((!$canWrite)and((microtime()-$startTime) < 1000));

          //file was locked so now we can store information
          if ($canWrite)
          {            fwrite($fp, $dataToSave);
              flock($fp, LOCK_UN);
          }
          fclose($fp);
      }

  }
  
  if($fsockresponses['main']['last_cache'] <= (time() - $config['main']['cache_delay'])){
    $fsockresponses['main']['last_cache'] = time();
    foreach($config['printers'] as $key => $printer){
      if(@fsockopen($printer['ip'], $printer['port'], $errno, $errstr, 1)){
        $fsockresponses['printers'][$key] = "<span class='on'>" . $config['main']['on_text'] . "</span>";
      }else{
        $fsockresponses['printers'][$key] = "<span class='off'>" . $config['main']['off_text'] . "</span>";
      }
    }
    
    foreach($config['servers'] as $key => $server){
      if(@fsockopen($server['ip'], $server['port'], $errno, $errstr, 1)){
        $fsockresponses['servers'][$key] = "<span class='on'>" . $config['main']['on_text'] . "</span>";
      }else{
        $fsockresponses['servers'][$key] = "<span class='off'>" . $config['main']['off_text'] . "</span>";
      }
    }
    
    
    write_php_ini($fsockresponses, "fsockresp.ini");
  }
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
        <?php foreach($config['printers'] as $key => $printer){ ?>
        <li><?php echo($printer['name']); ?> - <?php echo($fsockresponses['printers'][$key]); ?></li>
      <?php } ?>
      </ul>
    </div>
    <div class="printers">
      <h3>Servers</h3>
      <ul>
        <?php foreach($config['servers'] as $key => $server){ ?>
        <li><?php echo($server['name']); ?> - <?php echo($fsockresponses['servers'][$key]); ?></li>
    <?php } ?>
      </ul>
    </div>
  </div>
</body>

<?php
  
?>