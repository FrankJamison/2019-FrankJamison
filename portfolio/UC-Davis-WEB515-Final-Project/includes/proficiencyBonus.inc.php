<?php

/* Get proficiency bonus function
-------------------------------------------------------------------*/
function getProficiencyBonus($characterLevel)
{

    // Set the proficiency bonus to the character level / 4 rounded up + 1
    return ceil($characterLevel / 4) + 1;

}

?>