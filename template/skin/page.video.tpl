{if $sidebar eq '0'}
    <div class="row">
    <div class="span12">

    <script type='text/javascript' src='/template/skin/player/jwplayer.js'></script>
    <div class="well">
    <h2>{$name}</h2>
    <div id='player'>Для просмотра видео необходим Flash Player.</div>

    {literal} 
    <script type='text/javascript'>
    jwplayer('player').setup({
    'flashplayer': '/template/skin/player/player.swf',
    'id': 'playerID',
    'width': '900',
    'height': '506',
    'playlist.position': 'none',
    {/literal}
        {if $hdmode eq 1}'plugins': 'hd-1',{/if}
    {literal}
    'autostart': 'true',                
    'playlist': [
    {/literal}
	{foreach key=key item=ffiles from=$episodes}
	{literal}{ file: '{/literal}{$ffiles.Path|replace:'/mnt/':''|escape:'javascript'}',{if $hdmode eq 1}{literal} 'hd.file': '{/literal}{$ffiles.Path|replace:'/mnt/':''|replace:'sd-':'hd-'|escape:'javascript'}',{/if}{literal} streamer: 'rtmp://server:1935/', provider: 'rtmp' },{/literal}
	{/foreach}{literal}
    ]
    });
    </script>
    {/literal}
    <div>&nbsp;</div>

	<div class="btn-group inline pull-right">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    Загрузить
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <li><a href="{$ffiles.Path|replace:'/mnt/':'http://server:8080/'}">SD-версия</a></li>
	    {if $hdmode eq 1}<li><a href="{$ffiles.Path|replace:'/mnt/':'server:8080/'|replace:'sd-':'hd-'}">HD-версия</a></li>{/if}
	  </ul>
	</div>

<div>&nbsp;</div>

    <div id="description">{$description}</div>
    </div>
{else}
    <div class="row">
    <div class="span8">

    <script type='text/javascript' src='/template/skin/player/jwplayer.js'></script>
    <div class="well">
    <h2>{$name}</h2>
    <div id='player'>Для просмотра видео необходим Flash Player.</div>

    {literal} 
        <script type='text/javascript'>
	    jwplayer('player').setup({
	    'flashplayer': '/template/skin/player/player.swf',
	    'id': 'playerID',
	    'width': '580',
	    'height': '332',
	    'autostart': 'true',
	    'playlist.position': 'none',
    {/literal}
    
    	    {if $hdmode eq 1}'plugins': 'hd-1',{/if}
    {literal}	
	    'playlist': [
    {/literal}

    {foreach key=key item=ffiles from=$episodes}
	{literal}{ file: '{/literal}{$ffiles.Path|replace:'/mnt/':''|escape:'javascript'}',{if $hdmode eq 1}{literal} 'hd.file': '{/literal}{$ffiles.Path|replace:'/mnt/':''|replace:'sd-':'hd-'|escape:'javascript'}',{/if}{literal} streamer: 'rtmp://server:1935/', provider: 'rtmp' },{/literal}
    {/foreach}

    {literal}
        ]
        });
        
        jwplayer('player').onComplete(function() {
         this.playlistNext();
         });
                  
	</script>
    {/literal}
    <div>&nbsp;</div>
    <div id="description">{$description}</div>
    </div>
{/if}

