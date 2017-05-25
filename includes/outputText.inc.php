<?php
function outPutText($text)
{
	echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}