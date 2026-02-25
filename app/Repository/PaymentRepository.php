<?php
namespace App\Repository;


use App\Models\Payment;
use App\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all()
    {
        return Payment::all();
    }
    public function findById(int $id)
    {
        return Payment::findOrFail($id);
    }
     public function create(array $data)
     {
        return Payment::create($data);
     }
     public function update(int $id, array $data)
     {
        Payment::findOrFail($id)->update($data);
     }
     public function delete(int $id)
     {
        Payment::findOrFail($id)->delete();

     }
     public function getByInvoiceId(int $invoiceId)
     {
        return Payment::where('invoice_id', $invoiceId)->get();
     }

}