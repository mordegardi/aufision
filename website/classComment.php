<?php
class Comment
{
	private $res = array();

	public function __construct($row)
	{
		/*
		/	Конструктор
		*/

		$this->res = $row;
	}

	public function markup()
	{
		/*
		/	Данный метод выводит разметку XHTML для комментария
		*/

		// Устанавливаем псевдоним, чтобы не писать каждый раз $this->data:
		$date = &$this->res;

		// Преобразуем время в формат UNIX:
		$date['dt'] = strtotime($date['dt']);
		$date['name'] = $_SESSION['username'];

		return '
	<form class="comment">

		<div class="avatar">
			<img src="">
		</a>
		</div>

		<div class="name"> 
			<p>"'.$date['name'].'" </p>
		</div>
		
		<p class="date">'.date('H:i \o\n d M Y',$date['dt']).'">'.date('d M Y',$date['dt']).'</p>
		<p>'.$date['text_comment'].'</p>
	</form>

		';
	}