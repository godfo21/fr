<?php

ob_start();

define('API_KEY','');
function bot($method,$datas=[]){
    $iiiiz = http_build_query($datas);
        $url = "https://api.telegram.org/bot".API_KEY."/".$method."?$iiiiz";
        $matthew = file_get_contents($url);
        return json_decode($matthew);
}
$update=
json_decode(file_get_contents('php://input'));
$update2=json_decode(file_get_contents('php://input'),true);
$sudo=500276966;
$username="illliilibot";
$namechat=$update->message->chat->title;
$chattype=$update->message->chat->type;
$emoji=explode(",","đ,đ,đ,đ,đ,đ,đ,đ¤Ŗ,âēī¸,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ,đ¤,đ¤,đ¤,đ,đ¤Ą,đ¤ ,đ,đ,
đ,đ,đ,đ,đ,âšī¸,đŖ,đ,
đĢ,đŠ,đ¤,đ ,đĄ,đļ,đ,đ,đ¯,đĻ,đ§,đŽ,đ˛,đĩ,đŗ,đą,
đ¨,đ°,đĸ,đĨ,đ¤¤,đ­,đ,đĒ,đ´,đ,đ¤,đ¤Ĩ,đŦ,đ¤,đ¤ĸ,đ¤§,đˇ,đ¤,đ¤,đ,đŋ,đē,đ¸,đš,đģ,đŧ,đŊ,đ,đŋ,đž");
$english=explode(",","a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z");
if(isset($update->message->new_chat_member) || isset($update->message->new_chat_photo) || isset($update->message->new_chat_title) || isset($update->message->left_chat_member) || isset($update->message->pinned_message)){

$chat_id=$update->message->chat->id; $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
  if($settings["tg"]=="yes"){
    bot("deleteMessage",[
      "chat_id"=>$chat_id,
      "message_id"=>$update->message->message_id
    ]);
  }
}
if(isset($update->message->new_chat_member)){
   if($update->message->new_chat_member->username==$username and $chattype!="channel"){
     $chat_id=$update->message->chat->id;

   mkdir("$chat_id");
 $admins=json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatAdministrators?chat_id=$chat_id"),true);
     $admins=$admins['result'];
     foreach($admins as $key=>$value){
       $id=$admins[$key]['user']['id'];
       $list="$list\n$id";
       $creator=array_search("creator",$admins[$key]);
       if($creator!=false){
         file_put_contents("$chat_id/creator.txt","$id");
       }
     }
     file_put_contents("$chat_id/admins.txt","admins\n$list");
     file_put_contents("$chat_id/settings.json",json_encode(["link"=>"yes","hashtag"=>"no","username"=>"no","forward"=>"yes","bot"=>"yes","photo"=>"no","video"=>"no","document"=>"no","bold"=>"no","code"=>"no","italic"=>"no","sticker"=>"no","voice"=>"no","audio"=>"no","emoji"=>"no","english"=>"no","tg"=>"yes","kickadderbot"=>"no"]));
     file_put_contents("$chat_id/mutes.txt","mutes");
     if(file_exists("chats.json")){
       $groups=json_decode(file_get_contents("chats.json"),true);
       $groups["$chat_id"]=$namechat;
       $groups=json_encode($groups);
       file_put_contents("chats.json","$groups");
     }else{
       file_put_contents("chats.json",json_encode(["$chat_id"=>"$namechat"]));
     }
     var_dump(bot("sendMessage",[
       "chat_id"=>$chat_id,
       "text"=>"",
       "parse_mode"=>"markdown"
     ]));
   }elseif($update->message->new_chat_member->is_bot==true){
     $chat_id=$update->message->chat->id;
     $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
     $admins=file_get_contents("$chat_id/admins.txt");
     $id=$update->message->from->id;
     if($settings["kickadderbot"]=="yes" && $update->message->from->id!=$sudo && !strstr($admins,"$id")){
       bot("kickChatMember",[
         "chat_id"=>$chat_id,
         "user_id"=>$id
       ]);
     }
     if($settings['bot']=="yes"){
       var_dump(bot("kickChatMember",[
         "chat_id"=>$chat_id,
         "user_id"=>$update->message->new_chat_member->id
       ]));
     }
   }
}
if(isset($update->message->left_chat_member)){
$user=$update->message->left_chat_member->username;
$chat_id=$update->message->chat->id;
$chatname=$update->message->chat->title;
  if($user==$username){
    unlink("$chat_id/admins.txt");
    unlink("$chat_id/mutes.txt");
    unlink("$chat_id/creator.txt");
    unlink("$chat_id/settings.json");
    rmdir("$chat_id");
    $groups=json_decode(file_get_contents("chats.json"),true);
    unset($groups["$chat_id"]);
    $groups=json_encode($groups);
    file_put_contents("chats.json","$groups");
  }
}
if(isset($update->message->text)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $text=$update->message->text; $adminlist=file_get_contents("$chat_id/admins.txt");
 $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
 if($id!=$sudo and strstr("$adminlist","$id")==false){
   foreach($emoji as $key=>$value){
     if(strstr($text,$emoji[$key])==true and $settings['emoji']=="yes"){
       var_dump(bot("deleteMessage",[
         "chat_id"=>$chat_id,
         "message_id"=>$update->message->message_id
       ]));
     }
   }
   foreach($english as $key=>$value){
     if(stristr($text,$english[$key])==true and $settings['english']=="yes"){
       var_dump(bot("deleteMessage",[
         "chat_id"=>$chat_id,
         "message_id"=>$update->message->message_id
       ]));
     }
   }
 }
 if(isset($update->message->entities)){
$adminlist=file_get_contents("$chat_id/admins.txt");
if($id!=$sudo and strstr("$adminlist","$id")==false){     
$array=json_decode(file_get_contents('php://input'),true);
     $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
     foreach($array['message']['entities'] as $key=>$value){
       $t=$array['message']['entities'][$key]['type'];
       if($t=="mention" and $settings['username']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="url" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="hashtag" and $settings['hashtag']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="text_link" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="bold" and $settings['bold']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="code" and $settings['code']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="italic" and $settings['italic']=="yes"){
        var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }
     }
   }}
   $j=file_get_contents("$chat_id/admins.txt");
   if(($update->message->text=="Ø§ŲØ§ØšØ¯Ø§Ø¯Ø§ØĒ" and strstr("$j","$id")==true) or ($update->message->text=="Ø§ŲØ§ØšØ¯Ø§Ø¯Ø§ØĒ" and $update->message->from->id==$sudo)){
     $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
     $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }
     var_dump(bot("sendMessage",[
       "chat_id"=>$chat_id,
       "text"=>"_>>>  ŲØ°Ų Ø§ŲØ§ŲØ§ŲØą Ø§ŲØŽØ§ØĩŲ ŲØ¨ŲØĒ Ø§ŲØ­ŲØ§ŲŲ ØēŲØą ŲØšØąØ¨Ų ŲŲØšŲŲ ØšŲŲ ØĒØ­Ø¯ŲØĢ ŲØĒØšØąŲØ¨ Ø§ŲØ¨ŲØĒ Ø¨ŲŲØ§Ø¯ØŠ
       â¨ @tareq01 
   
<<_",
       "parse_mode"=>"markdown",       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
   }elseif(($update->message->text=="/settings" and strstr("$j","$id")==true) or ($update->message->text=="/delphoto" and $update->message->from->id==$sudo)){
     bot("deleteChatPhoto",[
       "chat_id"=>$chat_id
     ]);
   }elseif($update->message->text=="Ø§ŲØēØ§ØĄ Ø§ŲØĒØĢØ¨ŲØĒ" and (strstr("$adminlist","$id")==true or $id==$sudo)){
    var_dump(bot("unpinChatMessage",[
      "chat_id"=>$chat_id
    ]));
  }elseif($update->message->text=="Ø§ŲØ§ŲØ§ŲØą" and (strstr("$adminlist","$id")==true or $id==$sudo)){
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØ§ŲØą Ø§ŲØŽØ§ØĩØŠ Ø¨Ø§ŲŲØŦŲŲØšØŠ
- Ø§ŲØ§ØšØ¯Ø§Ø¯Ø§ØĒ : ŲØšØąØļ Ø§ØšØ¯Ø§Ø¯Ø§ØĒ Ø§ŲŲŲŲ Ų Ø§ŲŲØĒØ­ 
- ØąŲØš Ø§Ø¯ŲŲ Ø¨Ø§ŲØąØ¯ 
- ØĒŲØ˛ŲŲ Ø§Ø¯ŲŲ Ø¨Ø§ŲØąØ¯
- ØˇØąØ¯ Ø¨Ø§ŲØąØ¯
- Ø§ŲØēØ§ØĄ Ø§ŲØ­Ø¸Øą Ø¨Ø§ŲØąØ¯ 
- ŲØĒŲ Ø¨Ø§ŲØąØ¯ 
-Ø§ŲØąØ§Ø¨Øˇ
- ØĒŲØšŲŲ Ø§ŲØĒØ­ŲŲ   
-  ØĒØšØˇŲŲ Ø§ŲØĒØ­ŲŲ
- Ø§ŲŲØˇŲØą 
- Ø§ŲØēØ§ØĄ Ø§ŲŲØĒŲ Ø¨Ø§ŲØąØ¯ 
- Ø§ŲŲŲØĒŲŲŲŲ
- Ø§ŲØ§ŲØ¯Ų
-Ø§ŲŲŲØĒ
-ŲØ´Ų Ø¨Ø§ŲØąØ¯ 
- ØĒØĢØ¨ŲØĒ Ø¨Ø§ŲØąØ¯ 
- Ø§ŲØēØ§ØĄ Ø§ŲØĒØĢØ¨ŲØĒ Ø¨Ø§ŲØąØ¯
 
-@tareq01
"
    ]));
  }elseif($update->message->text=="Ø§ŲŲŲØĒŲŲŲŲ" and (strstr("$adminlist","$id")==true or $id==$sudo)){
    if($mutes!="mutes"){
      $mutes=str_replace("mutes\n","","$mutes");
      $mutes=explode("\n","$mutes");
      $list=array();
      foreach($mutes as $key=>$value){
      $list[$key]=array(array("text"=>"$value","callback_data"=>"mute$value"));
      }
      var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_>> ŲØ§ØĻŲØŠ Ø§ŲŲŲØĒŲŲŲŲ <<_",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
      ]));
    }else{
      var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Ø§ŲŲØ§ØĻŲØŠ ŲØ§ØąØēØŠ",
        "parse_mode"=>"markdown"
        ]));
    }
  }elseif($update->message->text=="Ø§ŲŲØŦŲŲØšØ§ØĒ" and $id==$sudo){
    $groups=json_decode(file_get_contents("chats.json"),true);
    $list=array();
    foreach($groups as $key=>$value){
      array_push($list,array(array("text"=>$value,"callback_data"=>$key."leavechat")));
    }
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"_>>>> Ø§ŲŲØŦŲŲØšØ§ØĒ <<<<_",
      "parse_mode"=>"markdown",
      "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
    ]));
  }
 }else{
   if($update->message->text=="/start"){
     var_dump(bot("sendMessage",[
       "chat_id"=>$update->message->chat->id,
       "text"=>"  đ¤âŋØĸŲŲØ§ Ø§ŲØĸ Ø¨ŲŲŲŲŲØĒ đŊīēīģģÚÛÛÛ§īšģÛŦīšģīšģÛŦīšģīšģØˇŲŲÛŲ°ÛĒÛŦīšģīšˇŲ°ÛĒÛĢīšģī¯ĄØąŲÛĻŲ°ÛĒÛĢīšžŲ­īšžÛĻŲ°ÛĒÛĢ
ââ ØĸØŽØĒŲØĩØ§ØĩŲŲ Ø­ŲØ§ŲŲØŠ ØĸŲŲØŦŲŲŲØšŲØ§ØĒ ..
đĄâ ŲŲŲ ØĸŲØŗŲØ¨ØĸŲ ŲØĸŲØĒŲØŦŲŲ ŲØĸŲØĒŲØąØĸØą ŲØĸŲØŽ

ââââŲââââ
đ¨đģâđģÂĻ ŲŲØ§ØŗØĒŲØŗØ§Øą đĄâ­ @tareq01 

 
  ",
       "parse_mode"=>"markdown",
       "reply_markup"=>json_encode(["inline_keyboard"=>[[["text"=>"Ø§ØļŲŲŲ ŲŲØŦŲŲØšØĒŲ","url"=>"http://telegram.me/$username?startgroup=new"]]]])
     ]));
   }
 }
}elseif(isset($update->message->caption)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $caption=$update->message->caption; $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
 $adminlist=file_get_contents("$chat_id/admins.txt");
 if($id!=$sudo and strstr("$adminlist","$id")==false){
   foreach($emoji as $key=>$value){
     if(strstr("$caption",$emoji[$key])==true and $settings['emoji']=="yes"){
       var_dump(bot("deleteMessage",[
         "chat_id"=>$chat_id,
         "message_id"=>$update->message->message_id
       ]));
     }
   }
   foreach($english as $key=>$value){
     if(stristr("$caption",$english[$key])==true and $settings['english']=="yes"){
       var_dump(bot("deleteMessage",[
         "chat_id"=>$chat_id,
         "message_id"=>$update->message->message_id
       ]));
     }
   }
 }
 if(strstr("$mutes","$id")==true){
   var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
 }elseif(isset($update->message->caption_entities)){
if($id!=$sudo and strstr("$adminlist","$id")==false){
     $array=json_decode(file_get_contents('php://input'),true);
     foreach($array['message']['caption_entities'] as $key=>$value){
       $t=$array['message']['caption_entities'][$key]['type'];
       if($t=="mention" and $settings['username']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="url" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="hashtag" and $settings['hashtag']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="text_link" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="bold" and $settings['bold']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="code" and $settings['code']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }elseif($t=="italic" and $settings['italic']=="yes"){
        var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
       }
     }
   }}
 }
}
if(isset($update->message->forward_from) or isset($update->message->forward_from_chat)){
$chat_id=$update->message->chat->id;
$id=$update->message->from->id;
$adminlist=file_get_contents("$chat_id/admins.txt");
$settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
 if($settings['forward']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
   var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
 }
}
if(isset($update->message->reply_to_message)){
$text=$update->message->text;
$chat_id=$update->message->chat->id;
$from_id=$update->message->from->id;
$rl_fromid=$update->message->reply_to_message->from->id;
$mutes=file_get_contents("$chat_id/mutes.txt");
$adminlist=file_get_contents("$chat_id/admins.txt");
$creator=file_get_contents("$chat_id/creator.txt");
  if(($text=="ØąŲØš Ø§Ø¯ŲŲ" and strstr("$creator","$from_id")==true) or ($text=="ØąŲØš Ø§Ø¯ŲŲ" and $from_id==$sudo)){
    if(strstr("$adminlist","$rl_fromid")==true){
      var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Ø§ŲØšØļŲ $rl_fromid Ø¨ŲŲØšŲ Ø§Ø¯ŲŲ .",
        "parse_mode"=>"markdown"
      ]));
    }else{
      file_put_contents("$chat_id/admins.txt","$adminlist\n$rl_fromid");
      var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Ø§ŲØšØļŲ $rl_fromid ØĒŲ ØąŲØšØŠ Ø§Ø¯ŲŲ .",
        "parse_mode"=>"markdown"
      ]));
    }
  }if(($text=="ØĒŲØ˛ŲŲ Ø§Ø¯ŲŲ" and strstr("$creator","$from_id")==true) or ($text=="ØĒŲØ˛ŲŲ Ø§Ø¯ŲŲ" and $from_id==$sudo)){
    if(strstr("$adminlist","$rl_fromid")==true){
      $adminlist=str_replace("\n$rl_fromid","","$adminlist");
     file_put_contents("$chat_id/admins.txt","$adminlist");
      var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Ø§ŲØšØļŲ $rl_fromid ØĒŲ ØĒŲØ˛ŲŲŲ ŲŲ Ø§ŲØ§Ø¯ŲŲŲŲ .",
        "parse_mode"=>"markdown"
      ]));
    }else{
     var_dump(bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Ø§ŲØšØļŲ $rl_fromid ŲŲØŗ ŲŲ ŲØ§ØĻŲØŠ Ø§ŲØ§Ø¯ŲŲŲŲ",
        "parse_mode"=>"markdown"
      ]));
    }
  }elseif(($text=="ØˇØąØ¯" and strstr("$adminlist","$from_id")==true) or ($text=="ØˇØąØ¯" and $from_id==$sudo)){
    var_dump(bot("kickChatMember",[
      "chat_id"=>$chat_id,
      "user_id"=>$rl_fromid
    ]));
  }elseif($text=="ØĒØĢØ¨ŲØĒ" and (strstr("$adminlist","$from_id")==true or $from_id==$sudo)){
    var_dump(bot("pinChatMessage",[
      "chat_id"=>$chat_id,
      "message_id"=>$update->message->reply_to_message->message_id
    ]));
  }elseif($text=="Ø§ŲØēØ§ØĄ Ø§ŲØ­Ø¸Øą" && strstr("$adminlist","$from_id")==true){
    bot("unbanChatMember",[
      "chat_id"=>$chat_id,
      "user_id"=>$rl_fromid
    ]);
    bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØšØļŲ $rl_fromid ØĒŲ Ø§ŲØēØ§ØĄ Ø­Ø¸ØąØŠ .",
      "parse_mode"=>"markdown"
    ]);
  }elseif($text=="Ø§ŲØ¯Ų"){
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØ§ŲØ¯Ų : `$id`",
      "parse_mode"=>"markdown"
    ]));
  }elseif($text=="ŲØŗØ­" and (strstr("$adminlist","$from_id")==true or $from_id==$sudo)){
    var_dump(bot("deleteMessage",[
      "chat_id"=>$chat_id,
      "message_id"=>$update->message->reply_to_message->message_id
    ]));
    var_dump(bot("deleteMessage",[
      "chat_id"=>$chat_id,
      "message_id"=>$update->message->message_id
    ]));
  }elseif($text=="ØĒØēŲØą Ø§ŲØĩŲØąØŠ" and isset($update->message->reply_to_message->photo) and ($from_id==$sudo or strstr("$adminlist","$from_id")==true)){
   $file_id=$update2["message"]["reply_to_message"]["photo"][0]["file_id"];
   $file_path=json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getfile?file_id=$file_id"));
   $file_path=$file_path->result->file_path;
   file_put_contents("$chat_id/photo.jpg",file_get_contents("https://api.telegram.org/file/bot".API_KEY."/$file_path"));
   bot("setChatPhoto",[
     "chat_id"=>$chat_id,
     "photo"=>new CurlFile("$chat_id/photo.jpg")
   ]);
   unlink("$chat_id/photo.jpg");
  }elseif($text=="ŲØĒŲ" and $rl_fromid!=$sudo and strstr("$adminlist","$rl_fromid")==false and strstr("$mutes","$rl_fromid")==false and ($from_id==$sudo or strstr("$adminlist","$from_id")==true)){
    file_put_contents("$chat_id/mutes.txt","$mutes\n$rl_fromid");
    bot("restrictChatMember",[
      "chat_id"=>$chat_id,
      "user_id"=>$rl_fromid,
      "can_send_messages"=>false
    ]);
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØšØļŲ $rl_fromid ØĒŲ ŲØĒŲØŠ",
      "parse_mode"=>"markdown"
    ]));
  }elseif($text=="ŲØĒŲ" and $rl_fromid!=$sudo and strstr("$adminlist","$rl_fromid")==false and strstr("$mutes","$rl_fromid")==true and ($from_id==$sudo or strstr("$adminlist","$from_id")==true)){
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>" Ø§ŲØšØļŲ $rl_fromid ØĒŲ ŲØĒŲØŠ Ø¨Ø§ŲŲØšŲ .",
      "parse_mode"=>"markdown"
    ]));
  }elseif($text=="ŲØĒŲ" and $rl_fromid!=$sudo and (strstr("$adminlist","$rl_fromid")==true or $update->message->reply_to_message->from->username=="$username") and strstr("$mutes","$rl_fromid")==false and ($from_id==$sudo or strstr("$adminlist","$from_id")==true)){
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØšØļŲ $rl_fromid ŲŲ ŲØ§ØĻŲØŠ Ø§ŲØ§Ø¯ŲŲŲŲ ŲØ§ ŲŲŲŲŲŲ ŲØĒŲØŠ",
      "parse_mode"=>"markdown"
    ]));
  }elseif($text=="Ø§ŲØēØ§ØĄ Ø§ŲŲØĒŲ" and (strstr("$adminlist","$from_id")==true or $from_id==$sudo) and strstr("$mutes","$rl_fromid")==true){
    $mutes=str_replace("\n$rl_fromid","","$mutes");
    bot("restrictChatMember",[
      "chat_id"=>$chat_id,
      "user_id"=>$rl_fromid,
      "can_send_messages"=>true,
      "can_add_web_page_previews"=>true,
      "can_send_media_messages"=>true,
      "can_send_other_messages"=>true
    ]);
    file_put_contents("$chat_id/mutes.txt","$mutes");
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØšØļŲ $rl_fromid ØĒŲ Ø§ŲØēØ§ØĄ ŲØĒŲØŠ",
      "parse_mode"=>"markdown"
    ]));
  }elseif($text=="Ø§ŲØēØ§ØĄ Ø§ŲŲØĒŲ" and (strstr("$adminlist","$from_id")==true or $from_id==$sudo) and strstr("$mutes","$rl_fromid")==false){
    var_dump(bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>"Ø§ŲØšØļŲ $rl_fromid ŲŲØŗ ŲŲ ŲØ§ØĻŲØŠ Ø§ŲŲØĒŲ .",
      "parse_mode"=>"markdown"
    ]));
  }
    
}
if(isset($update->message->video) || isset($update->message->video_note)){
 if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
 if(strstr("$id","$mutes")==true){
   var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['video']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}elseif(isset($update->message->photo)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['photo']=="yes" and $id!=$sudo  and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}elseif(isset($update->message->voice)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['voice']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}elseif(isset($update->message->audio)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['audio']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}elseif(isset($update->message->sticker)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['sticker']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}elseif(isset($update->message->document)){
if($update->message->chat->type!="private"){
 $id=$update->message->from->id;
 $chat_id=$update->message->chat->id;
 $mutes=file_get_contents("$chat_id/mutes.txt");
 $adminlist=file_get_contents("$chat_id/admins.txt");
   $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
   if($settings['document']=="yes" and $id!=$sudo and strstr("$adminlist","$id")==false){
     var_dump(bot("deleteMessage",[
           "chat_id"=>$update->message->chat->id,
           "message_id"=>$update->message->message_id
         ]));
   }
 }
}
if(isset($update->callback_query)){
$data=$update->callback_query->data;
$cl_id=$update->callback_query->id;
$cl_msgid=$update->callback_query->message->message_id;
$chat_id=$update->callback_query->message->chat->id;
$cl_fromid=$update->callback_query->from->id;
$mutes=file_get_contents("$chat_id/mutes.txt");
$adminlist=file_get_contents("$chat_id/admins.txt");
if(strstr("$adminlist","$cl_fromid")==true or $cl_fromid==$sudo){
    if($data=="forward:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['forward']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="forward:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['forward']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="bot:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['bot']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="bot:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['bot']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="kickadderbot:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['kickadderbot']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="kickadderbot:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['kickadderbot']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="link:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['link']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="link:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['link']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="bold:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['bold']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="bold:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['bold']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="code:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['code']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="code:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['code']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="italic:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['italic']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="italic:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['italic']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="username:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['username']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="username:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['username']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="hashtag:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['hashtag']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="hashtag:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['hashtag']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="video:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['video']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="video:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['video']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="photo:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['photo']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="photo:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['photo']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="document:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['document']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="document:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['document']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="voice:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['voice']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="voice:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['voice']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="sticker:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['sticker']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="sticker:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['sticker']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="audio:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['audio']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="audio:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['audio']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="emoji:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['emoji']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="emoji:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['emoji']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="english:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['english']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="english:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['english']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="tg:yes"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['tg']="no";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif($data=="tg:no"){
      $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
      $settings['tg']="yes";
      $json=json_encode($settings);
      file_put_contents("$chat_id/settings.json","$json");
      $list=array();
     $number=-1;
     foreach($settings as $key=>$value){
       $number=$number+1; $list[$number]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
     }   
     var_dump(bot("editMessageReplyMarkup",[
       "chat_id"=>$chat_id,
       "message_id"=>$cl_msgid,       "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
     ]));
    }elseif(strstr($data,"mute")==true){
      $data=str_replace("mute","",$data);
      bot("restrictChatMember",[
        "chat_id"=>$chat_id,
        "user_id"=>$data+0,
        "can_send_messages"=>true,
        "can_add_web_page_previews"=>true,
      "can_send_media_messages"=>true,
      "can_send_other_messages"=>true
      ]);
      $mutes=str_replace("\n$data","","$mutes");
      file_put_contents("$chat_id/mutes.txt","$mutes");
      $mutes=file_get_contents("$chat_id/mutes.txt");
      if($mutes!="mutes"){
        $mutes=str_replace("mutes\n","","$mutes");
        $mutes=explode("\n","$mutes");
        $list=array();
        foreach($mutes as $key=>$value){         
        $list[$key]=array(array("text"=>"$value","callback_data"=>"mute$value"));
        }
        var_dump(bot("editMessageReplyMarkup",[
        "chat_id"=>$chat_id,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
        ]));
      }else{
        var_dump(bot("editMessageText",[
          "chat_id"=>$chat_id,
          "message_id"=>$cl_msgid,
          "text"=>"_muteslist is empty_",
          "parse_mode"=>"markdown"
        ]));
      }
    }elseif(strstr($data,"leavechat")==true and $cl_fromid==$sudo){
      $data2=str_replace("leavechat","",$data);
      $num=$data2+0;
      unlink("$data2/admins.txt");
      unlink("$data2/mutes.txt");
      unlink("$data2/creator.txt");
      unlink("$data2/settings.json");
      rmdir("$data2");
      $groups=json_decode(file_get_contents("chats.json"),true);
      unset($groups[$data2]);
        $list=array();
        foreach($groups as $key=>$value){
          array_push($list,array(array("text"=>$value,"callback_data"=>$key."leavechat")));
        }
        $groups=json_encode($groups);
        file_put_contents("chats.json","$groups");
        var_dump(bot("editMessageReplyMarkup",[
          "chat_id"=>$chat_id,
          "message_id"=>$cl_msgid,
          "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
        ]));
        var_dump(bot("leavechat",[
          "chat_id"=>$num
        ]));
      }
      
  }else{
    var_dump(bot("answerCallbackQuery",[
      "callback_query_id"=>$cl_id,
      "text"=>"you are not in adminlist",
      "show_alert"=>true
    ]));
  }
}
if(isset($update->edited_message)){
$chat_id=$update->edited_message->chat->id;
$msgid=$update->edited_message->message_id;
$id=$update->edited_message->from->id;
$text=$update->edited_message->text;
$caption=$update->edited_message->caption;
$settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
$adminlist=file_get_contents("$chat_id/admins.txt");
if(empty($text)==false and $id!=$sudo and strstr("$adminlist","$id")==false){
  foreach($emoji as $key=>$value){
    if(strstr($text,$emoji[$key])==true and $settings['emoji']=="yes"){
      var_dump(bot("deleteMessage",[
        "chat_id"=>$chat_id,
        "message_id"=>$msgid
      ]));
    }
  }
  foreach($english as $key=>$value){
    if(stristr($text,$english[$key])==true and $settings['english']=="yes"){
      var_dump(bot("deleteMessage",[
        "chat_id"=>$chat_id,
        "message_id"=>$msgid
      ]));
    }
  }
}
if(empty($caption)==false and $id!=$sudo and strstr("$adminlist","$id")==false){
  foreach($emoji as $key=>$value){
    if(strstr($caption,$emoji[$key])==true and $settings['emoji']=="yes"){
      var_dump(bot("deleteMessage",[
        "chat_id"=>$chat_id,
        "message_id"=>$msgid
      ]));
    }
  }
  foreach($english as $key=>$value){
    if(stristr($caption,$english[$key])==true and $settings['english']=="yes"){
      var_dump(bot("deleteMessage",[
        "chat_id"=>$chat_id,
        "message_id"=>$msgid
      ]));
    }
  }
}
 if(isset($update->edited_message->entities) and $update->edited_message->chat->type!="private"){
   $array=json_decode(file_get_contents('php://input'),true);
if($id!=$sudo and strstr("$adminlist","$id")==false){
     foreach($array['edited_message']['entities'] as $key=>$value){
       $t=$array['edited_message']['entities'][$key]['type'];
       if($t=="mention" and $settings['username']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="url" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="hashtag" and $settings['hashtag']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="text_link" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="bold" and $settings['bold']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="code" and $settings['code']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="italic" and $settings['italic']=="yes"){
        var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }
     }
 }}elseif(isset($update->edited_message->caption_entities) and $update->edited_message->chat->type!="private"){
   $array=json_decode(file_get_contents('php://input'),true);
 if($id!=$sudo and strstr("$adminlist","$id")==false){
     $settings=json_decode(file_get_contents("$chat_id/settings.json"),true);
     foreach($array['edited_message']['caption_entities'] as $key=>$value){
       $t=$array['edited_message']['caption_entities'][$key]['type'];
       if($t=="mention" and $settings['username']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="url" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="hashtag" and $settings['hashtag']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="text_link" and $settings['link']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="bold" and  $settings['bold']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="code" and $settings['code']=="yes"){
         var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }elseif($t=="italic" and $settings['italic']=="yes"){
        var_dump(bot("deleteMessage",[
           "chat_id"=>$chat_id,
           "message_id"=>$msgid
         ]));
       }
     }
 }}
}

//Ø§ŲØ§ŲØą Ø§ØļØ§ŲŲØŠ//

$from_id    = $message->from->id;
$msgs = json_decode(file_get_contents('msgs.json'),true);
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
if($message){
$msgs['msgs'][$chat_id][$from_id] = ($msgs['msgs'][$chat_id][$from_id]+1);
file_put_contents('msgs.json', json_encode($msgs));}
$msgmemo = $msgs['msgs'][$chat_id]
[$from_id];
$user = $message->from->username; 

if($update->message->text=="ØĒŲØšŲŲ" and $id==$sudo){
mkdir("$chat_id");
$id = $message->from->id;
  var_dump(bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>" âŽŲââââââââââââ­
 âĒ ØĒŲ ØĒŲØšŲŲ Ø§ŲŲØŦŲŲØšŲ ââĢ
@tareq01
â¯âââââââââââŲâ°",
  'reply_to_message_id'=>$message->message_id,
    ]));
 }
