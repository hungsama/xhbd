<div class="row">                   
    <div class="col-md-12">
        
        <nav class="navbar brb" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-reorder"></span>                            
                </button>                                                
                <a class="navbar-brand" href="{!! route('be-dashboard.show') !!}"><img src="/backend/img/logo.png"/></a>                                                                                     
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{!! route('be-dashboard.show') !!}">
                            <span class="icon-home"></span> Dashboard
                        </a>
                    </li>                            
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-list"></span> Contents</a>
                        <ul class="dropdown-menu">                                    
                            <li><a href="{!! route('be-category.show') !!}">Categories</a></li>
                            <li><a href="{!! route('be-article.show') !!}">Articles</a></li>
                            <li><a href="{!! route('be-clubs.show') !!}">Clubs</a></li>
                            <li><a href="{!! route('be-ranks.show') !!}">Ranks</a></li>
                            <li><a href="{!! route('be-lives.show') !!}">Lives</a></li>
                            <li><a href="{!! route('be-tag.show') !!}">Tags</a></li>
                        </ul>                                
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-list"></span> Ads</a>
                        <ul class="dropdown-menu">                                    
                            <li><a href="{!! route('be-position.show') !!}">Positions</a></li>
                            <li><a href="{!! route('be-advertiser.show') !!}">Avertisers</a></li>
                            <li><a href="{!! route('be-advertisement.show') !!}">Advertisements</a></li>
                        </ul>                                
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-list"></span> Reposts</a>
                        <ul class="dropdown-menu">                                    
                            <li><a href="{!! route('be-log-view.show') !!}">View logs</a></li>
                            <li><a href="{!! route('be-log-click.show') !!}">Click logs</a></li>
                            <li><a href="form_files.html">Others</a></li>
                        </ul>                                
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-cogs"></span> Configs</a>
                        <ul class="dropdown-menu">                                    
                            <li><a href="{!! route('be-admin.show') !!}">Admins</a></li>
                            <li><a href="{!! route('be-admin-group.show') !!}">Admin Groups</a></li>
                            <li><a href="{!! route('be-action-logout.show') !!}">Log out</a></li>
                        </ul>                                
                    </li>
                </ul>
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        @if(in_array(Session::get('adminInfo')->role, array('root', 'admin')))
                        <a class="form-control tipb" href="{!!route('be-detail-admin.show', Session::get('adminInfo')->admin_id)!!}"/ title data-original-title="View admin"><span class="icon-user"> </span>
                        {!! Session::get('adminInfo')->admin_name!!}</a>
                        @endif
                        <a class="form-control tipb" href="" title data-original-title="Logout"/><span class="icon-off"></span></a>
                    </div>                            
                </form>                                            
            </div>
        </nav>                 

    </div>            
</div>