===Pinyin SEO===
Contributors: Chao Wang
Donate link: http://www.xuewp.com/pinyin-seo/
Tags: pinyin,SEO,slug,permalink,chinese romanization,Chinese characters
Requires at least: 2.1
Tested up to: 3.3.1
Stable tag: trunk

拼音SEO插件将文章标题，分类目录以及标签的永久链接转换成拼音。Convert Chinese characters to Pinyin Permalinks. 

== Description ==

拼音SEO插件可在文章发布时将中文标题将或者分类目录以及标签的永久链接转换成拼音格式。

*   可以设定单独对文章的永久链接使用拼音，而不对分类目录和标签使用拼音。
*   繁简通用，更有利于百度SEO，baidu就是最好的证明。
*   本拼音数据库共收录**20966汉字，繁简通用**，已包括中日韩统一表意文字U+4E00..U+9FA5范围所有汉字，韩国和日本造的汉字，均按形声字方法注音。
*   一字一音，2.0版将添加简单多音字功能。

*   This plugin will convert Chinese characters to Pinyin(Latin alphabet for the romanization of Mandarin Chinese)Permalinks and slugs for SEO purpose.
*   Including 20966 chinese characters in CJK unicode range U+4E00..U+9FA5。
*   Support either Simplified or Traditional Chinese charaters.

包含功能：

*   设定拼音分隔符
*   设定拼音大小写格式
*   某些用户觉得中文的tag标签seo效果更好，为此新增加了功能，可以设定不对分类目录和标签使用拼音。
*   **以下两项功能涉及数据库操作，建议先备份数据库后在本地操作**。
*   重置所有文章永久链接(post_name)，把wp_posts表中post_name字段写成拼音格式
*   重置所有分类目录和标签的永久链接(slug)，把wp_terms表中slug字段写成拼音格式

建议：

*   分类目录不使用拼音分隔符，每次添加新的分类目录时手工修改，即pinyinfengefu这样的形式，以便和标签有所区别。
*   标签前缀加tag，以免和文章页面有所区别。标签和文章及页面均使用pin-yin-ge-shi这样的形式。

官方演示/Demo: 

[**Wordpress拼音SEO插件官方站点演示**](http://www.xuewp.com/pinyin-seo/ "Wordpress拼音SEO插件")  如果您有任何问题或建议也可以留言，谢谢支持。

作者的其他插件：[**Wordpress中文验证码**](http://www.xuewp.com/chinese-captcha/ "Wordpress中文验证码，汉字的，中国的") 

== Installation ==
1. Search 'pinyin seo' through the 'Add new plugins' page in Wordpress
1. 在 Wordpress 的'添加新插件' 页里搜索 'pinyin seo'
2. Select 'install plugin', and select 'active plugin' after downloaded
2. 选择 '安装插件'，然后再选择 '启用插件'
Or 
或者
1. Download and uncompress 'pinyin-seo' package to the '/wp-content/plugins/' directory
1. 下载并解压 'pinyin-seo' 压缩包到 '/wp-content/plugins/' 目录下
2. Activate the plugin through the 'Plugins' menu in Wordpress
2. 在 Wordpress 的 '插件' 菜单项里启用

== Frequently Asked Questions ==
N/A
暂时没有FAQ

== Screenshots ==
1. 效果页面
2. pinyin seo插件设置页面

== Changelog ==

= 1.0 =
* First release.
* 第一版
* Including 20966 chinese characters including CJK unicode range U+4E00..U+9FA5。Support either Simplified or Traditional Chinese charaters.
* 可以转换包括中日韩统一表意文字U+4E00..U+9FA5范围内所有汉字的共20966个。繁简通用。

= 1.1 =
* Add function to enable pinyin-seo in category and tag slugs or not.
* 增加了是否对分类目录和标签的slug启用拼音的控制功能。
* Set no time limit when rewriting the permalinks.
* 解决了进行重置拼音链接时PHP的30秒自动超时问题。

== Upgrade Notice ==

= 1.0 =
* 想设置标签不使用拼音的，必须升级。
* 想把超过500条post记录重写成拼音永久链接的用户必须升级。