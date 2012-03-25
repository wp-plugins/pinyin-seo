<?php
/*
Pinyin SEO
http://www.xuewp.com/pinyin-seo/
拼音SEO插件可在文章发布时自动将文章标题由中文转换成拼音格式，当前拼音数据库包含20966字，繁简通用，更有利于百度SEO,baidu就是最好的证明。下一版将添加简单多音字功能。This plugin will convert Chinese characters to Pinyin(Latin alphabet for the romanization of Mandarin Chinese)in post title for SEO purpose.
Author: Chao Wang
http://www.xuewp.com/
*/
if (isset($_POST['submit'])) {
      if ( function_exists('current_user_can') && !current_user_can('manage_options') )
            die(__('您没有访问权限', 'pinyin_seo'));
        check_admin_referer( 'pinyin_seo-options_update');
$pinyin_seo_update=array(
         'pinyin_format' =>(trim($_POST['pinyin_format']) != '' ) ? trim($_POST['pinyin_format']) : $pinyin_seo_option_defaults['pinyin_format'],
		 'pinyin_separator' =>(trim($_POST['pinyin_separator']) != '' ) ? trim($_POST['pinyin_separator']) : $pinyin_seo_option_defaults['pinyin_separator']);
		update_option('pinyin_seo', $pinyin_seo_update);
		$pinyin_seo_options=get_option('pinyin_seo');
		    if (function_exists('wp_cache_flush')) {
	     wp_cache_flush();
	}
}
if($_POST['reset_postname']){
		reset_postname_to_pinyin();
	}
if($_POST['reset_category_slug']){
		reset_category_slug_to_pinyin();
	}
if($_POST['reset_tag_slug']){
		reset_tag_slug_to_pinyin();
	}
?>
<?php if ( !empty($_POST['submit'] ) ) : ?>
<div id="message" class="updated"><p><strong><?php _e('设置已更新。', 'pinyin_seo') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2>拼音SEO插件设置:</h2>
当前版本：<?php _e(PINYINSEO_VERSION, 'pinyin_seo') ?> <a href="http://www.xuewp.com/pinyin-seo/" title="拼音SEO官方主页">xuewp</a>出品
<p>使用本插件前，请先将您的<a href="/wp-admin/options-permalink.php">wordpress的固定链接(permalink)</a>设置成 <h4>文章名 ， /%postname%/  ， 或者是自定义如 ， 分类/文章名 ， /%category%/%postname%/ ，或者结尾加htm或html ， /%postname%.htm  ， /%category%/%postname%.html  </h4> 类似这样的格式，一定要要有postname，否则本插件不会生效。</p>
<form method="post">
 <?php wp_nonce_field('pinyin_seo-options_update'); ?>
<table class="form-table">
         <tr valign="top">
          <th scope="row"><strong>拼音设置：</strong></th>
           <td>作用于文章和页面标题的永久链接post_name以及分类目录标签别名slug:</td>
          </tr>
		  <tr valign="top">
          <th scope="row">拼音分隔符 separator:</th>
     <td>
          <input type="radio" name="pinyin_separator" value="-" <?php if( $pinyin_seo_options['pinyin_separator']=='-')echo 'checked';?> >中横线-  拼音格式： pin-yin-ge-shi （推荐）
    </td>
	<tr valign="top"><td></td><td><input type="radio" name="pinyin_separator" value="_" <?php if( $pinyin_seo_options['pinyin_separator']=='_')echo 'checked';?>  >下划线_  拼音格式： pin_yin_ge_shi </td></tr>
          </tr>    
		  <tr valign="top"><td></td><td><input type="radio" name="pinyin_separator" value="no" <?php if( $pinyin_seo_options['pinyin_separator']=='no')echo 'checked';?>  >不使用分隔  拼音格式： pinyingeshi （不推荐）</td></tr>
          </tr>
		  		  <tr valign="top">
          <th scope="row">拼音大小写:</th>
     <td>
          <input type="radio" name="pinyin_format" value="lower" <?php if( $pinyin_seo_options['pinyin_format']=='lower')echo 'checked';?> >拼音全部小写字母（默认设置） 例：xiao
    </td>
	<tr valign="top"><td></td><td><input type="radio" name="pinyin_format" value="ucwords" <?php if( $pinyin_seo_options['pinyin_format']=='ucwords')echo 'checked';?>  >拼音首字母大写 例：Xiao</td></tr>
          </tr>    
		  <tr valign="top"><td></td><td><input type="radio" name="pinyin_format" value="upper" <?php if( $pinyin_seo_options['pinyin_format']=='upper')echo 'checked';?>  >拼音全部大写字母 例：XIAO</td></tr>
          </tr>
          </table>
        <p class="submit">
         <input type="submit" name="submit" value=" 更新设置&raquo; " />
       </p>
	   <h2>重置所有文章永久链接(post_name)，把wp_posts表中post_name字段写成拼音格式</h2>
	  <p>请先在上面设定好您所要使用的拼音分隔符是中横线"-"还是下划线"_"以及拼音的大小写格式,然后再执行本操作。</p>
	 <p>如果您之前不是采用文章名 <strong>/%postname%/</strong> 作为链接格式的，只需要点击下面的<strong>重置文章永久链接</strong>即可重写数据库中全部文章和页面的post_name字段写成拼音格式。</p>
	 <p>此外还有个功能，例如您变更了拼音分隔符，通过此项操作可以使所有文章拼音分隔符一致。</p>
	<p>此操作涉及mysql数据库的操作，因此建议先备份wordpress数据库后再作操作。</p>
	<h4>警告：此操作会对所有文章的永久链接产生影响，若您的文章较多，请慎重考虑，或者使用301转向插件，以免对百度seo产生不利的影响。建议备份下数据库，有备无患。</h4>
	<p class="submit">
         <input type="submit" name="reset_postname" value=" 重置文章永久链接&raquo; " />
       </p>
	    <h2>重置所有分类目录和标签的永久链接(slug)，把wp_terms表中slug字段写成拼音格式</h2>
		<p>重写文章，分类，标签的永久链接时，拼音格式设置必须一致，建议一次成功后就不要再折腾，如果重写分类category后出现404错误，则编辑任意一个分类，然后更新就好了。</p>
		<p>建议分类目录别名category slug自己手写成不含分隔符的格式，以免和标签名称重复，标签前缀加个 tag，以免和文章名称重复。</p>
		<p>文章较多，排名较好的网站建议就不要瞎折腾了，呵呵。</p>
		<h4>特别注意事项:下面两项操作建议在本地测试成功后，再把数据库上传到服务器覆盖更新。</h4>
	    <p class="submit">
         <input type="submit" name="reset_tag_slug" value=" 重置标签tag slug&raquo; " />
       </p>
	    <p class="submit">
         <input type="submit" name="reset_category_slug" value=" 重置分类目录category slug&raquo; " />
       </p>
     </form>
	<p>感谢您使用拼音SEO插件，祝您的网站在搜索引擎里有良好排名，若您有任何意见或扩展建议，欢迎在<a href="http://www.xuewp.com/pinyin-seo/">拼音SEO插件主页</a>留言</p>
<p>另向大家征集中文标题里常见的多音字，下一版将添加简单的多音字处理功能，需要词库。</p>
<p>其他xuewp.com出品的插件：<a href="http://www.xuewp.com/chinese-captcha/">Wordpress中文验证码</a></p>
  </div>
