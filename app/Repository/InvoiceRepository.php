<?php
namespace App\Repository;

use App\Casts\InvoiceStatus;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all()
    {
        return Invoice::all();
    }
    public function findById(int $id)
    {
        return Invoice::with('contract')->findOrFail($id);
    }
     public function create(array $data)
     {
      
        return Invoice::create($data);
     }
     public function update(int $id, array $data)
     {
        return Invoice::findOrFail($id)->update($data);
     }
     public function delete(int $id)
     {
        return Invoice::findOrFail($id)->delete();
     }
     public function getByContractId(int $contractId)
     {
      
        return Invoice::where('contract_id', $contractId)->with('contract')->with('payments')->get();
     }
     public function getRemainingBalance(int $invoiceId)
     {
        $invoice = $this->findById($invoiceId);
        return number_format( $invoice->total - $invoice->payments()->sum('amount'),2,'.', '');
     }
     public function updateStatus(int $invoiceId, InvoiceStatus $status)
     {
      $invoice=$this->findById($invoiceId);
        $invoice->update(['status' => $status]);
     }
     public function getpaidAmount(int $invoiceId)
     {
        return $this->findById($invoiceId)->payments()->sum('amount');
     }
     public function getTotal(int $invoiceId)
     {
        return $this->findById($invoiceId)->total;
     }

}