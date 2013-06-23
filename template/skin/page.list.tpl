{if $sidebar eq '0'}
    <div class="row">
    <div class="span12">
    
    {foreach key=key item=films_item from=$films}

<div class="row">
    <div class="span2">
        <ul class="thumbnails">
        <li class="span2">
	    <div class="thumbnail">
	      <a href="/?page=video&id={$films_item.ID}"><img src="/backend/{$films_item.SmallPoster}" width="144" height="207" alt="{$films_item.Name}"></a>
	    </div>
        </li>  
	</ul>
    </div>
    <div class="span10">
	<h5><a href="/?page=video&id={$films_item.ID}">{$films_item.Name}</a></h5>
	<p>{$films_item.OriginalName} ({$films_item.Year})</p>
	<p>{$films_item.Description|truncate:350}</p>
    </div>
</div>
    {/foreach}

{else}
    <div class="row">
    <div class="span8">
    
    {foreach key=key item=films_item from=$films}

<div class="row">
    <div class="span2">
        <ul class="thumbnails">
        <li class="span2">
	    <div class="thumbnail">
	      <a href="/?page=video&id={$films_item.ID}"><img src="/backend/{$films_item.SmallPoster}" width="130" height="193" alt="{$films_item.Name}"></a>
	    </div>
        </li>  
	</ul>
    </div>
    <div class="span6">
	<h5><a href="/?page=video&id={$films_item.ID}">{$films_item.Name} ({$films_item.Year})</a></h5>
	<p>{$films_item.OriginalName}</p>
	<p>{$films_item.Description|truncate:450}</p>
    </div>
</div>

{/foreach}
    
{/if}

{include file="pagination.tpl"}

