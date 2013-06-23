<div class="well" style="padding: 8px 0;">
<ul class="nav nav-list">
	<li class="nav-header">Популярное</li>

	{foreach key=key item=ffiles from=$files}
	<li class="active"><a href="#">{$ffiles.Path}</a> </li>
	{/foreach}
</ul>
</div>