$XT1XT1 = array("-ØĩŲ ØšŲŲ Ø§ŲŲØ¨Ų đ¸","- ØĩŲØ­ØĒ ŲŲ ØŦŲØĒ đ¤","- Ø¯ŲØŽØĒŲŲ Ø´Ų Ø¨Ø¯Ų đĄ","- ŲØ¨ŲŲ ØĒØ§ŲØąŲŲ Ø¨Ø´Ų đģ"); 
if($text == "Ø¨ŲØĒ"){
$rembo = array_rand($XT1XT1, 1);
bot('sendMessage',[
'chat_id'=>$chat_id, 
"text"=>$XT1XT1[$rembo], 
'reply_to_message_id'=>$message->message_id
]); 
}
$a = "https://t.me/tareq1979"; 
if($text == "ŲŲŲ"){ 
$dev_i = array( 
"[  ŲŲŲØ§ØĒ]($a)", 
"[ ŲŲØ§ ŲØ§ŲŲŲ ]($a)", 
"[ ŲŲØ§ Ø­Ø¨Ų ]($a)", 
"[ ŲŲØ§ŲØ§ØĒ ŲŲØąØĒŲØ§]($a)", 
"[  ŲØ§ ŲŲØ§ Ø¨ŲŲđđ]($a)", 
"[ ŲŲØ§ Ø¨ŲŲŲØą đ]($a)", 
"[ ŲŲØ§ Ø¨ŲŲØ§ŲØĩđ]($a)",); 
$dev_a = array_rand($dev_i, 1); 
bot('sendMessage',[ 
'chat_id'=>$chat_id, 
'parse_mode'=>'MarkDown', 
'disable_web_page_preview'=>true, 
"text"=>$dev_i[$dev_a], 
'reply_to_message_id'=>$message->message_id 
]); 
}
if($text == 'ØĒŲØšŲŲ'){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"ŲØ´ØĒØēŲ Ø¨Ø¯ŲŲ ØĒŲØšŲŲ Ø­Ø¨ŲØ¨Ų",
]);
}
date_default_timezone_set('Asia/Aden');

