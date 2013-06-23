</div>

{if $sidebar eq '0'}

{else}
    <div class="span4">
    <div class="sidebar-nav">  
      <form class="well form-search" action="/">
  <input type="hidden" name="page" value="search">
  <input type="text" class="input-large focused" name="s">
  <button type="submit" class="btn"><i class="icon-search"></i></button>

</form>

{if $pagetitle eq 'Главная'}
    <div class="well">
    <p><b>23.06.13</b></p>
    <p>Место для новостей...</p>

    </div>
{/if}

{if isset($episodes) }
    {include file="block.episodes.tpl"}      
{/if}

 {if isset($seealso) }
    {include file="block.seealso.tpl"}      
{/if}

{if isset($popular) }
    {include file="block.popular.tpl"}      
{/if}

    </div>      
    </div>
{/if}
