<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::latest()->get();
        return view('backend.v_customer.index', compact('customers'));
    }

    public function destroy($id): RedirectResponse
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success', 'Data tamu berhasil dihapus.');
    }
}
