<div class="row">

    <div class="col-md-12">

        <div class="block">
            <div class="content controls">   
                <form id="makedinputs" action="#" method="post">
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="label"> Start date</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar-empty"></span></div>
                                    <input type="text" class="datepicker form-control" value="" id="start-date-search"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="label"> End date</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar-empty"></span></div>
                                    <input type="text" class="datepicker form-control" value="" id="end-date-search"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="label"> Admin name</label>
                                <input type="text" name="admin_name" value="" class="form-control" id="admin-name-search">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="label"> Status</label>
                                <select name="status" class="form-control" id="status-search">
                                    <option value="">all</option>
                                    <option value="1">on</option>
                                    <option value="">off</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="margin-top:10px;">
                        <div class="side pull-right">
                            <div class="btn-group">
                                <a class="btn btn-defult" href="{!! route('be-admin.show') !!}"> Reset</a>
                                <a class="btn btn-success icon-search" id="search-available"> Search</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>                                    
        </div>                

    </div>
    <div class="col-md-12" id="search-hidden"  style="display:none">                
        <input type="hidden" name="title" value="" id="title-current">
        <input type="hidden" name="status" value="" id="status-current">
        <input type="hidden" name="start" value="" id="start-date-current">
        <input type="hidden" name="end" value="" id="end-date-current">
    </div>
</div>