if($text =="Ø§ŲŲŲØĒ"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
đâŖ Ø§ŲØ¯ŲŲØŠ : ØŗŲØąŲØŠ \n" . "  đâŖ Ø§ŲØŗŲØŠ : " . date("Y") . "\n" . "  đâŖ Ø§ŲØ´ŲØą : " . date("n") . "\n" . "  đâŖ Ø§ŲŲŲŲ :" . date("j") . "\n" . "â°âŖ Ø§ŲØŗØ§ØšŲ :" . date('g:i') . "\n" . "â â â â â â â  
dev ~ @tareq01
đĄâCh ~âĒŧ @tareq1979",
'reply_to_message_id'=>$message->message_id
]);
}
$token = "1130707224:AAFu9Wc_nOTTeR_8BV7eFM4cFtoQKnlPvdg";  //ØĒŲŲŲ Ø§ŲØ¨ŲØĒ 
$dev = array("500276966"); //Ø§ŲØ¯ŲŲ Ø§ŲŲØˇŲØą 
$edit_chat_id=$update->edited_message->chat->id; $edit_from_id=$update->edited_message->message->from->id; $chat_id=$update->message->chat->id; $from_id=$update->message->from->id; $re_id= $update->message->reply_to_message->from->id; $re_name= $update->message->reply_to_message->from->first_name; $re_usr= $update->message->reply_to_message->from->username; $reply = $update->message->reply_to_message; $first_name=$update->message->from->first_name; $username = $update->message->from->username; $Bots_info= file_get_contents("https://api.telegram.org/bot$token/getMe"); $json_Bots= json_decode($Bots_info,true); $id_Bot=$json_Bots['result']['id']; $info= json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$chat_id&user_id=".$from_id), true); $suorse=$info['result']['status']; $admins= "administrator"; $managers= "creator"; $infos= json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$edit_chat_id&user_id=".$edit_from_id), true); $suorses = $infos['result']['status']; $bot = file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$chat_id&user_id=$id_Bot"); 
if(in_array($from_id,$dev)){$info = "ŲØˇŲØą Ø§ØŗØ§ØŗŲ";}elseif($suorse == $managers){$info = "ŲŲØ´Ų Ø§ŲŲØŦŲŲØšØŠ";}elseif($suorse == $admins ){$info = "ŲØ´ØąŲ Ø§ŲŲØŦŲŲØšØŠ";}elseif($suorse == "member" ){$info = "ŲŲØˇ ØšØļŲ";} 
if(!$username){ $usr = "ŲØ§ ŲŲØŦØ¯ ŲØšØąŲ";}elseif($username){$usr = "@$username";} if(!$re_usr){$usrri = "ŲØ§ ŲŲØŦØ¯ ŲØšØąŲ";}elseif($re_usr){$usrri = "@$re_usr";} 
if(!$reply && $text=="Ø§ŲØ¯Ų" || !$reply && $text == "id" ){ 
$name_infos = array( 'ØąÛÛâØšŲŲÚžŲâē','ØĩŲØąØŠ ŲŲØˇŲ ØēŲØąŲØ§ đ¤','ØēŲØąŲØ§ ŲØ§ Ø­ŲŲØŠ',); $name_info = array_rand($name_infos,1); $result=json_decode(file_get_contents("https://api.telegram.org/bot$token/getUserProfilePhotos?user_id=$from_id"),true); $file_id=$result["result"]["photos"][0][0]["file_id"]; $count=$result["result"]["total_count"]; var_dump(bot("sendphoto",["chat_id"=>$chat_id, 
"caption"=>"đ¸ÂĻ ØĩŲØąØĒŲ $name_infos[$name_info]\nđ¨âđ¤ÂĻ Ø§ØŗŲŲ $first_name \nđĨÂĻ ŲØšØąŲŲ [$usr]\nđÂĻ Ø§ŲØ¯ŲŲ $from_id\nđÂĻ ØąØĒØ¨ØĒŲ $info\nđÂĻ ØšØ¯Ø¯ ØĩŲØąŲ $count","photo"=>"$file_id",'disable_web_page_preview'=>true,'reply_to_message_id'=>$message->message_id,]));} 
if($reply && $text=="Ø§ŲØ¯Ų" || $reply && $text == "id" ){if( $re_id != $id_Bot ){ 
$name_infos = array( 'ØąÛÛâØšŲŲÚžŲâē','ØĩŲØąØŠ ŲŲØˇŲ ØēŲØąŲØ§ đ¤','ØēŲØąŲØ§ ŲØ§ Ø­ŲŲØŠ',); $name_info = array_rand($name_infos,1); $result=json_decode(file_get_contents("https://api.telegram.org/bot$token/getUserProfilePhotos?user_id=$re_id"),true); $file_id=$result["result"]["photos"][0][0]["file_id"]; $count=$result["result"]["total_count"]; var_dump(bot("sendphoto",["chat_id"=>$chat_id, 
"caption"=>"đ¸ÂĻ ØĩŲØąØĒŲ $name_infos[$name_info]\nđ¨âđ¤ÂĻ Ø§ØŗŲŲ $re_name \nđĨÂĻ ŲØšØąŲŲ [$usrri]\nđÂĻ Ø§ŲØ¯ŲŲ $re_id\nđÂĻ ØšØ¯Ø¯ ØĩŲØąŲ $count","photo"=>"$file_id",'disable_web_page_preview'=>true,'reply_to_message_id'=>$message->message_id,]));}} 
 $id = $message->from->id;
