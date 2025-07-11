<?php

namespace App\Http\Controllers;

use App\Exports\ExportCollectFees;
use App\Models\ClassModel;
use App\Models\SettingModel;
use App\Models\StudentFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class FeesCollectionController extends Controller
{
    public function collect_fees(Request $request){
        $data['getClass'] = ClassModel::getClass();
        if(!empty($request->all())){
            $data['getRecord'] = User::getCollectFeesStudent();
        }
        $data['header_title'] = 'Collect Fees';
        return view('admin.fees_collection.fees_collection',$data);

    }

    public function collection_report(){
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentFeesModel::getRecord();
        $data['header_title'] = 'Fee Collection Report';
        return view('admin.fees_collection.fees_collection_report',$data);
    }

    public function export_collection_report(Request $request){
        return Excel::download(new ExportCollectFees,'Feereport_'.date('Y-m-d').'.xlsx');
    }

    public function add_fees($id){
        $data['getFees'] = StudentFeesModel::getFees($id);
        $getRecord = User::getSingleClass($id);
        $data['getRecord'] = $getRecord;
        $data['paid_amount'] = StudentFeesModel::getPaidAmount($id, $getRecord->class_id);
        $data['header_title'] = 'Add New';
        return view('admin.fees_collection.add_fees',$data);
    }

    public function add_fees_insert($id,Request $request){
        $getStudent = User::getSingleClass($id);
        $paid_amount = StudentFeesModel::getPaidAmount($id, $getStudent->class_id);
        $remeianing_amount = $getStudent->amount - $paid_amount;
        if(!empty($request->paid_amount)){
            if($remeianing_amount >= $request->paid_amount){
                $remaining_amount_user = $remeianing_amount - $request->paid_amount;
                $pay = new StudentFeesModel;
                $pay->student_id = $id;
                $pay->class_id = $getStudent->class_id;
                $pay->total_amount = $remeianing_amount;
                $pay->remaining_amount = $remaining_amount_user;
                $pay->paid_amount = $request->paid_amount;
                $pay->payment_type = $request->payment_type;
                $pay->is_paid = 1;
                $pay->remark = $request->remark;
                $pay->created_by = Auth::user()->id;
                $pay->save();
                return redirect()->back()->with('success','Payment added successfully');
            }
            else{
                return redirect()->back()->with('error','Paid amount should be less than or equal to remaining amount');
            }
        }
        else{
            return redirect()->back()->with('error','Paid amount is required');
        }
    }

    public function add_fees_student(){
        $data['getFees'] = StudentFeesModel::getFees(Auth::user()->id);
        $getRecord = User::getSingleClass(Auth::user()->id);
        $data['getRecord'] = $getRecord;
        $data['paid_amount'] = StudentFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        $data['header_title'] = 'Add New';
        return view('student.add_fees',$data);
    }

    public function add_fees_insert_student(Request $request){
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount = StudentFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        $remeianing_amount = $getStudent->amount - $paid_amount;
        if(!empty($request->paid_amount)){
            if($remeianing_amount >= $request->paid_amount){
                $remaining_amount_user = $remeianing_amount - $request->paid_amount;
                $pay = new StudentFeesModel;
                $pay->student_id = Auth::user()->id;
                $pay->class_id = Auth::user()->class_id;
                $pay->total_amount = $remeianing_amount;
                $pay->remaining_amount = $remaining_amount_user;
                $pay->paid_amount = $request->paid_amount;
                $pay->payment_type = $request->payment_type;
                $pay->remark = $request->remark;
                $pay->created_by = Auth::user()->id;
                $pay->save();

                $getSetting = SettingModel::getSingle();
                if($request->payment_type == 'PayPal'){
                    $query = [];
                    $query['cmd'] = '_xclick';
                    $query['business'] = $getSetting->paypal_email;
                    $query['item_name'] = 'Fees Payment';
                    $query['no_shipping'] = '1';
                    $query['item_number'] = $pay->id;
                    $query['amount'] = $request->paid_amount;
                    $query['currency_code'] = 'USD';
                    $query['return'] = url('student/fees-payment-success');
                    $query['cancel_return'] = url('student/fees-payment-cancel');
                    return redirect()->away('https://www.sandbox.paypal.com/cgi-bin/webscr?'.http_build_query($query));
                    exit();
                }

                else if($request->payment_type == 'Mpesa'){
                    $pay->is_paid = 1;
                }
                return redirect()->back()->with('success','Payment added successfully');
            }
            else{
                return redirect()->back()->with('error','Paid amount should be less than or equal to remaining amount');
            }
        }
        else{
            return redirect()->back()->with('error','Paid amount is required');
        }
    }

    public function PaymentSuccess($student_id,Request $request){
       if(!empty($request->item_number) && !empty($request->st) && $request->st == 'Pending'){
            $fees = StudentFeesModel::getSingle($request->item_number);
            $fees->payment_data = json_encode($request->all());
            $fees->is_paid = 1;
            $fees->save();

            if(Auth::user()->user_type == 3){
                return redirect('student/fees-collection')->with('success','Payment success');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('parent/my-student/fee-collection/'.$student_id)->with('success','Payment success');
            }
       }
       else{
            if(Auth::user()->user_type == 3){
                return redirect('student/fees-collection')->with('success','Payment Failed');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('parent/my-student/fee-collection/'.$student_id)->with('success','Payment Failed');
            }
       }


    }

    public function PaymentCancel($student_id){
        if(Auth::user()->user_type == 3){
            return redirect('student/fees-collection')->with('success','Payment Canceled');
        }
        else if(Auth::user()->user_type == 4){
            return redirect('parent/my-student/fee-collection/'.$student_id)->with('success','Payment Canceled');
        }
    }

    public function add_fees_parent($student_id){
        $data['getFees'] = StudentFeesModel::getFees($student_id);
        $getRecord = User::getSingleClass($student_id);
        $data['getRecord'] = $getRecord;
        $data['paid_amount'] = StudentFeesModel::getPaidAmount($student_id, $getRecord->class_id);
        $data['header_title'] = 'Add New';
        return view('parent.add_fees',$data);
    }

    public function add_fees_insert_parent($student_id,Request $request){
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $remeianing_amount = $getStudent->amount - $paid_amount;
        if(!empty($request->paid_amount)){
            if($remeianing_amount >= $request->paid_amount){
                $remaining_amount_user = $remeianing_amount - $request->paid_amount;
                $pay = new StudentFeesModel;
                $pay->student_id = $student_id;
                $pay->class_id = $getStudent->class_id;
                $pay->total_amount = $remeianing_amount;
                $pay->remaining_amount = $remaining_amount_user;
                $pay->paid_amount = $request->paid_amount;
                $pay->payment_type = $request->payment_type;
                $pay->remark = $request->remark;
                $pay->created_by = Auth::user()->id;
                $pay->save();

                $getSetting = SettingModel::getSingle();
                if($request->payment_type == 'PayPal'){
                    $query = [];
                    $query['cmd'] = '_xclick';
                    $query['business'] = $getSetting->paypal_email;
                    $query['item_name'] = 'Fees Payment';
                    $query['no_shipping'] = '1';
                    $query['item_number'] = $pay->id;
                    $query['amount'] = $request->paid_amount;
                    $query['currency_code'] = 'USD';
                    $query['return'] = url('parent/fees-payment-success/'.$student_id);
                    $query['cancel_return'] = url('parent/fees-payment-cancel/'.$student_id);
                    return redirect()->away('https://www.sandbox.paypal.com/cgi-bin/webscr?'.http_build_query($query));
                    exit();
                }

                else if($request->payment_type == 'Mpesa'){
                    $consumerKey = "HQtHij9FCVGdaHfmjA7VLikAXQq4NGmv2VGQotNeOrFk93Yt";
                    $consumerSecret = "P7kuLh11EVBXH1dkYqxaPx5CDbdhLm1HmrAMEDDk81VwrBE2edks";

                    $credentials = base64_encode("$consumerKey:$consumerSecret");

                    $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Basic ' . $credentials
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        return response()->json([
                            'error' => curl_error($ch)
                        ], 500);
                    }

                    curl_close($ch);

                    $result = json_decode($response);

                    return response()->json($result);
                }
                return redirect()->back()->with('success','Payment added successfully');
            }
            else{
                return redirect()->back()->with('error','Paid amount should be less than or equal to remaining amount');
            }
        }
        else{
            return redirect()->back()->with('error','Amount Cannot be empty');
        }
    }

    public function payments(Request $request){
        $consumerKey = "HQtHij9FCVGdaHfmjA7VLikAXQq4NGmv2VGQotNeOrFk93Yt";
                    $consumerSecret = "P7kuLh11EVBXH1dkYqxaPx5CDbdhLm1HmrAMEDDk81VwrBE2edks";

                    $credentials = base64_encode("$consumerKey:$consumerSecret");

                    $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Basic ' . $credentials
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        return response()->json([
                            'error' => curl_error($ch)
                        ], 500);
                    }

                    curl_close($ch);

                    $result = json_decode($response);

                    return response()->json($result);
    }

}
