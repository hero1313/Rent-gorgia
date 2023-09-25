@extends('main.index')
@section('content')
<!-- Page Content -->

<div class="content container-fluid">
    <div class="mb-3">
        <h3>ფილტრი > სექცია</h5>
    </div>
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            @if(Auth::user())
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn " data-toggle="modal" data-target="#add_type"><i class="fa fa-plus"></i>სექციის დამატება</a>
            </div>
            @endif
        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <form>
                                <th class="text-center">სექცია</th>
                                <th class="text-center">მოქმედება</th>
                            </form>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                        <tr>
                            <td class="text-center">{{$section->name}}</td>
                            @if(Auth::user() && Auth::user()->role != 2)
                            <td class="text-center">
                                <form action="{{ route('delete.section', ['id' => $section->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn-danger btn">წაშლა</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

<!-- Add sms -->
<div id="add_type" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">სექციის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('store.section')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>სექციის დასახელება</label>
                                <input class="form-control" autocomplete="off" name='name' type="text" placeholder="დასახელება">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">დამატება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add sms-->
@endsection