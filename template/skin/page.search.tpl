    <div class="row">
    <div class="span8">

    <div class="page-header">
	{if $searchcount != 0}
		<h3>Результаты поиска: {$pagetitle} <small>Найдено {$searchcount} совпадений.</small></h3>
        {else}
		<h3>Результаты поиска: Ошибка!</h3>        
	{/if}
    </div>
      

    {if isset($error_message)} 
	<div class="alert alert-error">{$error_message}</div>
    {/if}
    
    {foreach key=key item=films_item from=$searchresult}

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
	    <h5><a href="/?page=video&id={$films_item.ID}">{$films_item.Name}</a></h5>
	    <p>{$films_item.OriginalName} ({$films_item.Year})</p>
	    <p>{$films_item.Description|truncate:300}</p>
        </div>
    </div>

    {/foreach}
    

