<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AfterLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        if (session()->uname) {
            if (session()->lv == 1) {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/');
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //--------------------------------------------------------------------
    }
}
