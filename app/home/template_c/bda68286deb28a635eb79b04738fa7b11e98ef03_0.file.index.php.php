<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:58:42
  from '/home/sky/www/app/home/view/index.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3cedc21652b2_92145551',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bda68286deb28a635eb79b04738fa7b11e98ef03' => 
    array (
      0 => '/home/sky/www/app/home/view/index.php',
      1 => 1782366359,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3cedc21652b2_92145551 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($_smarty_tpl->tpl_vars['S']->value == '') {?>
        <title>教程</title>
    <?php } else { ?>
        <title><?php echo $_smarty_tpl->tpl_vars['S']->value;?>
 | 教程</title>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['Images']->value == '') {?>
        <link rel="shortcut icon" href="../../images/favicon.ico" />
        <link rel="stylesheet" href="css/index.css" />
    <?php } else { ?>
        <link rel="shortcut icon" href="../../images/<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['Images']->value;?>
.png" />
        <link rel="stylesheet" href="css/main.css" />
    <?php }?>
    <link rel="stylesheet" href="css/base.css" />   
    <link rel="stylesheet" href="css/public.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/index.js"><?php echo '</script'; ?>
> 
</head>
<body>
    
    <!-- 导航栏 start-->
    <div class="nav">
    <div class="container conter">     
     <ul>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Navdata']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['imagesName'] == '') {?>
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="">
                        <a href="/"  onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['item']->value['subject'];?>
</a>
                    </form>
                </li>
            <?php } else { ?>
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['subject'];?>
">
                        <input type="hidden" name="page" value="tutorial">
                        <a href="/"  onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['item']->value['subject'];?>
</a>
                    </form>
                </li>
            <?php }?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
    </div>  
    </div>  
    <!-- 导航栏 end-->
     <!-- 内容 start-->
    <?php if ($_smarty_tpl->tpl_vars['S']->value == '') {?>
     <div class="container clearfix">
        <h2 id="tutorial-title">精品教程</h2>
        <div id="tutorial">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Titledata']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <h4 class="t-type"><?php echo $_smarty_tpl->tpl_vars['item']->value['course'];?>
</h4>
        <ul class="t-list clearfix">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['HomePagedata']->value, 'items');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['items']->value) {
?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['course'] == $_smarty_tpl->tpl_vars['items']->value['course']) {?>
                <?php if ($_smarty_tpl->tpl_vars['items']->value['subject'] == "HTML5") {?>
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
">
                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesName'];?>
-intro">
                        <a href="/"  onclick="this.parentNode.submit(); return false;" class="clearfix">
                            <div class="image">    
                                <img src="../../images/<?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
/<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesName'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesTips'];?>
" align="middle">    
                            </div>    
                            <div class="desc">    
                                <h4><?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
</h4>   
                                <p><?php echo $_smarty_tpl->tpl_vars['items']->value['description'];?>
</p>    
                            </div> 
                        </a>
                    </form>
                </li>
                <?php } else { ?>
                    <li>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="home">
                            <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesName'];?>
-tutorial">
                            <a href="/"  onclick="this.parentNode.submit(); return false;" class="clearfix">
                                <div class="image">    
                                    <img src="../../images/<?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
/<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesName'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['items']->value['imagesTips'];?>
" align="middle">    
                                </div>    
                                <div class="desc">    
                                    <h4><?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
</h4>   
                                    <p><?php echo $_smarty_tpl->tpl_vars['items']->value['description'];?>
</p>    
                                </div> 
                            </a>
                        </form>   
                    </li>
                <?php }?>
            <?php }?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>   
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div> 
    <?php } else { ?>
        <div class="container main" style="height: auto !important;">
            <!-- 中间 -->
            <div class="row" style="height: auto !important;">
                <!-- 左侧栏 -->

                <div class="runoob-col-md2">
                    <div class="left-column" style="">
                        <div class="tab" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            <span><?php echo $_smarty_tpl->tpl_vars['S']->value;?>
 教程</span>
                        </div>
                        <div class="sidebar-box gallery-list">
                            <div class="design" id="leftcolumn">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MainTitledata']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['title'] != $_smarty_tpl->tpl_vars['S']->value) {?>
                                        <br>
                                        <h2 class="left"><span class="left_h2"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</span></h2> 
                                    <?php }?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LeftTitledata']->value, 'items');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['items']->value) {
