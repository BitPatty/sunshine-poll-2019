<?php

namespace App\Models;

class VerificationState
{
    public const PENDING = 'Pending';
    public const VERIFIED = 'Verified';
    public const REJECTED = 'Rejected';
    public const AUTO_VERIFIED = 'Auto-Verified';
}
