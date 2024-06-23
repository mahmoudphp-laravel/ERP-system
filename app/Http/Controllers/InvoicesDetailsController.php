<?php
namespace App\Http\Controllers;
use App\Models\invoices_details;
use App\Models\vatora;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use League\Flysystem\Filesystem;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
     {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = vatora::where('id',$id)->first();
        $details  = invoices_details::all();
        $attachments  =invoices_attachments::all();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }
    public function editt($id)
    {
        $invoices = vatora::where('id',$id)->first();
        $details  = invoices_details::all();
        $attachments  =invoices_attachments::all();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }
    // public function open_file($invoice_number,$file_name)

    // {
    //     $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
    //     return response()->file($files);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }
    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function Print_invoice($id)
    {
        $invoices = vatora::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }


    public function Invoice_Paid()
    {
        $de = vatora::where('Value_Status',1)->get();
        return view('invoices.invoices_paid',compact('de'));

    }


}
