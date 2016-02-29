@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Quản lý category
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="#">Categories</a></li>                                        
        </ol>
    </div>
</div>        

@include('backend.categories.be_form_search_category_view')

<div class="row">

    <div class="col-md-12">

        <div class="block">
            <div class="header">
                <h2>Result data</h2>  
                <div class="side pull-right">                            
                    <ul class="buttons">                                
                        <li><a href="{!! route('be-create-category.show')!!}"><span class=" btn btn-success icon-plus tip" title data-original-title="Create a new article"> Create</span></a></li>
                        <li><a href="#"><span class=" btn btn-danger icon-remove tip" title data-original-title="Remove articles have selected"> Remove</span></a></li>
                    </ul>
                </div>                                      
            </div>
            <div class="content" id="content">
                @if (Session::has('success'))
                   {!! Session::get('success') !!}
                @endif
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"/></th>
                            <th width="5%">ID</th>
                            <th width="30%">Name</th>
                            <th width="5%" class="text-center">Image</th>
                            <th width="5%">Order</th>
                            <th width="10%">Create time</th>
                            <th width="15%">Parent</th>     
                            <th width="15%" class="text-center">Belong To Cate</th>                                  
                            <th width="5%" class="text-center">Status</th>                                    
                            <th width="10%" class="text-center">Actions</th>                                    
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($data['records']->items())
                        @foreach ($data['records']->items() as $k => $r)
                        <tr>
                            <td><input type="checkbox" name="checkbox"/></td>
                            <td>{!! $r->id !!}</td>
                            <td>{!! $r->name !!}</td>
                            <td class="text-center"><img src="{!! $r->image !!}" width="45" height="30"></td>
                            <td class="text-center">{!! $r->rank !!}</td>
                            <td>{!! date('d/m/Y', $r->created_at) !!}</td>
                            <td>@if($r->parent !=0) No @else Yes @endif</td>
                            <td class="text-center">{!! $r->parent_name !!}</td>
                            <td class="text-center change-status-{!! $r->id !!}">@if($r->status == 1) <button type="button" class="btn btn-success btn-small" onclick="changeStatus('{!! route('be-change-status-category.show') !!}', '{!! $r->id !!}', '0');">ON</button> @else <button type="button" class="btn btn-danger btn-small" onclick="changeStatus('{!! route('be-change-status-category.show') !!}', '{!! $r->id !!}', '1');">OFF</button>@endif</td>
                            <td  class="text-center">
                                <a href="{!! route('be-detail-category.show', $r->id) !!}" class="btn icon-eye-open tip" title data-original-title="View detail"></a>
                                <form class="cmxform form-horizontal" method="POST" action="{!! route('be-delete-category.show', $r->id) !!}" style="display:inline">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <button class="btn icon-trash tip" title data-original-title="Remove" type="submit"></button>
                                </form>
                            </td>
                        </tr>  
                        @endforeach
                        @else
                        <tr class="odd"><td valign="top" colspan="7" class="text-center text-danger">No matching records found</td></tr>
                        @endif                           
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
                    @if ($data['records'])
                    {!! $data['records']->render() !!}
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    <a href="{!! route('be-ajaxsearch-category.show') !!}" title="" id="search-paginate"></a>
    <script src="/backend/my-js/be_category.js"></script>
</div>
@stop