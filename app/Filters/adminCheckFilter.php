<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class adminCheckFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(session('role') == '1'){
            session()->setFlashdata("message", "Vous n'avez pas les droits !");
            return redirect()->to('/');
        }else{
            session()->setFlashdata("message", "Vous avez pas les droits !");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}