<?require "controllers/FeedController.php";?>
<!DOCTYPE html>
<html>
<head>
  <title>Лента новостей Netpeak</title>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="10">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <script src="/js/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="/js/script.js" type="text/javascript"></script>
</head>
<body>

<div class="main">
  <h1>Лента новостей Netpeak</h1>

  <?if(!empty($arResult[0]['user']['profile_banner_url'])):?>
    <div style="background: url(<?=$arResult[0]['user']['profile_banner_url'];?>)no-repeat;"  class="head_img" ></div>
  <?endif;?>

  <div class='twitter_main_block'>
    <?foreach ($arResult as $key => $value):?>
      <div class='twitter_block'>
        <div class="twitter_box_img"><img src="<?=$value['user']['profile_image_url'];?>" /></div>
        <div class="twitter_box_body">

          <div class="head_twitter">
            <a class="name" href="https://twitter.com/<?=$value['user']['login'];?>"><?=$value['user']['name'];?></a>
            <span class="separate">|</span>
            <span class="login">@<?=$value['user']['login'];?></span>
            <span class="created"><?=$value['created'];?></span>
          </div>
          <div class="content_twitter"><?=$value['text'];?></div>
        </div>
      </div>
    <?endforeach;?>

  </div>
</div>

</body>
</html>
