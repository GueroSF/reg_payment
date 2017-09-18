window.onload = function () {
	let hideMonth = document.querySelectorAll('.hide');

	if ( hideMonth.length == 0 )
	{
		document.querySelector('.button').classList.add('hide');
	}

	button.onclick = function () {
        console.log(hideMonth);
        for (let i = 0; i<hideMonth.length ; i++)
        {
            hideMonth[i].classList.remove('hide');
        }
    }
};