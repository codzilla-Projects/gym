const workingHours = {
	start: 0,
	end: 23
};
const days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];

window.addEventListener('load', () => {

	let existingData = JSON.parse(window.oldData);

	const gamesElem = document.querySelector('#games-data');
	const gamesIds = gamesElem.getAttribute('data-ids').split(',').map(single => parseInt(single));
	const gamesNames = gamesElem.getAttribute('data-names').split(',');
	const games = [];
	for(let i = 0; i < gamesIds.length; i++ ){
		if(!isNaN(gamesIds[i]))
			games.push({id: gamesIds[i], name: gamesNames[i]});
	}

	const coachesElem = document.querySelector('#coaches-data');
	const coachesIds = coachesElem.getAttribute('data-ids').split(',').filter(single => !isNaN(parseInt(single)));
	const coachesNames = coachesElem.getAttribute('data-names').split('###').filter(single => single !== '');
	const coaches = [];
	for(let i = 0; i < coachesIds.length; i++) {
		coaches.push({id: coachesIds[i], name: coachesNames[i]});
	}

	const pattern = document.querySelector('#working-pattern');
	pattern.addEventListener('change', event => {
		if(event.target.value === 'limited') {
			document.getElementById('hours-limits').style.display = 'flex';
			workingHours.start = 0;
			workingHours.end = 23;
		}
		else {
			document.getElementById('hours-limits').style.display = 'none';
			workingHours.start = 0;
			workingHours.end = 23;
		}
		populateTableData();
	});
	const startingTimeElem = document.getElementById("starting-time");
	startingTimeElem.addEventListener('change', event => {
		workingHours.start = parseInt(event.target.value.split(':')[0]);
		populateTableData();
	});
	const endingTimeElem = document.getElementById("ending-time");
	endingTimeElem.addEventListener('change', () => {
		workingHours.end = parseInt(event.target.value.split(':')[0]);
		populateTableData();
	});
	const populateTableData = () => {
		const scheduleTable = document.querySelector('#schedule-table');
		let headerRow = '<tr><th></th>', bodyRows = '';
		days.forEach(day => {
			headerRow += `<th>${day.charAt(0).toUpperCase() + day.slice(1)}</th>`;
		});
		headerRow += '</tr>';
		scheduleTable.querySelector('thead').innerHTML = headerRow;
		//body cells
		for(let i = workingHours.start; i <= workingHours.end; i++){
			
			bodyRows += `<tr><th>${i < 10 ? '0'+i : i}:00</th>`;
			days.forEach(day => {

				if (!existingData) {
					existingData = {[day]: {[i] : {}}};
				}
				if (!existingData[day]) {
					existingData[day] = { [i]: {} };
				}
				if (!existingData[day][i]) {
					existingData[day][i] = {};
				}

				bodyRows += `<td>`;
			
				bodyRows += `<div>
				<select class="game_select full-width" name="sch_game_${day}_${i}">
					<option value="off">Off</option>`;
				games.forEach(game => {
					bodyRows += `<option value="${game.id}" ${game.id === parseInt(existingData[day][i].game) ? 'selected' : '' }>${game.name}</option>`;
				});
				bodyRows += `</select>
				</div>`;
				
				bodyRows += `<div>
				<select class="full-width" name="sch_gender_${day}_${i}">
					<option value="male">Male</option>
					<option value="female" ${'female' === existingData[day][i].gender ? 'selected' : '' }>Female</option>
				</select>
				</div>`;

				bodyRows += `<div>
				<select class=" full-width" name="sch_coach_${day}_${i}">
					<option value="" selected disabled>Select Coach</option>`;
				coaches.forEach(coach => {
					bodyRows += `<option value="${coach.id}" ${coach.id === existingData[day][i].coach ? 'selected' : '' }>${coach.name}</option>`;
				});
				bodyRows += `</select>
				</div>`;

				bodyRows += existingData[day][i].extended ? `<div><label><input type="checkbox" name="sch_extended_${day}_${i}" value="extended" checked> Extend Time</label>` : '';
				
				bodyRows += `</td>`;
			});
			bodyRows += `</tr>`;
		}
		scheduleTable.querySelector('tbody').innerHTML = bodyRows;
	};

	if(existingData) {
		if(window.working_pattern === 'limited') {
			const workingPattern = document.querySelector('#working-pattern');
			const startingTime = document.querySelector('#starting-time');
			const endingTime = document.querySelector('#ending-time');
			const event = new Event('change');
			
			workingPattern.selectedIndex = 1;
			workingPattern.value = 'limited';
			workingPattern.dispatchEvent(event);
			startingTime.value = window.starting;
			startingTime.dispatchEvent(event);
			endingTime.value = window.ending;
			endingTime.dispatchEvent(event);
			populateTableData();
		}
	}
	else {
		populateTableData();
	}
	$(document).on('change', '.game_select', event => {
		//return if first cell
		const tdIndex = $(event.target).closest('td').index();
		if( $(event.target).closest('tr').index() !== 0 && $(event.target).closest('tr').prev().find(`td:nth-child(${tdIndex + 1})`).find('.game_select').val() === event.target.value ) {
			const name = $(event.target).attr('name').replace(/sch_game/, '');
			$(event.target).closest('td').append(`<div><label><input type="checkbox" name="sch_extended${name}" value="extended"> Extend Time</label>`);
		}
		else {
			$(event.target).closest('td').find('[type="checkbox"]').closest('div').remove();
		}
		//Two Games following without checks
	});
});