$sudo = "515106681"; //ŲŲØ§ Ø­Øˇ Ø§ŲØ¯ŲŲ Ø!
$USAIED = json_decode(file_get_contents('php://input'));
$SAIEDM = $USAIED->message;
$SAIEDT = $SAIEDM->text;
$SAIEDC = $SAIEDM->chat->id;
$DSAIED= $USAIED->callback_query;
$DSAIEDD = $DSAIED->data;
$SAIEDNEW = $SAIEDM->new_chat_member;
$SAIEDN = $SAIEDNEW->first_name;
$SAIEDI = $SAIEDNEW->id;
$DSAIEDN = $DSAIED->from->first_name;
$DSAIEDI = $DSAIED->from->id;
$DSAIEDC = $DSAIED->message->chat->id;
mkdir("SAIED");
$SAIEDRO = file_get_contents("SAIED/RO$SAIEDC.txt");
if($SAIEDT == "ØĒŲØšŲŲ Ø§ŲØĒØ­ŲŲ"  and $SAIEDRO != "ON"){
bot('sendmessage',[
'chat_id'=>$SAIEDC,
'text'=>"âĸ ØĒŲ ØĒŲØšŲŲ Ø§ŲØĒØ­ŲŲ ŲŲ Ø§ŲØąŲØ¨ŲØĒØ§ØĒ đ¨ââī¸.
âĸ ØŗŲØĒŲ ØĒŲŲŲØ¯ Ø§Ų Ø´ØŽØĩ ŲŲØļŲ Ø§ŲŲ Ø§ŲŲØŦŲŲØšØŠ ŲŲŲ ŲØŗØĒØˇŲØš Ø§ØąØŗØ§Ų Ø§ŲØąØŗØ§ØĻŲ Ø­ØĒŲ ŲØļØēØˇ ØšŲŲ Ø˛Øą Ø§ŲØ§ ŲØŗØĒ ØąŲØ¨ŲØĒ đ.",
'reply_to_message_id'=>$SAIEDM->message_id,
]);
file_put_contents("SAIED/RO$SAIEDC.txt","ON");
}
if($SAIEDT == "ØĒŲØšŲŲ Ø§ŲØĒØ­ŲŲ"  and $SAIEDRO == "ON"){
bot('sendmessage',[
'chat_id'=>$SAIEDC,
'text'=>"âĸ ØĒŲ ØĒŲØšŲŲ Ø§ŲØĒØ­ŲŲ ŲŲ Ø§ŲØąŲØ¨ŲØĒØ§ØĒ Ø¨Ø§ŲØĒØŖŲŲØ¯ đ¨ââī¸.",
'reply_to_message_id'=>$SAIEDM->message_id,
]);
}
if($SAIEDT == "ØĒØšØˇŲŲ Ø§ŲØĒØ­ŲŲ"  and $SAIEDRO == "ON"){
bot('sendmessage',[
'chat_id'=>$SAIEDC,
'text'=>"âĸ ØĒŲ ØĒØšØˇŲŲ Ø§ŲØĒØ­ŲŲ ŲŲ Ø§ŲØąŲØ¨ŲØĒØ§ØĒ đ.
âĸ Ø§ŲØ§Ų ŲØŗØĒØˇŲØš Ø§Ų Ø´ØŽØĩ ŲŲØļŲ Ø§ŲŲ Ø§ŲŲØŦŲŲØšØŠ Ø§ØąØŗØ§Ų Ø§ŲØąØŗØ§ØĻŲ ŲŲŲØ§ đ.",
'reply_to_message_id'=>$SAIEDM->message_id,
]);
unlink("SAIED/RO$SAIEDC.txt");
}
if($SAIEDT == "ØĒØšØˇŲŲ Ø§ŲØĒØ­ŲŲ"  and $SAIEDRO != "ON"){
bot('sendmessage',[
'chat_id'=>$SAIEDC,
'text'=>"âĸ ØĒŲ ØĒØšØˇŲŲ Ø§ŲØĒØ­ŲŲ ŲŲ Ø§ŲØąŲØ¨ŲØĒØ§ØĒ Ø¨Ø§ŲØĒØŖŲŲØ¯ đ.",
'reply_to_message_id'=>$SAIEDM->message_id,
]);
}
if($SAIEDNEW and $SAIEDRO == "ON"){
bot('restrictChatMember',[
'chat_id'=>$SAIEDC,
'user_id'=>$SAIEDI,
]);
 bot('sendMessage',[
'chat_id'=>$SAIEDC,
'text'=>"âĸ Ø§ŲŲØ§ Ø¨Ų ŲØ§ [$SAIEDN](tg://user?id=$SAIEDI) â¤ī¸.
âĸ Ø§ŲŲØšØ°ØąØŠ ØĒŲ ØĒŲŲŲØ¯Ų ŲŲ Ø§ØąØŗØ§Ų Ø§ŲØąØŗØ§ØĻŲ â ī¸.
âĸ ŲØąØŦŲ Ø§ŲØļØēØˇ ØšŲŲ ØŖŲØ§ ŲØŗØĒ ØąŲØ¨ŲØĒ Ø§ŲŲŲØŦŲØ¯ØŠ ŲŲ Ø§ŲØŖØŗŲŲ Ø­ØĒŲ ŲØĒŲ ŲŲ Ø§ŲØĒŲŲŲØ¯ ØšŲŲ đ.",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[["text"=>"âĸ Ø§ŲØ§ ŲØŗØĒ ØąØ¨ŲØĒ đ","callback_data"=>"RoBot-$SAIEDI"]],
]])
]);
}
$ROSAIED = explode('-', $DSAIEDD);
if($DSAIEDD == "RoBot-$ROSAIED[1]" and $DSAIEDI == $ROSAIED[1]){
bot('promoteChatMember',[
'chat_id'=>$DSAIEDC,
'user_id'=>$DSAIEDI,
]);
bot('EditMessageText',[
'chat_id'=>$DSAIEDC,
'message_id'=>$DSAIED->message->message_id,
'text'=>"âĸ ØŖŲŲØ§ Ø¨Ų ŲØ§ [$DSAIEDN](tg://user?id=$DSAIEDI) â¤ī¸.
âĸ ØĒŲ Ø§ŲØēØ§ØĄ Ø§ŲØĒŲŲŲØ¯ ØšŲŲ Ø¨ŲØŦØ§Ø­ ŲŲŲŲŲ Ø§ØąØŗØ§Ų Ø§ŲØąØŗØ§ØĻŲ Ø§ŲØĸŲ đ.",
'parse_mode'=>"MarkDown",
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$DSAIED->id,
'text'=>"âĸ Ø§ŲØŖŲØą ŲŲØŗ ŲŲ đ", 
]);
}
$reply = $update->message->reply_to_message;
$re_id      = $update->message->reply_to_message->from->id;
$API_KEY = API_KEY;
$get = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$chat_id&user_id=".$re_id);
$info = json_decode($get, true);
$re_rou = $info['result']['status'];
$namesaeedh = $update->message->reply_to_message->from->first_name;
$usersaeedh = $update->message->reply_to_message->from->username;
$idsaeedh = $update->message->reply_to_message->from->id;

