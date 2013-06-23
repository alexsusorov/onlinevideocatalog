{if $endpage eq 1}

{else}

<div class="pagination pagination-centered">
  <ul>
	{if $currentpage eq '1'}
	    <li class="disabled"><a href="#"><<</a></li>
	    <li class="disabled"><a href="#"><</a></li>
	{else}
	    <li><a href="{$pageurl}1"><<</a></li>
	    <li><a href="{$pageurl}{$currentpage-1}"><</a></li>
        {/if}
{foreach item=p from=$pages}
    {if $p eq $currentpage}<li class="active">{else}<li>{/if}<a href="{$pageurl}{$p}">{$p}</a></li>
{/foreach}

{if $currentpage eq $endpage}
    <li class="disabled"><a href="#">></a></li>
    <li class="disabled"><a href="#">>></a></li>
{else}
    <li><a href="{$pageurl}{$currentpage+1}">></a></li>
    <li><a href="{$pageurl}{$endpage}">>></a></li>
{/if}
  </ul>
</div>

{/if}