@extends("layouts.app")

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title float-left">
                Transactions
            </h3>
        </div> 
      
      <div class="card-body table-responsive table-bordered table-striped">
        <table class="table" id="data_table">
          <thead class="thead-inverse">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Plan Name</th>
              <th>Total Paid</th>
              <th>Payment Id</th>
              <th>Payment Type</th>
              <th>Date</th>
              <th>Payment Receipt</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($data as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td><a href="{{url('admin/user/'.$row->user->id) }}" class="ml-3" style="font-size:15px;"><b>{{$row->user->name}}</b></a></td>
              <td>{{$row->subscription->plan_name}}</td>
              <td>{{$row->total_paid}}</td>
              <td>{{$row->payment_id}}</td>
              <td>{{$row->payment_type}}</td>
              <td>{{date('d M, y',strtotime($row->date))}}</td>
              <td>@if($row->payment_receipt)<a href="{{asset('uploads/payment/'.$row->payment_receipt)}}" target="_blank" class="text-primary">view</a>@endif</td>
              @if($row->status == "Completed")
                <td>{{$row->status}}</td>
              @else
                @if(Auth::user()->user_type == "Demo")
                <td><button type="button" class="btn btn-secondary ToastrButton">Completed</button></td>
                @else
                <td><a class="btn btn-secondary" href="{{url('admin/payment-completed/'.$row->id)}}" role="button">Completed</a></td>
                @endif
              @endif
              <td class="align-middle">
                @if($row->status != "Completed")
                <a data-id="{{$row->id}}" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-danger ml-2"><span aria-hidden="true" class="fa fa-trash"></span></button></a>
                @endif
                {!! Form::open(['url' => 'admin/transaction-delete','method'=>'POST','class'=>'form-horizontal','id'=>'form_'.$row->id]) !!}
                {!! Form::hidden("id",$row->id) !!}
                {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          @if(Auth::user()->user_type == "Demo")
          <button type="button" class="btn btn-danger ToastrButton">Delete</button>
          @else
          <button id="del_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
          @endif
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
@endsection

@section('script')
<script type="text/javascript">
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });
</script>
@endsection
