<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {if $S eq ''}
        <title>教程</title>
    {else}
        <title>{$S} | 教程</title>
    {/if}
    {if $Images eq ''}
        <link rel="shortcut icon" href="../../images/favicon.ico" />
        <link rel="stylesheet" href="css/index.css" />
    {else}
        <link rel="shortcut icon" href="../../images/{$S}/{$Images}.png" />
        <link rel="stylesheet" href="css/main.css" />
    {/if}
    <link rel="stylesheet" href="css/base.css" />   
    <link rel="stylesheet" href="css/public.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script> 
</head>
<body>
    
    <!-- 导航栏 start-->
    <div class="nav">
    <div class="container conter">     
     <ul>
        {foreach $Navdata as $item}
            {if $item.imagesName eq ''}
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="">
                        <a href="/"  onclick="this.parentNode.submit(); return false;">{$item.subject}</a>
                    </form>
                </li>
            {else}
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="{$item.subject}">
                        <input type="hidden" name="page" value="tutorial">
                        <a href="/"  onclick="this.parentNode.submit(); return false;">{$item.subject}</a>
                    </form>
                </li>
            {/if}
        {/foreach}
    </ul>
    </div>  
    </div>  
    <!-- 导航栏 end-->
     <!-- 内容 start-->
    {if $S eq ''}
     <div class="container clearfix">
        <h2 id="tutorial-title">精品教程</h2>
        <div id="tutorial">
        {foreach $Titledata as $item}
        <h4 class="t-type">{$item.course}</h4>
        <ul class="t-list clearfix">
        {foreach $HomePagedata as $items}
            {if $item.course eq $items.course}
                {if $items.subject eq "HTML5"}
                <li>
                    <form action="/" method="post">
                        <input type="hidden" name="p" value="home">
                        <input type="hidden" name="S" value="{$items.subject}">
                        <input type="hidden" name="page" value="{$items.imagesName}-intro">
                        <a href="/"  onclick="this.parentNode.submit(); return false;" class="clearfix">
                            <div class="image">    
                                <img src="../../images/{$items.subject}/{$items.imagesName}.png" alt="{$items.imagesTips}" align="middle">    
                            </div>    
                            <div class="desc">    
                                <h4>{$items.subject}</h4>   
                                <p>{$items.description}</p>    
                            </div> 
                        </a>
                    </form>
                </li>
                {else}
                    <li>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="home">
                            <input type="hidden" name="S" value="{$items.subject}">
                            <input type="hidden" name="page" value="{$items.imagesName}-tutorial">
                            <a href="/"  onclick="this.parentNode.submit(); return false;" class="clearfix">
                                <div class="image">    
                                    <img src="../../images/{$items.subject}/{$items.imagesName}.png" alt="{$items.imagesTips}" align="middle">    
                                </div>    
                                <div class="desc">    
                                    <h4>{$items.subject}</h4>   
                                    <p>{$items.description}</p>    
                                </div> 
                            </a>
                        </form>   
                    </li>
                {/if}
            {/if}
        {/foreach}
        </ul>   
        {/foreach}
    </div> 
    {else}
        <div class="container main" style="height: auto !important;">
            <!-- 中间 -->
            <div class="row" style="height: auto !important;">
                <!-- 左侧栏 -->

                <div class="runoob-col-md2">
                    <div class="left-column" style="">
                        <div class="tab" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            <span>{$S} 教程</span>
                        </div>
                        <div class="sidebar-box gallery-list">
                            <div class="design" id="leftcolumn">
                                {foreach $MainTitledata as $item}
                                    {if $item.title neq $S}
                                        <br>
                                        <h2 class="left"><span class="left_h2">{$item.title}</span></h2> 
                                    {/if}
                                    {foreach $LeftTitledata as $items}
                                        {if $items.title eq $item.title }
                                            {if $items.page eq $page}
                                                <form action="/" method="post">
                                                    <input type="hidden" name="p" value="home">
                                                    <input type="hidden" name="S" value="{$S}">
                                                    <input type="hidden" name="page" value="{$items.page}">
                                                    <a target="_top" data-p="par" title="{$items.a_Tips}" href="/"  onclick="this.parentNode.submit(); return false;" style="background-color: rgba(150, 185, 125,0.6); font-weight: bold; color: rgba(56, 66, 151,0.77);">
                                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                                        {$items.a_content}
                                                    </a>
                                                </form>
                                            {else}
                                                 <form action="/" method="post">
                                                    <input type="hidden" name="p" value="home">
                                                    <input type="hidden" name="S" value="{$S}">
                                                    <input type="hidden" name="page" value="{$items.page}">
                                                    <a target="_top" data-p="par" title="{$items.a_Tips}"  href="/"  onclick="this.parentNode.submit(); return false;">{$items.a_content}</a>
                                                </form>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 中间内容 -->
                <div class="col middle-column" style="height: auto !important;">

                    <div class="article" style="height: auto !important;">

                        <!-- 顶部上下篇链接 -->
                        <div class="previous-next-links">
                            {if count($FrontBackpagedata) eq 1}
                                {if $FrontBackpagedata[0].status eq '0'}
                                    <div class="previous-design-link" style="display: none;"> </div>
                                    <div class="next-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="{$S}">
                                            <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                            <a href="/" rel="next" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;"> {$FrontBackpagedata[0].a_content}</a>
                                            <a href="/">
                                                <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                {else}
                                    <div class="previous-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="{$S}">
                                            <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                            <a href="/"  onclick="this.parentNode.submit(); return false;">
                                                <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                            <a href="/" rel="prev" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[0].a_content}</a>
                                        </form>
                                    </div>
                                    <div class="next-design-link" style="display: none;">
                                    </div>
                                {/if}

                            {elseif count($FrontBackpagedata) eq 2}
                                <div class="previous-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="{$S}">
                                        <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                        </a>
                                        <a href="/"  rel="prev" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[0].a_content}</a>
                                    </form>
                                    
                                </div>
                                <div class="next-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="{$S}">
                                        <input type="hidden" name="page" value="{$FrontBackpagedata[1].page}">
                                        <a href="/" rel="next" title="{$FrontBackpagedata[1].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[1].a_content}</a>
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                
                                </div>
                            {/if} 
                        </div>

                        <!-- 图片显示 -->
                        <div class="article-heading-ad" style="display: block;">
                            <a href="#" target="_blank"><img src="../../images/starry_sky.png" style="witdh=106px;height=900px" data-tt="713908" alt="starry sky"></a>
                        </div>
                        <!-- 文章内容 -->
                        <div class="article-body">
                            {$RightContentdata}
                        </div>
                        <!-- 文章内容 结束-->
                        <!-- 底部上下篇链接 -->
                        <div class="previous-next-links">
                            {if count($FrontBackpagedata) eq 1}
                                {if $FrontBackpagedata[0].status eq '0'}
                                    <div class="previous-design-link" style="display: none;"> </div>
                                    <div class="next-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="{$S}">
                                            <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                            <a href="/" rel="next" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;"> {$FrontBackpagedata[0].a_content}</a>
                                            <a href="/">
                                                <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                {else}
                                    <div class="previous-design-link">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="home">
                                            <input type="hidden" name="S" value="{$S}">
                                            <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                            <a href="/"  onclick="this.parentNode.submit(); return false;">
                                                <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                            <a href="/" rel="prev" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[0].a_content}</a>
                                        </form>
                                    </div>
                                    <div class="next-design-link" style="display: none;">
                                    </div>
                                {/if}

                            {elseif count($FrontBackpagedata) eq 2}
                                <div class="previous-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="{$S}">
                                        <input type="hidden" name="page" value="{$FrontBackpagedata[0].page}">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-left" aria-hidden="true"></i>
                                        </a>
                                        <a href="/"  rel="prev" title="{$FrontBackpagedata[0].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[0].a_content}</a>
                                    </form>
                                    
                                </div>
                                <div class="next-design-link">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="home">
                                        <input type="hidden" name="S" value="{$S}">
                                        <input type="hidden" name="page" value="{$FrontBackpagedata[1].page}">
                                        <a href="/" rel="next" title="{$FrontBackpagedata[1].a_Tips}" onclick="this.parentNode.submit(); return false;">{$FrontBackpagedata[1].a_content}</a>
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">
                                            <i style="font-size:16px;" class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                
                                </div>
                            {/if} 
                        </div>
                        <!-- 右边栏 -->
                        <div class="fivecol last right-column">
                        </div>
                    </div>

                </div>
            </div>
        </div>



    {/if}
     <!-- 内容 end-->

     <!-- 底部 start-->
    <div class="admin_entry"><a href="/index.php?p=admin&c=Auth&a=login" title="后台管理"><i class="fa-solid fa-user-shield"></i></a></div>
    <div class="up_top"><i class="fa-solid fa-chevron-up" title="回到顶部"></i></div> 
    <div id="UTC"></div> 
     <!-- 底部 end-->

</body>
</html>