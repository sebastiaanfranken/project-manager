jQuery(document).ready(function() {
	
	/*
	 * Setup a tour
	 */
	var tour = new Tour({
		steps: [
			{
				path: '/',
				element: '.navbar',
				title: 'Navigatie',
				content: 'Met deze navigatiebalk kun je door alle hoofdonderdelen van de applicatie navigeren',
				placement: 'bottom'
			},
			{
				path: '/',
				element: '.row',
				placement: 'bottom',
				title: 'Alles in een oogopslag',
				content: 'Hier zie je de projecten en taken die bij je horen. Allemaal in een overzicht.'
			},
			{
				path: '/project',
				element: '.row:eq(1)',
				placement: 'bottom',
				title: 'Alle projecten in één oogopslag',
				content: 'Hier zie je alle taken die bij je horen met de naam, de leden, de start- en einddatum en de voortang van het project.'
			},
			{
				path: '/project',
				element: '.row:eq(1) table tbody tr:first',
				placement: 'bottom',
				title: 'Projectinformatie',
				content: 'Hier vind je de informatie per project, een project per rij'
			},
			{
				path: '/project',
				element: '.row:eq(1) table tbody tr:first td:last',
				placement: 'left',
				title: 'Beheer',
				content: 'Hier staan knoppen waarmee je projecten kunt beheren. Deze layout is overal gelijk, dus bij taken werkt het op dezelfde manier.'
			},
			{
				path: '/project/create',
				element: '.col-sm-8',
				placement: 'right',
				title: 'Een nieuw project aanmaken',
				content: 'Met dit formulier kun je een nieuw project aanmaken',
			},
			{
				path: '/project/create',
				element: '.col-sm-4',
				placement: 'left',
				title: 'Hulp bij een nieuw project aanmaken',
				content: 'Hier staat per veld vermeld waar dat veld voor is, wel zo handig.'
			},
			{
				path: '/task/',
				element: '.row:eq(1)',
				placement: 'left',
				title: 'Alle taken in een oogopslag',
				content: 'Hier zie je alle taken die bij je horen met de naam, het project, de start- en einddatum en de voortgang van de taak.'
			},
			{
				path: '/task/create',
				element: '.col-sm-8',
				placement: 'right',
				title: 'Een nieuwe taak aanmaken',
				content: 'Met dit formulier kun je voor jezelf of voor iemand anders een nieuwe taak aanmaken.'
			},
			{
				path: '/task/create',
				element: '.col-sm-4',
				placement: 'left',
				title: 'Hulp bij een nieuwe taak aanmaken',
				content: 'Hier staat per veld vermeld waar dat veld voor is, wel zo handig.'
			},
			{
				path: '/user',
				element: '.row:eq(0)',
				title: 'Profielmenu',
				content: 'Met dit menu kun je wisselen tussen je profielgegevens en de pagina om je wachtwoord te wijzigen',
				placement: 'bottom'
			},
			{
				path: '/user',
				element: '.row:eq(1)',
				title: 'Profiel',
				placement: 'left',
				content: 'Hier zie je je gegevens zoals bekend.'
			},
			{
				path: '/user',
				element: '.row:eq(2)',
				title: 'Taken',
				placement: 'left',
				content: 'Ook hier heb je een overzicht van je taken. De layout is hetzelfde als op de frontpage.'
			},
			{
				path: '/user',
				element: '.row:eq(3)',
				title: 'Projecten',
				placement: 'left',
				content: 'Ook hier heb je een overzicht van je projecten. De layout is hetzelfde als op de frontpage'
			},
			{
				path: '/user',
				element: '.row:eq(4)',
				title: 'Reacties',
				placement: 'left',
				content: 'En hier is een overzicht van reacties op taken die je geplaatst hebt, volgens de bekende layout.'
			}
		]
	}).init();

	/*
	 * Load the tour on click
	 */
	$('a[data-trigger-tour]').on('click', function(event) {
		event.preventDefault();
		tour.start().restart();
	});
});