{include file="header.tpl"}
<div class="page_title">
    <div class="container">
        <div class="sixteen columns">
            Referral Links
        </div>
    </div>
</div>


<div class="container about">

    <div class="sixteen columns m-bot-25">
        <h3 class="underlined"><span>Advertisement</span></h3>
    </div>

    <div class="twelve alt columns">

       <!-- Toggle 1 -->
       <div class="toggle-wrap faq">
                   <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>Referral Link
                   </a></span>

           <div class="toggle-container" style="display: none;">
               <p><pre>{$settings.site_url}/?ref=IS{$user.username}</pre>
               </p>
           </div>
       </div>
       <div class="toggle-wrap faq">
                   <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>128x128 Banner
                   </a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="/images/banners/128.gif"&gt;&lt;/img&gt;</pre><br/><a href={$settings.site_url}/?ref={$user.username}><img src="images/banners/128.gif"></img></a></center>
               </p>
           </div>
       </div>

       <!-- Toggle 2 -->
       <div class="toggle-wrap faq">
           <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>468x90 Banner</a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="{$settings.site_url}/images/banners/468.gif"&gt;&lt;/img&gt;</pre><br/><a href={$settings.site_url}/?ref={$user.username}><img src="{$settings.site_url}/images/banners/468.gif"></img></a></center>
               </p>
           </div>
       </div>


       <!-- Toggle 4 -->
       <div class="toggle-wrap faq">
           <span class="trigger"><a href="index-_erv=site|faq.html#"><i class="icon-magic"></i>728x90 Banner</a></span>

           <div class="toggle-container" style="display: none;">
               <p><center><pre>&lt;img src="{$settings.site_url}/images/banners/728.gif"&gt;&lt;/img&gt;</pre><br/><a href={$settings.site_url}/?ref={$user.username}><img src="{$settings.site_url}/images/banners/728.gif"></img></a></center>
               </p>
           </div>
       </div>

    <div class="five columns" id="sliding_box">
        
    </div>
</div>
</div>
</div>

{include file="footer.tpl"}
