<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    %script_top%

    <script src="https://kit.fontawesome.com/de9f65bcf0.js" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="/favicon.svg" type="image/x-icon">
	<title>Магазин</title>

</head>
<body>
	<div class="container-fluid main p-0 m-0">


		<div class = "page" id = "one">
			<div class="container">
			    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
			      <a href="%name_site%/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
			        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
			        <span class="fs-4">Магазин</span>
			      </a>

			      <ul class="nav nav-pills">
			        <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Категории</a></li>
			        <li class="nav-item"><a href="#" class="nav-link">Корзина</a></li>

			        %startnoauth%
			        <li class="nav-item"><a href="%name_site%/auth" class="nav-link">Войти</a></li>
			        <li class="nav-item"><a href="%name_site%/registration" class="nav-link">Регистрация</a>
			        %endnoauth%

			        %startuser%
			        <li class="nav-item"><a href="%name_site%/destructauth" class="nav-link">Выйти</a>
			        %enduser%
			        </li>
			      </ul>
			    </header>
			  </div>
		</div>

		<div class = "page p-3" id = "two">
			<h3 class="text-center pt-3">Что это? </h3>
				<p>
					LIMB, в первой своей итерации, предоставляет следующие возможности:
				</p>
				<ul>
					<li>
						Создание, редактирование и удаление таблиц MYSQLI. Все происходит исключительно через веб-интерфейс.
					</li>
					<li>
						Автоматическое создание классов для работы с созданными таблицами и данными, с автоматическим подключением необходимых классов.
					</li>
					<li>
						Автоматическое заполнение ваших таблиц "рыбой-текстом", в соответствии с типом столбца и вашими потребностями.
					</li>
					<li>
						Шаблонизатор с возможностью простого контроля за правами видимости различных блоков страницы
					</li>
					<li>
						Присутствует модуль авторизации/регистрации. (BOOTSTRAP 5)
					</li>
					<li>
						Присутствует модуль пагинации. (BOOTSTRAP 5)
					</li>
				</ul>
				<p>Для перевода LIMB в рабочее состояние необходимо в файле app/base/db.ini выполнить подключение к базе данных, и сменить метод route в конструкторе класса data/route.php на routeLimb(), вместо routePublicLimb(). Как правило достаточно раскомментировать строку.</p>

				<h4 class="text-center">Основные изменения v 1.2</h4>
				<p>
					Изменена(Создана!) схема подключения скриптов и стилей, в зависимости от названия страницы.</p><p> Реализована ajax схема работы. </p><p>Реализована мультиязычность.</p><p> Добавлены комментарии без ограничения по уровню.</p> <p>Функция csrf() перенесена в web/visible(). 				</p>
		</div>

	</div>
</body>
%script_bottom%
</html>