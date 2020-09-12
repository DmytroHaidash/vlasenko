<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalog\Accounting;
use App\Models\Catalog\Product;
use App\Models\Catalog\Status;
use App\Models\Catalog\Supplier;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountingsController extends Controller
{
    public function index()
    {
        $accountings = Accounting::query();
        if (\request()->filled('status')) {
            $accountings = $accountings->where('status_id', \request('status'));
        }
        if (\request()->filled('supplier')) {
            $accountings = $accountings->where('supplier_id', \request('supplier'));
        }
        if (\request()->filled('q')) {
            $query = \request()->input('q');
            $accountings = $accountings->whereHas('product', function ($product) use ($query) {
                $product->whereHas('translates', function (Builder $builder) use ($query) {
                    $builder->where('title', 'like', "%{$query}%");
                });
            });
        }
        $amountPublishedAcc = array_sum($accountings->whereHas('product', function (Builder $builder) {
            $builder->where('is_published', 1);
        })->pluck('amount')->toArray());
        return \view('admin.accountings.index', [
            'accountings' => $accountings->paginate(10),
            'statuses' => Status::get(),
            'suppliers' => Supplier::get(),
            'amountAcc' => array_sum($accountings->pluck('amount')->toArray()),
            'amountProduct' =>  array_sum(Product::pluck('price')->toArray()),
            'amountPublishedProduct' => array_sum(Product::where('is_published', 1)->pluck('price')->toArray()),
            'amountPublishedAcc' => $amountPublishedAcc,
        ]);
    }
    public function pdf(Product $product)
    {
        $images = $product->accountings->getMedia('uploads');
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.admin', compact( 'images'));
        return $pdf->download($product->title . '.pdf');
    }
}
