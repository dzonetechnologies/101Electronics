<?php

namespace App\Exports;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class OrdersExport extends StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings, WithEvents
{
    var $StartDate;
    var $EndDate;
    var $Status;
    var $Product;

    public function __construct($StartDate, $EndDate, $Status, $Product)
    {
        $this->StartDate = $StartDate;
        $this->EndDate = $EndDate;
        $this->Status = $Status;
        $this->Product = $Product;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        /*return Orders::all();*/
        $StartDate = $this->StartDate;
        $EndDate = $this->EndDate;
        $Status = $this->Status;
        $Product = $this->Product;

        $Orders = DB::table('orders')
            ->join("order_details", 'orders.id', '=', 'order_details.order_id')
            ->join("customers", 'orders.customer_id', '=', 'customers.id')
            ->where('orders.deleted_at', '=', null)
            ->where(function ($query) use ($StartDate, $EndDate, $Status, $Product) {
                if ($StartDate != "-" && $EndDate != "-") {
                    $query->whereBetween('orders.created_at', [Carbon::parse($StartDate)->format("Y-m-d"), Carbon::parse($EndDate)->addDays(1)->format("Y-m-d")]);
                }
                if ($Status != "-") {
                    $query->where('orders.order_status', $Status);
                }
                if ($Product != "-") {
                    $query->where('order_details.product_id', $Product);
                }
            })
            ->select('orders.*', 'customers.first_name', 'customers.last_name', 'customers.phone', 'customers.email')
            ->distinct('orders.id')
            ->get();

        $data = array();
        foreach ($Orders as $row => $item) {
            $sub_array = array();
            /*$sub_array['id'] = (string) $item->id;*/
            $sub_array['invoice_no'] = (string) $item->invoice_no;
            /*$sub_array['customer_id'] = (string) $item->customer_id;*/
            $sub_array['name'] = (string) $item->first_name . ' ' . $item->last_name;
            $sub_array['phone'] = (string) $item->phone;
            $sub_array['email'] = (string) $item->email;
            /*$sub_array['payment_gateway'] = (string) $item->payment_gateway;*/
            $sub_array['discount_code'] = (string) $item->discount_code;
            $sub_array['sub_total'] = (string) $item->sub_total;
            $sub_array['gst'] = (string) $item->gst;
            $sub_array['discount'] = (string) $item->discount;
            $sub_array['shipping'] = (string) $item->shipping;
            $sub_array['installation'] = (string) $item->installation;
            $sub_array['voucher_amount'] = (string) $item->voucher_amount;
            $sub_array['order_total'] = (string) $item->order_total;
            $sub_array['order_notes'] = (string) $item->order_notes;
            /*$sub_array['order_status'] = (string) $item->order_status;*/
            /*$sub_array['invoice_pdf'] = (string) $item->invoice_pdf;*/
            $sub_array['created_at'] = (string) Carbon::parse($item->created_at)->format('d-M-Y');
            /*$sub_array['updated_at'] = (string) $item->updated_at;*/
            $data[] = $sub_array;
        }
        return collect($data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        /*Heading*/
        $sub_array = array();
        /*$sub_array['Id'] = "Order Id";*/
        $sub_array['Invoice No'] = "Invoice No";
        $sub_array['Name'] = "Name";
        $sub_array['Phone'] = "Phone";
        $sub_array['Email'] = "Email";
        /*$sub_array['Customer Id'] = "Customer Id";
        $sub_array['Payment Gateway'] = "Payment Gateway";*/
        $sub_array['Discount Code'] = "Discount Code";
        $sub_array['Sub Total'] = "Sub Total";
        $sub_array['GST'] = "GST";
        $sub_array['Discount'] = "Discount";
        $sub_array['Shipping'] = "Shipping";
        $sub_array['Installation'] = "Installation";
        $sub_array['Voucher Amount'] = "Voucher Amount";
        $sub_array['Order Total'] = "Order Total";
        $sub_array['Order Notes'] = "Order Notes";
        /*$sub_array['Order Status'] = "Order Status";
        $sub_array['Invoice PDF'] = "Invoice PDF";*/
        $sub_array['Order Date'] = "Order Date";
        /*$sub_array['Updated'] = "Updated";
        $sub_array['Deleted'] = "Deleted";*/
        /*$sub_array['First Name'] = "First Name";
        $sub_array['Last Name'] = "Last Name";*/
        return $sub_array;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('B1:V1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12);
            },
        ];
    }
}