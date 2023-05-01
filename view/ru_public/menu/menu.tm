


<style>
^start_repeat_csss^
%value% %width% `
#%value% .box_max_size {
  background: #fff;
  /* цвет фона, белый */
  min-width: %width%px;
}
^end_repeat_csss^	

</style>
	<header class="container-fluid header_menu mt-3">
		
			<ul class="nav nav-tabs" id="myTab" role="tablist">
^start_repeat_menu^
%active% %value% %true% %category% `
<li class="nav-item" role="presentation">
<button class="nav-link %active%" id="%value%-tab" data-bs-toggle="tab" data-bs-target="#%value%" type="button" role="tab" aria-controls="%value%" aria-selected="%true%">%category%</button>
</li>
^end_repeat_menu^
			  <li class="nav-item" role="presentation">
			    <button class="nav-link" id="models-tab" data-bs-toggle="tab" data-bs-target="#models" type="button" role="tab" aria-controls="models" aria-selected="false">Вход</button>
			  </li>
			</ul>

	<div class="tab-content" id="myTabContent">
	  
^start_repeat_twomenu^
%active_show% %value% %text% `
	  <div class="tab-pane fade %active_show%" id="%value%" role="tabpanel" aria-labelledby="%value%-tab">
	  	<div class="box_max_size">
		  	<ul>
		  		%text%
		  	</ul>
	  	</div>
	  </div>
^end_repeat_twomenu^

	  <div class="tab-pane fade" id="models" role="tabpanel" aria-labelledby="models-tab">
  		<div class="box_max_size">
		  	<ul>
		  		%startnoauth%
		  		<li class="p-2">
		  			<a href="%name_site%/auth">
		  				<img src="/resourse/visible/rect846.png" class="img-fluid">
		  				<h3 class="description_foto">Войти</h3>
		  			</a>
		  		</li>

		  		<li class="p-2">
		  			<a href="%name_site%/registration">
		  				<img src="/resourse/visible/rect846.png" class="img-fluid">
		  				<h3 class="description_foto">Регистрация</h3>
		  			</a>
		  		</li>
				%endnoauth%
				%startuser%
		  		<li class="p-2">
		  			<a href="%name_site%/destructauth">
		  				<img src="/resourse/visible/rect846.png" class="img-fluid">
		  				<h3 class="description_foto">Выход</h3>
		  			</a>
		  		</li>
		  		%enduser%

		  		<li class="p-2">
		  			<a href="%name_site%/basket">
		  				<img src="/resourse/visible/rect846.png" class="img-fluid">
		  				<h3 class="description_foto">Корзина</h3>
		  			</a>
		  		</li>
		  	</ul>
	  	</div>

	  </div>
	</div>
	
</header>
<div class="input-group p-3 sticky-top search_string">
  <input type="text" class="form-control" placeholder="Медведь..." aria-label="Медведь..." aria-describedby="button-addon2" name = "search">
  <button class="btn btn-outline-secondary" type="button" id="button-addon2">Поиск</button>
</div>

