<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>Fees Collection</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"/>
</head>
<body>

<div class="container mt-5">
  <div class="row mb-3">
    <div class="col-sm-6"><h3>Fees Collection</h3></div>
    <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-secondary" onclick="history.back()">
            ← Back
          </button>
      <button type="button" class="btn btn-primary ml-2" id="addFees">
        <i class="bi bi-plus"></i> Add Fees
      </button>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><strong>Fees Collection</strong></div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Class Name</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Remaining Amount</th>
            <th>Payment Type</th>
            <th>Remark</th>
            <th>Created Date</th>
            <th>Created By</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($getFees as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->class_name }}</td>
                    <td>Ksh {{ number_format($value->total_amount,2) }}</td>
                    <td>Ksh {{ number_format($value->paid_amount,2) }}</td>
                    <td>Ksh {{ number_format($value->remaining_amount,2) }}</td>
                    <td>{{ $value->payment_type }}</td>
                    <td>{{ $value->remark }}</td>
                    <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                    <td>{{ $value->created_by_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No Fees Collection Found</td>
                </tr>
            @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addFeesModal" tabindex="-1" role="dialog" aria-labelledby="addFeesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFeesLabel">Add Fees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="">
        @csrf
      <div class="modal-body">
        <div class="form-group">
            <label>Class Name : <b>{{ $getRecord->class_name }}</b></label>
          </div>
        <div class="form-group">
            <label>Total Amount : <b>Ksh {{ number_format($getRecord->amount,2) }}</b></label>
          </div>
        <div class="form-group">
            <label>Paid Amount : <b>Ksh {{ number_format($paid_amount,2) }}</b></label>
          </div>
          <div class="form-group">
            @php
                $remeianing_amount = $getRecord->amount - $paid_amount;
            @endphp
            <label>Remaining Amount : <b>Ksh {{ number_format($remeianing_amount,2) }}</b></label>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="number" name="paid_amount" class="form-control">
          </div>
          <div class="form-group">
            <label>Payment Type</label>
            <select name="payment_type" class="form-control">
                <option value="">--Select--</option>
                <option value="PayPal">PayPal</option>
                <option value="Mpesa">Mpesa</option>
            </select>
          </div>
          <div class="form-group">
            <label>Remark</label>
            <textarea name="remark" class="form-control" cols="30" rows="5"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Fees</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9M9V0gDg0a1E74uPjdCIEw1dEjo9Zskq4yAzT"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
  crossorigin="anonymous"></script>

<script>
  document.getElementById('addFees').addEventListener('click', function () {
    $('#addFeesModal').modal('show');
  });
</script>

</body>
</html>
