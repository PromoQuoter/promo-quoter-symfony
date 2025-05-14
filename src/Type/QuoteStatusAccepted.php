<?php

namespace App\Type;

enum QuoteStatusAccepted: string
{
    case Accepted = 'accepted';
    case ChangeRequest = 'change_request';
    case Rejected = 'rejected';
}
