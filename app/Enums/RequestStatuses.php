<?php


namespace App\Enums;


final class RequestStatuses extends Enum
{
    public const SENT = 'sent';
    public const ACCEPTED = 'accepted';
    public const REFUSED = 'refused';
}
