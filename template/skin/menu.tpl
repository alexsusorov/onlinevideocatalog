<ul class="nav nav-pills">
  <li {if $pagetitle eq "Главная"}class="active"{/if}><a href="/">Главная</a></li>

  <li class="dropdown {if $pagetitle eq "Фильмы"}active{/if}">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Фильмы<b class="caret"></b></a>
    <ul class="dropdown-menu">
              <li><a href="/?page=list&type=1&national=1">Отечественные</a></li>
              <li><a href="/?page=list&type=1&national=0">Зарубежные</a></li>
              <li class="divider"></li>
              <li><a href="/?page=list&type=1">Все</a></li>
    </ul>
  </li>


  <li class="dropdown {if $pagetitle eq "Сериалы"}active{/if}">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Сериалы<b class="caret"></b></a>
    <ul class="dropdown-menu">
              <li><a href="/?page=list&type=2&national=1">Отечественные</a></li>
              <li><a href="/?page=list&type=2&national=0">Зарубежные</a></li>
              <li class="divider"></li>
              <li><a href="/?page=list&type=2">Все</a></li>
    </ul>
  </li> 

  <li class="dropdown {if $pagetitle eq "Мультфильмы"}active{/if}">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Мультфильмы<b class="caret"></b></a>
    <ul class="dropdown-menu">
              <li><a href="/?page=list&type=3&national=1">Отечественные</a></li>
              <li><a href="/?page=list&type=3&national=0">Зарубежные</a></li>
              <li class="divider"></li>
              <li><a href="/?page=list&type=3">Все</a></li>
    </ul>
  </li> 

  <li class="dropdown {if $pagetitle eq "Мультсериалы"}active{/if}">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Мультсериалы<b class="caret"></b></a>
    <ul class="dropdown-menu">
              <li><a href="/?page=list&type=4&national=1">Отечественные</a></li>
              <li><a href="/?page=list&type=4&national=0">Зарубежные</a></li>
              <li class="divider"></li>
              <li><a href="/?page=list&type=4">Все</a></li>
    </ul>
  </li> 



  <li {if $pagetitle eq "Документальные"}class="active"{/if}><a href="/?page=list&type=5">Документальные</a></li>


  <li class="dropdown {if $pagetitle eq "Коллекции"}active{/if}">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Коллекции<b class="caret"></b></a>
    <ul class="dropdown-menu">
              <li><a href="/?page=list&set=1">Классика отечественного кино</a></li>
              <li><a href="/?page=list&set=2">Классика мирового кино</a></li>
              <li><a href="/?page=list&set=3">Оскар</a></li>
              <li><a href="/?page=list&set=4">Золотой Глобус</a></li>
              <li><a href="/?page=list&set=5">Ника</a></li>
              <li><a href="/?page=list&set=6">Золотой орёл</a></li>
              <li><a href="/?page=list&set=7">Каннский кинофестиваль</a></li>
              <li><a href="/?page=list&set=8">ММКФ</a></li>
              <li><a href="/?page=list&set=9">Кинотавр</a></li>
              <li class="divider"></li>
              <li><a href="/?page=list&set=10">Новогоднее кино</a></li>
    </ul>

  </li> 
</ul>