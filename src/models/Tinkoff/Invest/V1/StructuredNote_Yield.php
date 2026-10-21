<?php

namespace Tinkoff\Invest\V1;

class_alias(StructuredNote\PBYield::class, __NAMESPACE__ . '\\StructuredNote_Yield');
@trigger_error('Tinkoff\Invest\V1\StructuredNote_Yield is deprecated. Use Tinkoff\Invest\V1\StructuredNote\PBYield instead', E_USER_DEPRECATED);
