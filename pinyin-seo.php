<?php
/*
Plugin Name: Pinyin SEO(拼音SEO)
Plugin URI: http://www.xuewp.com/pinyin-seo/
Description: 拼音SEO插件可在文章发布时自动根据文章中文标题将永久链接转换成拼音格式，当前拼音数据库包含20966字，繁简通用，更有利于百度SEO，baidu就是最好的证明。下一版将添加简单多音字功能。This plugin will convert Chinese characters to Pinyin(Latin alphabet for the romanization of Mandarin Chinese)Permalinks for SEO purpose.
Author: Chao Wang<xuewp.com@live.com>
Version: 1.0
Author URI: http://www.xuewp.com/
*/
/*Copyright 2012 Chao Wang (email: xuewp.com@live.com )

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
define('PINYINSEO_VERSION', '1.0');
 if ( ! defined( 'WP_CONTENT_DIR' ) )
       define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
 if ( ! defined( 'WP_PLUGIN_DIR' ) )
       define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$pinyin_seo_option_defaults=array('pinyin_separator'=>'-','pinyin_format'=>'lower');
if(!get_option('pinyin_seo')){
add_option('pinyin_seo', $pinyin_seo_option_defaults, '', 'yes');}
$pinyin_seo_options=get_option('pinyin_seo');

function PinyinSEO($chinese)
{
global $pinyin_seo_options;
$pinyinseparator=$pinyin_seo_options['pinyin_separator'];
$pinyinformat=$pinyin_seo_options['pinyin_format'];
if (get_bloginfo('charset')!="UTF-8") {
	$chinese= iconv(get_bloginfo('charset'), "UTF-8", $chinese);
	}
    $pinyin = array();
    $retitle = '';
	$dat=WP_PLUGIN_DIR .'/pinyin-seo/data/pinyin.dat';
    $chinese = trim($chinese);
    if(count($pinyin)==0 && is_file($dat))//判断pinyin.dat是否存在，若不存在则跳过，以免出现死循环
    {
        $fp = fopen($dat,'r');
        while(!feof($fp))
        {
            $line = trim(fgets($fp));
            $pinyin[$line[0].$line[1].$line[2]] = substr($line,3,strlen($line)-3);//unicode中汉字为3个字节
        }
        fclose($fp);
    }
    for($i=0;$i<strlen($chinese);$i++)//按字节遍历
    {
        if(ord($chinese[$i])>128)//判断是否属于东亚字符集
        {
            $a = $chinese[$i].$chinese[$i+1].$chinese[$i+2];
            if(isset($pinyin[$a]))//如果该汉字的拼音存在
            {
                $retitle.='-'.$pinyin[$a].'-';
            }
			$i+=2;//跳过这个汉字余下的2个字节
        }
		else if( preg_match('/[a-z0-9]/i',$chinese[$i]) )//非汉字的只保留字母和数字
        {
            $retitle .= $chinese[$i];
        }
        else
        {
            $retitle .= '-';
        }
    } 
    $retitle=trim(preg_replace('/-+/', '-', $retitle),'-');
	if($pinyinformat=='ucwords'){
	$retitle=str_replace('-',' ',$retitle);
	$retitle=ucwords($retitle);
	$retitle=str_replace(' ','-',$retitle);
	}
	if($pinyinformat=='upper'){
	$retitle=strtoupper($retitle);
	}
	if($pinyinseparator=='_'){
	$retitle=str_replace('-','_',$retitle);
	}
	if($pinyinseparator=='no'){
	$retitle=str_replace('-','',$retitle);
	}
	return $retitle;
}

function reset_postname_to_pinyin(){
	global $wpdb;
	$posts = $wpdb->get_results("SELECT ID,post_title,post_status,post_name FROM $wpdb->posts ORDER BY id ASC");
	$i=0;
	foreach ($posts as $post) {
		$new_postname = PinyinSEO($post->post_title);
		$sql = "UPDATE $wpdb->posts SET `post_name` = '{$new_postname}' WHERE id = '$post->ID'";
		if($post->post_status=='publish'){
		$update = $wpdb->query($sql);
		$i++;}
	}
	echo " <div class=\"updated\"><p>操作成功：所有文章和页面的永久链接都已经重写! (一共有:<strong> $i </strong>篇文章的永久链接被改写)</p></div>";
}

function reset_category_slug_to_pinyin(){
	global $wpdb;
	$slugs = $wpdb->get_results("SELECT * FROM $wpdb->terms INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id) WHERE $wpdb->term_taxonomy.taxonomy='category' ORDER BY $wpdb->terms.term_id ASC");
	$i=0;
	foreach ($slugs as $slug) {
	    $new_slug = PinyinSEO($slug->name);
		$sql = "UPDATE " . $wpdb->terms . " SET `slug` = '{$new_slug}' WHERE term_id = '$slug->term_id'";
		$update = $wpdb->query($sql);
		$i++;
	}
	echo " <div class=\"updated\"><p>操作成功：所有分类(category)的永久链接都已经重写! (一共有:<strong> $i </strong>个分类(category)的永久链接被改写)</p></div>";
}

function reset_tag_slug_to_pinyin(){
	global $wpdb;
	$slugs = $wpdb->get_results("SELECT * FROM $wpdb->terms INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id) WHERE $wpdb->term_taxonomy.taxonomy='post_tag' ORDER BY $wpdb->terms.term_id ASC");
	$i=0;
	foreach ($slugs as $slug) {
	    $new_slug = PinyinSEO($slug->name);
		$sql = "UPDATE " . $wpdb->terms . " SET `slug` = '{$new_slug}' WHERE term_id = '$slug->term_id'";
		$update = $wpdb->query($sql);
		$i++;
	}
	echo " <div class=\"updated\"><p>操作成功：所有标签(tag)的永久链接都已经重写! (一共有:<strong> $i </strong>个标签(tag)的永久链接被改写)</p></div>";
}

add_filter('sanitize_title', 'PinyinSEO', 1);
add_action('admin_menu', 'PinyinSEO_menu');

function PinyinSEO_menu(){
add_options_page('拼音SEO','拼音SEO', 'manage_options', 'PinyinSEO', 'PinyinSEO_options');
}
function PinyinSEO_options() {
global $pinyin_seo_options,$pinyin_seo_option_defaults;
 require_once('pinyin-seo-admin.php');
}
function delete_pinyinseo_options() {
      delete_option('pinyin_seo');
}
register_deactivation_hook(__FILE__, 'delete_pinyinseo_options');
?>