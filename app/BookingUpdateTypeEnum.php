<?php

namespace App;

enum BookingUpdateTypeEnum: string
{
    case START_DATE = 'start_date';
    case END_DATE = 'end_date';
    case DESCRIPTION = 'description';
}
