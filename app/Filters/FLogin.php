<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FLogin implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // if user not logged in
    if (session()->get('logged_in') == TRUE) {
      // then redirct to login page
      return redirect()->to('/dashboard');
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