?>
                                        <?php if ($_smarty_tpl->tpl_vars['items']->value['title'] == $_smarty_tpl->tpl_vars['item']->value['title']) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['items']->value['page'] == $_smarty_tpl->tpl_vars['page']->value) {?>
                                                <form action="/" method="post">
                                                    <input type="hidden" name="p" value="home">
                                                    <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                                    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['page'];?>
">
                                                    <a target="_top" data-p="par" title="<?php echo $_smarty_tpl->tpl_vars['items']->value['a_Tips'];?>
" href="/"  onclick="this.parentNode.submit(); return false;" style="background-color: rgba(150, 185, 125,0.6); font-weight: bold; color: rgba(56, 66, 151,0.77);">
                                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                                        <?php echo $_smarty_tpl->tpl_vars['items']->value['a_content'];?>

                                                    </a>
                                                </form>
                                            <?php } else { ?>
                                                 <form action="/" method="post">
                                                    <input type="hidden" name="p" value="home">
                                                    <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                                    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['page'];?>
">
                                                    <a target="_top" data-p="par" title="<?php echo $_smarty_tpl->tpl_vars['items']->value['a_Tips'];?>
"  href="/"  onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['items']->value['a_content'];?>
</a>
                                                </form>
                                            <?php }?>
                                        <?php }?>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 中间内容 -->
                <div class="col middle-column" style="height: auto !important;">

                    <div class="article" style="height: auto !important;">

                        <!-- 顶部上下篇链接 -->
                        <div class="previous-next-links">
                            <?php if (count($_smarty_tpl->tpl_vars['FrontBackpagedata']->value) == 1) {?>
                                <?php if ($_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['status'] == '0') {?>
                                    <div class="previous-design-link" style="display: none;"> </div>
                                    <div class="next-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                            <a href="/" rel="next" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"> <?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                            <a href="/">
                                                <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="previous-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                            <a href="/"  onclick="this.parentNode.submit(); return false;">
                                                <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                            <a href="/" rel="prev" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                        </form>
                                    </div>
                                    <div class="next-design-link" style="display: none;">
                                    </div>
                                <?php }?>

                            <?php } elseif (count($_smarty_tpl->tpl_vars['FrontBackpagedata']->value) == 2) {?>
                                <div class="previous-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                        </a>
                                        <a href="/"  rel="prev" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                    </form>
                                    
                                </div>
                                <div class="next-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['page'];?>
">
                                        <a href="/" rel="next" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['a_content'];?>
</a>
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                
                                </div>
                            <?php }?> 
                        </div>

                        <!-- 图片显示 -->
                        <div class="article-heading-ad" style="display: block;">
                            <a href="#" target="_blank"><img src="../../images/starry_sky.png" style="witdh=106px;height=900px" data-tt="713908" alt="starry sky"></a>
                        </div>
                        <!-- 文章内容 -->
                        <div class="article-body">
                            <?php echo $_smarty_tpl->tpl_vars['RightContentdata']->value;?>

                        </div>
                        <!-- 文章内容 结束-->
                        <!-- 底部上下篇链接 -->
                        <div class="previous-next-links">
                            <?php if (count($_smarty_tpl->tpl_vars['FrontBackpagedata']->value) == 1) {?>
                                <?php if ($_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['status'] == '0') {?>
                                    <div class="previous-design-link" style="display: none;"> </div>
                                    <div class="next-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                            <a href="/" rel="next" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"> <?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                            <a href="/">
                                                <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="previous-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                            <a href="/"  onclick="this.parentNode.submit(); return false;">
                                                <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                            <a href="/" rel="prev" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                        </form>
                                    </div>
                                    <div class="next-design-link" style="display: none;">
                                    </div>
                                <?php }?>

                            <?php } elseif (count($_smarty_tpl->tpl_vars['FrontBackpagedata']->value) == 2) {?>
                                <div class="previous-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['page'];?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                        </a>
                                        <a href="/"  rel="prev" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[0]['a_content'];?>
</a>
                                    </form>
                                    
                                </div>
                                <div class="next-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="<?php echo $_smarty_tpl->tpl_vars['S']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['page'];?>
">
                                        <a href="/" rel="next" title="<?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['a_Tips'];?>
" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['FrontBackpagedata']->value[1]['a_content'];?>
</a>
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                
                                </div>
                            <?php }?> 
                        </div>
                        <!-- 右边栏 -->
                        <div class="fivecol last right-column">
                        </div>
                    </div>

                </div>
            </div>
        </div>



    <?php }?>
     <!-- 内容 end-->

     <!-- 底部 start-->
    <div class="admin_entry"><a href="/index.php?p=admin&c=Auth&a=login" title="后台管理"><i class="fa-solid fa-user-shield"></i></a></div>
    <div class="up_top"><i class="fa-solid fa-chevron-up" title="回到顶部"></i></div> 
    <div id="UTC"></div> 
     <!-- 底部 end-->

</body>
</html><?php }
}
