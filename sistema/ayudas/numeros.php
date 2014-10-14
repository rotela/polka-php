<?php
function sep_miles($numero='')
{
    if ( ! empty($numero))
    {
        $can = strlen($numero);
        if ($can <= 3)
        {
            return $numero;
        }
        else
        {
            $i       = 0;
            $x       = 0;
            $final   = '';
            $numeros = str_split($numero);
            $new_num = array();
            krsort($numeros);
            foreach ($numeros as $key => $value)
            {
                if ($i===3)
                {
                    $new_num[$x]=".";
                    $x++;
                    $new_num[$x]=$value;
                    $i=0;
                }
                else
                {
                    $new_num[$x]=$value;
                }
                $i++;
                $x++;
            }
            krsort($new_num);
            foreach ($new_num as $key => $value)
            {
                $final.=$value;
            }
            return $final;
        }
    }
    else
    {
        return '';
    }
}