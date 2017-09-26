<?php

function row_compare($a, $b)
{
    if ($a === $b) {
        return 0;
    }

    return (implode("",$a) < implode("",$b) ) ? -1 : 1;
}

?>
