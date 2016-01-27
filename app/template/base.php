<!DOCTYPE html>
<html lang=pt>
<head>
  <meta charset=utf-8>
  <title>Break Check</title>
  <meta name=viewport content="width=device-width, initial-scale=1">
  <link rel=stylesheet type=text/css href=/public/fonts/font-awesome.min.css>
  <link rel=stylesheet href=/public/css/normalize.css>
  <link rel=stylesheet href=/public/css/skeleton.css>
  <link rel=stylesheet href=/public/css/style.css>
</head>
<body>
    <?php echo $output['title'] ?>
  <div class=section>
      <div class=container>
          <div class=row>
              <div class="eight columns">
                  <div id=map>

                  </div>
              </div>
              <div class="four columns">
                  <h4>Rio de janeiro, <small>RJ</small></h4>
              </div>
          </div>
      </div>
  </div>
  <script type="text/javascript">
      var server = <?php echo json_encode($output); ?>;
  </script>
  <script type="text/javascript" src=/public/js/script.js></script>
  <script src=http://maps.googleapis.com/maps/api/js></script>
</body>
</html>
