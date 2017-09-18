window.onload = function () {

    function hideButton() {
        document.querySelector('.button').classList.add('hide');
    }

	let hideMonth = document.querySelectorAll('.hide');

	if ( hideMonth.length == 0 )
	{
		hideButton();
	}

	button.onclick = function () {
        console.log(hideMonth);
        for (let i = 0; i<hideMonth.length ; i++)
        {
            hideMonth[i].classList.remove('hide');
            hideButton();
        }
    }
};