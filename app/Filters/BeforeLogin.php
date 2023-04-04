<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class BeforeLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        if (!session()->uname) {
            return redirect()->to('/auth');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //--------------------------------------------------------------------
    }
}
