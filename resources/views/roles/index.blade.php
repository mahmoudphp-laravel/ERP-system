
@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    صلاحيات المستخدمين - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                صلاحيات المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الصلاحية بنجاح",
                type: "error"
            });
        }

    </script>
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                                <a class="btn btn-primary btn-sm"    href="{{ url('/' . $page='roles.create') }}">اضافة</a>
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;

                        @endphp
                            @foreach ($roles as $key => $role)
                            $i++;

                        <tr>
                            <td>{{ $i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>


                                            <a href="{{ url('roles.show_roles') }}/{{ $role->id }}" class="btn btn-sm btn-info"
                                                title="تعديل"><i class="las la-pen"></i>عرض</a>



                                            <a href="{{ url('roles.edit_roles') }}/{{ $role->id }}" class="btn btn-primary btn-sm"
                                                title="تعديل"><i class="las la-pen"></i>تعديل</a>

{{--  
                                        @if ($role->name !== 'owner')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                        @endif  --}}


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
