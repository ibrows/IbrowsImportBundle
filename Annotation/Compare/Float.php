<?php

namespace Ibrows\ImportBundle\Annotation\Compare;

@trigger_error('The '.__NAMESPACE__.'\Float annotation is deprecated since version 1.3 and will be removed in 2.0. Use the Field annotation instead.', E_USER_DEPRECATED);

/**
 * @Annotation
 * @deprecated since version 1.3, to be removed in 2.0. Use the Field annotation instead
 */
class Float extends AbstractCompare
{

}
