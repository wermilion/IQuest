<?php

function is_weekend($date): bool
{
    return date('N', strtotime($date)) >= 6;
}
