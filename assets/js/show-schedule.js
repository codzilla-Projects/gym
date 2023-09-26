if(typeof days === 'undefined') {
	window.days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
}
jQuery(document).ready($ => {
	const loaderImg = document.createElement('img');
	loaderImg.setAttribute('src', AJAX.loader);
	document.getElementById('calendar-container').appendChild(loaderImg);
	if (!calendarData) {
		document.getElementById('calendar-container').innerHTML = '<p style="text-align: center;"> No Data Found</p>';
	}
	else {
		const coachesIDs = [];
		const gamesIDs = [];
		Object.values(calendarData).forEach(value => {
			// value.forEach(slot => {
			for (const [key, slot] of Object.entries(value)) {
				if (!coachesIDs.includes(slot.coach))
					coachesIDs.push(slot.coach);
				if (!gamesIDs.includes(slot.game))
					gamesIDs.push(slot.game);
			};
			// });
			console.log(coachesIDs, gamesIDs);
			$.post(AJAX.ajaxurl, {
				action: 'get_game_coach_data',
				coachesIDs, gamesIDs
			}, data => {
				loaderImg.remove();
				const response = JSON.parse(data);
				// console.log(response);
				window.games = response.games;
				window.coaches = response.coaches;
				populateData();
			});
		});

	}

	$(document).on('change', '.schedule-filter', filterGenderChangeHanlder);
	
});

const populateData = (filterby = '', value = '') => {
	let headerRow = '<tr><th></th>', bodyRows = '';
	days.forEach(day => {
		headerRow += `<th>${day.charAt(0).toUpperCase() + day.slice(1)}</th>`;
	});
	headerRow += '</tr>';

	document.querySelector('#calendar-table thead').innerHTML = headerRow;

	const passFilteration = filterby === '';
	
	//Populate innerData
	for (let i = workingHours.start; i <= workingHours.end; i++) {

		bodyRows += `<tr><th>${i < 10 ? '0' + i : i}:00</th>`;
		days.forEach(day => {

			if (!calendarData) {
				calendarData = {
					[day]: {
						[i]: {
							game: '',
							gender: '',
							coach: ''
						}
					}
				};
			}
			if (!calendarData[day]) {
				calendarData[day] = {
					[i]: {
						game: '',
						gender: '',
						coach: ''
					}
				};
			}
			if (!calendarData[day][i]) {
				calendarData[day][i] = {
					game: '',
					gender: '',
					coach: ''
				};
			}

			if(!passFilteration && calendarData[day][i][filterby] !== value ) {
				bodyRows += '<td></td>';
				return false;
			}

			if(!calendarData[day][i].extended){
				window.iterations = 1;
				getExtensionsNumber(day, i);
				console.log('[ITERATIONS]', iterations);
				bodyRows += `<td ${iterations ? `rowspan="${iterations}"` : ''}>`;
				if (games[calendarData[day][i].game])
					// bodyRows += `<div><img src="${games[calendarData[day][i].game].thumb}" /> <div>${games[calendarData[day][i].game].post_title}</div></div>`;
					bodyRows += `<div>${games[calendarData[day][i].game].post_title}</div>`;
				if (calendarData[day][i].gender)
					bodyRows += `<div>${calendarData[day][i].gender}</div>`;
				if (coaches[calendarData[day][i].coach])
					bodyRows += `<div class="coach_name">${coaches[calendarData[day][i].coach].data.display_name}</div>`;
				bodyRows += `</td>`;
			}
			
		});
		bodyRows += `</tr>`;
	}// for times
	document.querySelector('#calendar-table tbody').innerHTML = bodyRows;
};

const filterGenderChangeHanlder = event => {
	const value = event.target.value;
	document.querySelector('#calendar-table tbody').innerHTML = '';
	if( value === 'all') {
		populateData();
	}
	else {
		populateData('gender', value);
	}
	
};

const getExtensionsNumber = (day, i) => {
	i++;
	// console.log(day, i, calendarData[day][i], calendarData[day][i].extended);
	console.log('[ITERATIONS--]', iterations);
	console.log(calendarData[day][i - 1]);
	console.log(calendarData[day][i]);
	if(calendarData[day][i] && calendarData[day][i].extended){
		console.log('here');
		iterations ++;
		getExtensionsNumber(day, i);
	}
}