<?php

namespace App\Interfaces;

use App\Models\Invoice;

interface InvoiceRepositoryInterface{

    public function all();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByContractId(int $contractId);
    public function getRemainingBalance(int $invoiceId);
    public function updateStatus(Invoice $invoice, string $status);
    public function getpaidAmount(int $invoiceId);
    public function getTotal(int $invoiceId);
}