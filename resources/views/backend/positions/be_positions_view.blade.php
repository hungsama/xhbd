@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Quản lý position
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="#">Positions</a></li>                                        
        </ol>
    </div>
</div>        

@include('backend.positions.be_form_search_position_view')

<div class="row">

    <div class="col-md-12">

        <div class="block">
            <div class="header">
                <h2>Result data</h2>  
                <div class="side pull-right">                            
                    <ul class="buttons">                                
                        <li><a href="{!! route('be-create-position.show')!!}"><span class=" btn btn-success icon-plus tip" title data-original-title="Create a new position"> Create</span></a></li>
                        <li><a href="#"><span class=" btn btn-danger icon-remove tip" title data-original-title="Remove position have selected"> Remove</span></a></li>
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
                            <th width="10%">Name</th>
                            <th width="25%">Image</th>
                            <th width="15%">Limit ads</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%">Create time</th>
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
                            <td>
                                <div class="gallery-item" style="margin: 0px;">
                                    <div class="gallery-image">
                                        <a class="fancybox" rel="group" href="{!! $r->image_default !!}"><img src="{!! $r->image_default !!}" class="img-thumbnail"></a>
                                    </div>
                                </div>                        
                            </td>
                            <td>{!! $r->limit_ads !!}</td>
                            <td class="text-center">{!! $r->status !!}</td>
                            <td>{!! date('d/m/Y', $r->created_at) !!}</td>
                            <td  class="text-center">
                                <a href="{!! route('be-detail-position.show', $r->id) !!}" class="btn icon-eye-open tip" title data-original-title="View detail"></a>
                                <form class="cmxform form-horizontal" method="POST" action="{!! route('be-delete-position.show', $r->id) !!}" style="display:inline">
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
    <a href="{!! route('be-ajaxsearch-postion.show') !!}" title="" id="search-paginate"></a>
    <script src="/backend/my-js/be_position.js"></script>
</div>
@stop