<?php
if (isset($_sql)) {
	if (is_array($_sql)) {
		if (count($_sql)>0) {
			foreach ($_sql as $value) {
				echo "$value<br>";
			}
		}else{
			echo "es array pero no hay datos";
		}
	}else{
		echo $_sql;
	}
}else{
	echo "no existe la variable _sql";
}
?>