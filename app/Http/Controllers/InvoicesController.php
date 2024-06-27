<?php

namespace App\Http\Controllers;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\fuse;

use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Add_invoice;
use App\Models\vatora;
use App\Models\section;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Notifications\regsystem;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Add_invoice_new;
class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = vatora::all();
        return view('vatora.empty', array('invoices'=> $invoices));
      }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = section::all();
        return view('invoices.add_invoice', compact('sections'));
        // return view('invoices.add_invoice');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {vatora::create([
        'invoice_number' => $request->invoice_number,
        'invoice_Date' => $request->invoice_Date,
        'Due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'Amount_collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'Status' => 'غير مدفوعة',
        'Value_Status' => 2,
        'note' => $request->note,
        ]);
        $invoice_id = vatora::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' =>  $request->note,
            'user' =>"kkki",
        ]);

        if ($request->hasFile('pic')) {

            // $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            // $attachments = new invoices_attachments();
            // $attachments->file_name = $file_name;
            // $attachments->invoice_number = $invoice_number;
            // $attachments->Created_by = Auth::user()->name;
            // $attachments->invoice_id = $invoice_id;
            // $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }



        Mail::to('ms11567111@gmail.com')->send(new TestMail());


        //    $user = User::first();
        //     Notification::send($user, new Add_invoice());

        // $user = Auth::user();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new Add_invoice($invoices));


    //    $user->notify(new Add_invoice());
        // event(new MyEventClass('hello world'));



        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = vatora::where('id',$id)->first();
        return view('invoices.status_update', compact('invoices'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $invoices = vatora::findOrFail($request->id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/vatora.empty');

    }

    public function Invoice_Paid()
    {
        $de = vatora::where('Value_Status',1)->get();
        // return view('invoices.invoices_paid', compact('de'));
        return view('invoices.invoices_paid', array('de'=> $de));
       }

       public function Invoice_unPaid()
       {
           $invoices = vatora::where('Value_Status',2)->get();
           return view('invoices.invoices_unpaid', array('invoices'=> $invoices));

       }


    /**
     * Remove the specified resource from storage.
     */ public function destroy(Request $request)
    {
        $id = $request->id;
        $invoices = vatora::where('id', $id)->first();
        // $Details = invoices_attachments::where('id', $id)->first();

         $id_page =$request->id_page;


        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {

            // Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }


    }

    public function destrooy(Request $request)
    {
        $Products = vatora::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();    }










    public function destroyy(Request $request)
    {
        $id = $request->id;
        $invoices = vatora::where('id', $id)->first();
        // $Details = invoice_attachments::where('invoice_id', $id)->first();

         $id_page =$request->id_page;


        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {

            // Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }


    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }







}
