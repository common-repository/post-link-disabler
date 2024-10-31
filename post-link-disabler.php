<?php
/*
Plugin Name: Post Links Disabler
Plugin URI: http://asifsaho.me
Description: This plugin will disable all links from post. Just install and activate. Thats simple huh :)
Version: 1.0
Author: asifsaho
Author URI: http://asifsaho.me
*/

class disable_outgoing_links {}
	function disable_outgoin_link_analyze($matches)
	{
	  global $disable_outgoing_links_analyze;
	  for($i=0;$i<sizeof($disable_outgoing_links_analyze->exclude_links);$i++)
	  if($disable_outgoing_links_analyze->exclude_links[$i])
	  if(stripos($matches[2] . '//' .$matches[3],$disable_outgoing_links_analyze->exclude_links[$i])===0)
	  return '<!--a href="' . $matches[2] . '//' . $matches[3] . '"-->' . $matches[5] . '<!--/a-->';
	  $url=($matches[2] . '//' . $matches[3]);
	  $text=$matches[5];
	   return $text;
	}
class disable_outgoing_links_analyze extends disable_outgoing_links
{
	function disable_outgoing_links_analyze()
	{
	  $this->set_filters();
	  $this->exclude_links=array();
	  $this->site=get_option('home');
	  $this->exclude_links[]=$this->site;
	  $this->exclude_links[]='javascript';
	  $this->exclude_links[]='#';
	  $exclude=@explode("\n",$exclude);
	  for($i=0;$i<sizeof($exclude);$i++)
	  $this->exclude_links[]=trim($exclude[$i]);
	}
	function filter($content)
	{
	  global $post;
	  $pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
	  $content = preg_replace_callback($pattern,'disable_outgoin_link_analyze',$content);
	  $content = str_replace($patterns,'',$content);
	  return $content;
	}
	function set_filters()
	{
		add_filter('the_content',array($this,'filter'),99);
		add_filter('the_excerpt',array($this,'filter'),99);
	}
}
$disable_outgoing_links_analyze=new disable_outgoing_links_analyze();
?>
