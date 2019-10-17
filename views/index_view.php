
<table style="font-size: 16px;" class="form-table">
	<caption>В образовательной организации <?=$this->collegeName?> :</caption>
	<tr>
		<td style="padding: 10px 30px;">Обучаются <b><?=$this->studsCount?></b> студентов</td>
	</tr>
	<tr>
		<td style="padding: 10px 30px;"> - в <b><?=$this->groupsCount?></b> группах</td>
	</tr>
	<tr>
		<td style="padding: 10px 30px;"> - по <b><?=$this->specCount?></b> специальностям</td>
	</tr>
	<tr>
		<td style="padding: 10px 30px;">Преподают <b><?=$this->teachersCount?></b> преподавателей</td>
	</tr>
	<tr>
		<td style="padding: 10px 30px;">Преподаютcя <b><?=$this->subjectsCount?></b> дисциплин</td>
	</tr>
	<tr>
		<td style="padding: 10px 30px;">Зарегестрировано <b><?=$this->parentsCount?></b> родителей</td>
	</tr>
</table>
	<?php
	$goodCounter = 0;
	foreach ($this->avg as $m) {
		if ($m->AvgMark >= 4.8) {
			$goodCounter++;
		}
	}
	$normCounter = 0;
	foreach ($this->avg as $m) {
		if ($m->AvgMark < 4.8) {
			$normCounter++;
		}
	}
	$takoeCounter = 0;
	foreach ($this->avg as $m) {
		if ($m->AvgMark < 4) {
			$takoeCounter++;
		}
	}
	$badCounter = 0;
	foreach ($this->avg as $m) {
		if ($m->AvgMark < 3) {
			$badCounter++;
		}
	}


	if(isset($this->AbsCount[0]->AbsCount)){
		$AbsCount = $this->AbsCount[0]->AbsCount;
	}
	else $AbsCount = 0;
	echo '<table class="form-table">
			<caption>Общая успеваемость</caption>
			<tr><td>Студентов, которые учатся отлично (ср. бал >= 4.8): </td><td>'.$goodCounter.'</td></tr>
			<tr><td>Студентов, которые учатся хорошо(ср. бал < 4.8): </td><td>'.$normCounter.'</td></tr>
			<tr><td>Студентов, которые учатся удовлитворительно(ср. бал < 4): </td><td>'.$takoeCounter.'</td></tr>
			<tr><td>Студентов, которые учатся неудовлитворительно(ср. бал < 3): </td><td>'.$badCounter.'</td></tr>
			<tr><td>Студентов, которые не имеют оценок: </td><td>'.$this->countNull.'</td></tr>
			<tr><td>Максимум прогулов: </td><td>'.$AbsCount.'</td></tr>
			</table>';