if($reply and $text == "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ØĒŲ"){
if($re_id == $sudo)
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh  }
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ ŲØˇŲØą Ø§ØŗØ§ØŗŲ đ¨đģââ
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text == "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ØĒŲ"){
if(in_array($re_id,$dev))
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh  }
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ ŲØˇŲØą Ø§ŲØ¨ŲØĒ đ¨đģââ
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text == "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ŲŲ"){
if(in_array($re_id,$manger) and !in_array($re_id,$dev))
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh  }
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ ŲØ¯ŲØą Ø§ŲØ¨ŲØĒ đ¨đŋââī¸
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text ==  "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ØĒŲ"){
if($re_rou == "creator" and $re_id != $sudo and !in_array($re_id,$dev) and !in_array($re_id,$manger) and !in_array($re_id,$getCCmember))
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh } 
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ Ø§ŲŲŲØ´ŲØĄ đˇ
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text ==  "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ŲŲ"){
if($re_rou == "administrator" and $re_id != $sudo and !in_array($re_id,$dev) and !in_array($re_id,$manger))
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh } 
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ Ø§Ø¯ŲŲ ŲŲ Ø§ŲØ¨ŲØĒ đ¨đŧâđ
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text ==  "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ØĒŲ"){
if(in_array($re_id,$getCCmember) and !in_array($re_id,$manger) and !in_array($re_id,$dev) and $re_rou != "administrator")
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh  }
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ ØšØļŲ ŲŲŲØ˛ đ¨
đĩđģī¸ââī¸ÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}
if($reply and $text ==  "ŲØ´Ų" || $text == "ŲØšŲŲŲØ§ØĒŲ"){
if($re_rou == "member" and $re_id != $sudo and !in_array($re_id,$dev) and !in_array($re_id,$manger) and !in_array($re_id,$getCCmember))
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"đ¤ĩđŧÂĻ Ø§ŲØ§ØŗŲ Âģ { $namesaeedh }
đĢÂĻ Ø§ŲØ§ŲØ¯Ų Âģ { $idsaeedh  }
đÂĻ Ø§ŲŲØšØąŲ Âģ{ @$usersaeedh }
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ ŲŲØˇ ØšØļŲ đđŧââī¸
đĩđģââÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØąØ¯
â",'reply_to_message_id'=>$message->message_id,]);}



$betr = str_replace("ŲØ´Ų ","$betr",$text); 
if($text == "ŲØ´Ų $betr"){
$dets = json_decode(file_get_contents("http://api.telegram.org/bot".API_KEY."/getChat?chat_id=$betr"));
$ali4 =$dets->result->first_name;
$ali2 =$dets->result->id;
$ali3 =$dets->result->username;
$get = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$chat_id&user_id=".$betr);
$Alsh = json_decode($get, true);
$re_ru = $Alsh['result']['status'];
$result = json_decode(file_get_contents("https://api.telegram.org/bot$API_KEY/getUserProfilePhotos?user_id=$betr"),true); 
$file_id = $result["result"]["photos"][0][0]["file_id"]; 
$count = $result["result"]["total_count"];
if(in_array($betr,$dev)){
$Alsh = "ŲØˇŲØą Ø§ØŗØ§ØŗŲ đˇ.";
}elseif($re_ru == "creator"){
$Alsh = "ŲŲØ´Ų Ø§ŲŲØŦŲŲØšØŠ đĩ.";
}elseif($re_ru == "administrator"){
$Alsh = "ŲØ´ØąŲ Ø§ŲŲØŦŲŲØšØŠ đŽ.";
}elseif($re_ru == "member" ){
$Alsh = "ØšØļŲ ŲŲØˇ īŋŊ
īŋŊ.";}
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"
đÂĻ Ø§ŲØ§ØŗŲ Âģ â˛ $ali4 âŗ
đĢÂĻ Ø§ŲØ¯ŲŲ Âģ â˛ $ali2 âŗ
đÂĻ Ø§ŲŲØšØąŲ Âģ â˛ @$ali3 âŗ
đŦÂĻ ØšØ¯Ø¯ ØĩŲØąØŠ Âģ â˛ $count âŗ
đŽÂĻ Ø§ŲØąØĒØ¨Ų Âģ â˛ $Alsh âŗ
đÂĻ ŲŲØš Ø§ŲŲØ´Ų Âģ Ø¨Ø§ŲØ§ŲØ¯Ų",
'reply_to_message_id'=>$message->message_id,
]);
}
$id = $message->from->id;
$sudo = "500276966"; //ŲŲØ§ Ø­Øˇ Ø§ŲØ¯ŲŲ Ø!
mkdir("iBadlz");
mkdir("iBadlz/$chat_id");
$put = file_get_contents("iBadlz/$chat_id/link.txt");
$link = file_get_contents("iBadlz/$chat_id/put.txt");
$ex = explode("\n",$put);
if( $text == "ØļØš ØąØ§Ø¨Øˇ" || $text == "ŲØļØš ØąØ§Ø¨Øˇ" and $id == $sudo){
file_put_contents("iBadlz/$chat_id/put.txt","link");
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"
đÂĻ Ø­ØŗŲØ§ Ø Ø§ØąØŗŲ ŲŲ ØąØ§Ø¨Øˇ Ø§ŲŲØŦŲŲØšŲÛ Ø!
",
'reply_to_message_id'=>$message->message_id
]);
}
if( $text == "ŲØļØš ØąØ§Ø¨Øˇ" || $text == "ØļØš ØąØ§Ø¨Øˇ" and $id != $sudo){
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>" 
ØšØ°ØąØĸ ØĩØ¯ŲŲŲ Ø! ŲŲØŗ ŲØ¯ŲŲ ØĩŲØ§Ø­ŲØ§ØĒ ŲØļØš Ø§ŲØąØ§Ø¨Øˇ đđØĄ
",
'reply_to_message_id'=>$message->message_id
]);
}
if($text and $link == "link"){
file_put_contents("iBadlz/$chat_id/link.txt",$text);
file_put_contents("iBadlz/$chat_id/put.txt"," ");
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"
đŦÂĻ ØĒŲ Ø­ŲØ¸ Ø§ŲØąØ§Ø¨Øˇ Ø§ŲØŽØ§Øĩ Ø¨Ø§ŲŲØŦŲŲØšŲÛ Ø!
",
'reply_to_message_id'=>$message->message_id
]);
}
if($text == "Ø§ŲØąØ§Ø¨Øˇ" or $text == "ØąØ§Ø¨Øˇ"){
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>" ØąØ§Ø¨Øˇ Ø§ŲŲØŦŲŲØšŲ ŲŲ : $put",
'reply_to_message_id'=>$message->message_id
]);
}
if( $text == "ŲØŗØ­ Ø§ŲØąØ§Ø¨Øˇ" || $text == "Ø­Ø°Ų Ø§ŲØąØ§Ø¨Øˇ" and $id == $sudo){
file_put_contents("iBadlz/$chat_id/link.txt"," ");
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"
ØĒŲ Ø­Ø°Ų Ø§ŲØąØ§Ø¨Øˇ Ø§ŲØŽØ§Øĩ Ø¨Ų
",
'reply_to_message_id'=>$message->message_id
]);
}
if( $text == "ŲØŗØ­ Ø§ŲØąØ§Ø¨Øˇ" || $text == "Ø­Ø°Ų Ø§ŲØąØ§Ø¨Øˇ" and $id != $sudo){
 bot('sendmessage',[
 'chat_id'=>$chat_id,
 'text'=> "
 Ø§ŲŲØšØ°ØąŲ ØĩØ¯ŲŲŲ ŲŲØŗ ŲØ¯ŲŲ ØĩŲØ§Ø­ŲØ§ØĒ ŲØŗØ­ Ø§ŲØąØ§Ø¨Øˇ
 ",
 'reply_to_message_id'=>$message->message_id
 ]);
 }


_contents("iBadlz/$chat_id/link.txt",$text);
file_put_contents("iBadlz/$chat_id/put.txt"," ");
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"
đŦÂĻ ØĒŲ Ø­ŲØ¸ Ø§ŲØąØ§Ø¨Øˇ Ø§ŲØŽØ§Øĩ Ø¨Ø§ŲŲØŦŲŲØšŲ