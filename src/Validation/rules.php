<?php

return [
    'phone' => App\Validation\Rules\PhoneRule::class,
    'unique' => App\Validation\Rules\UniqueRule::class,
    'exists' => App\Validation\Rules\ExistsRule::class,
];