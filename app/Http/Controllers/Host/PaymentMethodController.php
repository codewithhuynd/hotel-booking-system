<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();

        return view(
            'host.payment-methods.index',
            compact('paymentMethods')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('host.payment-methods.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',

            'type' => 'required|string|unique:payment_methods,type',

            'bank_name' => 'nullable|string|max:255',

            'account_name' => 'nullable|string|max:255',

            'account_number' => 'nullable|string|max:255',

            'phone_number' => 'nullable|string|max:255',

            'description' => 'nullable|string',

            'is_active' => 'nullable',

            'qr_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('qr_image')) {

            $data['qr_image'] = $request
                ->file('qr_image')
                ->store('payment-methods', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        PaymentMethod::create($data);

        return redirect()
            ->route('host.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(PaymentMethod $paymentMethod)
    {
        return view(
            'host.payment-methods.edit',
            compact('paymentMethod')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        PaymentMethod $paymentMethod
    ) {

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'type' => 'required|string|unique:payment_methods,type,' . $paymentMethod->id,

            'bank_name' => 'nullable|string|max:255',

            'account_name' => 'nullable|string|max:255',

            'account_number' => 'nullable|string|max:255',

            'phone_number' => 'nullable|string|max:255',

            'description' => 'nullable|string',

            'is_active' => 'nullable',

            'qr_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('qr_image')) {

            if ($paymentMethod->qr_image) {

                Storage::disk('public')
                    ->delete($paymentMethod->qr_image);
            }

            $data['qr_image'] = $request
                ->file('qr_image')
                ->store('payment-methods', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $paymentMethod->update($data);

        return redirect()
            ->route('host.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->qr_image) {

            Storage::disk('public')
                ->delete($paymentMethod->qr_image);
        }

        $paymentMethod->delete();

        return back()->with(
            'success',
            'Payment method deleted successfully.'
        );
    }
}