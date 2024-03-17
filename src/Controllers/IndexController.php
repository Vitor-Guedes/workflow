<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Workflow;
use App\Workflows\CustomerWorkflow;

class IndexController
{
    public function workflows()
    {
        $workflows = (new Workflow())->get();
        view('workflows', ['workflows' => $workflows]);
    }

    public function customers()
    {
        $customers = (new Customer())->get();
        view('customers', ['customers' => $customers]);
    }

    public function storeCustomer()
    {
        $request = request();
        $customer = new Customer();
        $customer->name = $request->get('name');
        $customer->email = $request->get('email');
        $customer->save();

        $workflow = new CustomerWorkflow($customer, 'on_hold');
        $workflow->create();

        redirect('/customers', true);
    }

    public function transition($id, $transition)
    {
        /** @var CustomerWorkflow $workflow */
        $workflow = (new Workflow)->load($id);

        if ($workflow->can($transition)) {
            $workflow->apply($transition);
        }

        redirect('/', true);
    }
}