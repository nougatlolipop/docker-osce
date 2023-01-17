<?php

function reformat($date)
{
    return date('Y-m-d h:i:s', strtotime($date));
}
