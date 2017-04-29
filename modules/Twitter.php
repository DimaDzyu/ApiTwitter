<?
namespace feed\twitter;

require "./vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

/**
* TwitterFeed
*/
class TwitterFeed
{
  private $result;
  private $consumer_key;
  private $consumer_secret;
  private $access_token;
  private $access_token_secret;
  private $obTwitter;
  private $arTwitters;
  private $arResTwitters; 
  
  function __construct()
  {
    $this->consumer_key = "w0QeCuhcavDucuqT3SS0ePZpO";
    $this->consumer_secret = "2DbC5krCudRRcnjBIfxaVCYlyFDCZPat3PrrJEckHYoW3Ktmrz";
    $this->access_token = "2826913200-7ekQh8zkmh4MIa6J6my2PLoP0yhMJeHM9U0iQSo";
    $this->access_token_secret = "pYlNxazlV5kkeLkf8gGloHJtD13vyC98irwUjFdX9CyqN";
    $this->obTwitter = $this->CreateTwitterOAuth();
  }

  private function CreateTwitterOAuth()
  {
    return new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret);
  }

  public function GetTwitter($user_name, $count)
  {
    $this->arTwitters = $this->obTwitter->get('statuses/user_timeline', array('screen_name' => $user_name, 'count' => $count));

    foreach ($this->arTwitters as $Twitt_key => $Twitt_val)
    {
      $this->arResTwitters[$Twitt_key]['id'] = $Twitt_val->id;
      $this->arResTwitters[$Twitt_key]['created'] = $this->TwitterTime($Twitt_val->created_at);
      $this->arResTwitters[$Twitt_key]['text'] = $this->makeClickableLinks($Twitt_val->text);
      $this->arResTwitters[$Twitt_key]['user']['id'] = $Twitt_val->user->id;
      $this->arResTwitters[$Twitt_key]['user']['name'] = $Twitt_val->user->name;
      $this->arResTwitters[$Twitt_key]['user']['login'] = $Twitt_val->user->screen_name;
      $this->arResTwitters[$Twitt_key]['user']['profile_background_image_url'] = $Twitt_val->user->profile_background_image_url;
      $this->arResTwitters[$Twitt_key]['user']['profile_image_url'] = $Twitt_val->user->profile_image_url;
      $this->arResTwitters[$Twitt_key]['user']['statuses_count'] = $Twitt_val->user->statuses_count;
      $this->arResTwitters[$Twitt_key]['user']['friends_count'] = $Twitt_val->user->friends_count;
      $this->arResTwitters[$Twitt_key]['user']['followers_count'] = $Twitt_val->user->followers_count;
      $this->arResTwitters[$Twitt_key]['user']['favourites_count'] = $Twitt_val->user->favourites_count;
      $this->arResTwitters[$Twitt_key]['user']['profile_banner_url'] = $Twitt_val->user->profile_banner_url;
    }

    return $this->arResTwitters; 
  }

  private function TwitterTime($time)
  {
    $b = strtotime("now"); 
    $c = strtotime($time);
    $d = $b - $c;

    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
        
    if(is_numeric($d) && $d > 0)
    {
      //if less then 3 seconds
      if($d < 3) return "right now";
      //if less then minute
      if($d < $minute) return floor($d) . " seconds ago";
      //if less then 2 minutes
      if($d < $minute * 2) return "about 1 minute ago";
      //if less then hour
      if($d < $hour) return floor($d / $minute) . " minutes ago";
      //if less then 2 hours
      if($d < $hour * 2) return "about 1 hour ago";
      //if less then day
      if($d < $day) return floor($d / $hour) . " hours ago";
      //if more then day, but less then 2 days
      if($d > $day && $d < $day * 2) return "yesterday";
      //if less then year
      if($d < $day * 365) return floor($d / $day) . " days ago";
      //else return more than a year
      return "over a year ago";
    }
  }

  private function makeClickableLinks($s) {
    return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s);
  }
}
?>