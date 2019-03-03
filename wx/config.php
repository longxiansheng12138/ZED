<?php 
return [
	'text' => "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
			</xml>",
	'image' => "<xml>
  					<ToUserName><![CDATA[%s]]></ToUserName>
  					<FromUserName><![CDATA[%s]]></FromUserName>
  					<CreateTime>%s</CreateTime>
  					<MsgType><![CDATA[image]]></MsgType>
  					<Image>
  					  <MediaId><![CDATA[%s]]></MediaId>
  					</Image>
				</xml>",
	'news' => "<xml>
  				<ToUserName><![CDATA[%s]]></ToUserName>
  				<FromUserName><![CDATA[%s]]></FromUserName>
  				<CreateTime>%s</CreateTime>
  				<MsgType><![CDATA[news]]></MsgType>
  				<ArticleCount>1</ArticleCount>
  				<Articles>
  				  <item>
  				    <Title><![CDATA[%s]]></Title>
  				    <Description><![CDATA[%s]]></Description>
  				    <PicUrl><![CDATA[%s]]></PicUrl>
  				    <Url><![CDATA[%s]]></Url>
  				  </item>
  				</Articles>
			</xml>"
];