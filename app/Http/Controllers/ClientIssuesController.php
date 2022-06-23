<?php

namespace App\Http\Controllers;

use App\Http\Livewire\ClientStatementIsues;
use App\Models\IssueClientStatement;
use App\Models\IssuePhotos;
use App\Models\Order;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

class ClientIssuesController extends Controller
{
    public function showIssue($id)
    {
        $ClientStatementIsues = \App\Models\IssueClientStatement::with('Photos')->find($id);
        $Orders = Order::whereIn('id', $ClientStatementIsues->orders_ids)->get();
        // return $Orders;
        return view('clients.isues', compact('Orders', 'ClientStatementIsues', 'id'));
    }
    public function StatusIssue($id)
    {
        $IssueClientStatement = IssueClientStatement::find($id);
        $IssueClientStatement->status = 'paid';
        $IssueClientStatement->save();
        return redirect()->back();
    }

    public function UploadFiles(Request $request, $id)
    {
        // return $request;
        try{
        $name = $request->file->getClientOriginalName();
        // dd($name);
        $moved = $request->file->move(public_path("issue/{$id}"), $name);
        IssuePhotos::create([
            'issue' => $id,
            'photo' => $name,
        ]);
        }catch(Exception $e){
        return redirect()->back();
       }
        return redirect()->back();
    }
    public function ShowImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            return response()->file($path);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function downloadImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            $headers = ['Content-Type: image/jpeg'];
            return response()->download($path, $Photo, $headers);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function DeletImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            unlink($path);
            $IssuePhotos->delete();
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back();
        }
    }
}
