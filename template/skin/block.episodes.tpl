{literal}
 <script type="text/javascript">
        $(function(){    
        
            $('ul#episodes>li').click(function(){
                $('ul#episodes>li').removeClass('active');
                $(this).addClass('active');            
            });
            
        });
    </script>
{/literal}

<div class="well" style="padding: 8px 0;">
<ul id="episodes" class="nav nav-list">
	<li class="nav-header">Эпизоды</li>

	{foreach key=key item=ffiles from=$episodes}
	<li>
	<a href="#" onclick="jwplayer('player').playlistItem({$key})">
	{$ffiles.Name|replace:'.mp4':''|replace:'sd-':''}
	</a>
	</li>
	{/foreach}
</ul>
</div>


