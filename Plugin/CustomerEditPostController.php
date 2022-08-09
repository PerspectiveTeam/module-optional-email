<?php

namespace Perspective\OptionalEmail\Plugin;

use Magento\Customer\Controller\Account\EditPost;
use Magento\Framework\App\RequestInterface;

class CustomerEditPostController
{

    /**
     * @var RequestInterface
     */
    protected $request;

    public function beforeExecute(EditPost $subject)
    {
        $this->request->setParams(array_merge($this->request->getParams(), [
            'change_email' => true,
        ]));
    }
}
