<?php
namespace App\Repository;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Cache;

class InvoiceCacheRepository implements InvoiceRepositoryInterface
{
    protected $invoiceRepository;
    protected $cache;
    protected $ttl;
    public function __construct(Cache $cache,InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->cache = $cache;
        $this->ttl = 60*60*24;
    }
    public function all()
    {
        $this->cache->remember('invoices',$this->ttl,function () {
            return $this->invoiceRepository->all();
        });
    }
    public function findById(int $id)
    {
        $this->cache->remember('invoice',$this->ttl, function (int $id) {
            return $this->invoiceRepository->findById($id);
        });
    }
     public function create(array $data)
     {
      
        $this->cache->forget('invoices');
        return $this->invoiceRepository->create($data);
     }
     public function update(int $id, array $data)
     {
        $this->cache->forget('invoice');
        return $this->invoiceRepository->update($id, $data);
     }
     public function delete(int $id)
     {
       
        $this->cache->forget('invoices');
        return $this->invoiceRepository->delete($id);
     }
     public function getByContractId(int $contractId)
     {
        $this->cache->remember('invoices',$this->ttl, function (int $contractId) {
            return $this->invoiceRepository->getByContractId($contractId);
        });
     }
     public function getRemainingBalance(int $invoiceId)
     {
        $this->cache->remember('invoice',$this->ttl, function (int $invoiceId) {
            return $this->invoiceRepository->getRemainingBalance($invoiceId);
        });
     }
     public function updateStatus(Invoice $invoice, string $status)
     {
        $this->cache->forget('invoice');
        return $this->invoiceRepository->updateStatus($invoice, $status);
     }
     public function getpaidAmount(int $invoiceId)
     {
        $this->cache->remember('invoice',$this->ttl, function (int $invoiceId) {
            return $this->invoiceRepository->getpaidAmount($invoiceId);
        });
     }
     public function getTotal(int $invoiceId)
     {
        $this->cache->remember('invoice',$this->ttl, function (int $invoiceId) {
            return $this->invoiceRepository->getTotal($invoiceId);
        });
     }

}