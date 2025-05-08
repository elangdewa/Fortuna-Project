<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin');
    }

    // List Member
    public function members()
    {
        return view('admin.members.view');
    }

    // Create Member
    public function createMember()
    {
        return view('admin.members.create');
    }

    // Paket Member
    public function paket()
    {
        return view('admin.paketmember.paket');
    }

    // Kelas Fitness
    public function kelas()
    {
        return view('admin.fitness.fitness');
    }

  
    public function coach()
    {
        return view('admin.trainer.trainer');
    }
}
