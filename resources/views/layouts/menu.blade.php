<?php 
   
   $moduleData = \App\Models\tbluserrolepages::where('userroleid',\Auth::user()->userroleid)->where('readright','!=',false)->pluck('page_id')->toArray();

?>
<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ (\Route::is('home')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Dashboard</p>
    </a>
</li>

@if(in_array(App\Models\tbluserrolepages::user_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
<li class="nav-item">
    <a href="{{ route('usermanagement.index') }}" class="nav-link {{ (\Route::is('usermanagement.index')) ? 'active' : '' }} {{ (\Route::is('usermanagement.edit')) ? 'active' : '' }} {{ (\Route::is('usermanagement.create')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-alt"></i>
        <p>User Management</p>
    </a>
</li>
@endif
    @php
                  if (
                       \Route::is('project.index') ||
                       \Route::is('project.create')||
                       \Route::is('project.edit') ||
                        \Route::is('survey.index') ||
                       \Route::is('survey.create')||
                       \Route::is('survey.edit') 

                      
                   ) {
                      $mainliclass="active";
                      $ulclass="menu-is-opening menu-open";

                  }else{
                    $mainliclass="";
                    $ulclass="";
                  }
                @endphp 
@if(in_array(App\Models\tbluserrolepages::project_page_id, $moduleData) || in_array(App\Models\tbluserrolepages::survey_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true )

<li class="nav-item has-treeview {{$ulclass}} {{ (\Route::is('project.index')) ? 'menu-open' : '' }} {{ (\Route::is('survey.index')) ? 'menu-open' : '' }} {{ (\Route::is('project.create')) ? 'menu-open' : '' }} {{ (\Route::is('survey.create')) ? 'menu-open' : '' }} {{ (\Route::is('survey.edit')) ? 'active' : '' }} {{ (\Route::is('project.edit')) ? 'active' : '' }}">
    <a href="#" class="nav-link {{ (\Route::is('project.index')) ? 'active' : '' }}  {{ (\Route::is('survey.index')) ? 'active' : '' }} {{ (\Route::is('project.create')) ? 'active' : '' }} {{ (\Route::is('survey.create')) ? 'active' : '' }} {{ (\Route::is('survey.edit')) ? 'active' : '' }} {{ (\Route::is('project.edit')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Project Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(in_array(App\Models\tbluserrolepages::project_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
        <li class="nav-item">
            <a href="{{ route('project.index') }}" class="nav-link  {{ (\Route::is('project.index')) ? 'active' : '' }} {{ (\Route::is('project.create')) ? 'active' : '' }} {{ (\Route::is('project.edit')) ? 'active' : '' }}">
                <i class="fas fa-clipboard nav-icon"></i>
                <p>Projects</p>
            </a>
        </li>
        @endif
        @if(in_array(App\Models\tbluserrolepages::survey_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
        <li class="nav-item">
            <a href="{{ route('survey.index') }}" class="nav-link  {{ (\Route::is('survey.index')) ? 'active' : '' }} {{ (\Route::is('survey.create')) ? 'active' : '' }} {{ (\Route::is('survey.edit')) ? 'active' : '' }}" >
                <i class="fab fa-wpforms nav-icon"></i>
                <p>Survey Forms</p>
            </a>
        </li>
        @endif
    </ul>
</li>
@endif

@if(in_array(App\Models\tbluserrolepages::location_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
<li class="nav-item">
    <a href="{{ route('location.index') }}" class="nav-link {{ (\Route::is('location.index')) ? 'active' : '' }} {{ (\Route::is('location.create')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-map-marker"></i>
        <p>Location Management</p>
    </a>
</li>
@endif

@if(in_array(App\Models\tbluserrolepages::projectcategory_page_id, $moduleData) || in_array(App\Models\tbluserrolepages::userrole_page_id, $moduleData) || in_array(App\Models\tbluserrolepages::surveyforms_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)

<li class="nav-item has-treeview {{ (\Route::is('projectcategory.index')) ? 'menu-open' : '' }} {{ (\Route::is('surveytypes.index')) ? 'menu-open' : '' }} {{ (\Route::is('surveytypes.create')) ? 'menu-open' : '' }} {{ (\Route::is('projectcategory.create')) ? 'menu-open' : '' }} {{ (\Route::is('surveytypes.edit')) ? 'menu-open' : '' }} {{ (\Route::is('userrole.edit')) ? 'menu-open' : '' }} {{ (\Route::is('userrole.index')) ? 'menu-open' : '' }} {{ (\Route::is('userrole.create')) ? 'menu-open' : '' }} {{ (\Route::is('projectcategory.edit')) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ (\Route::is('surveytypes.index')) ? 'active' : '' }} {{ (\Route::is('surveytypes.edit')) ? 'active' : '' }} {{ (\Route::is('projectcategory.edit')) ? 'active' : '' }}  {{ (\Route::is('projectcategory.index')) ? 'active' : '' }} {{ (\Route::is('surveytypes.create')) ? 'active' : '' }} {{ (\Route::is('projectcategory.create')) ? 'active' : '' }} {{ (\Route::is('userrole.create')) ? 'active' : '' }}  {{ (\Route::is('userrole.index')) ? 'active' : '' }} {{ (\Route::is('userrole.edit')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Configuration
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        @if(in_array(App\Models\tbluserrolepages::userrole_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true )
        <li class="nav-item">
            <a href="{{ route('userrole.index') }}" class="nav-link {{ (\Route::is('userrole.index')) ? 'active' : '' }} {{ (\Route::is('userrole.edit')) ? 'active' : '' }} {{ (\Route::is('userrole.create')) ? 'active' : '' }}">
                <i class="fas fa-user-cog nav-icon"></i>
                <p>User Role</p>
            </a>
        </li>
        @endif

        @if(in_array(App\Models\tbluserrolepages::surveyforms_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
        <li class="nav-item">
            <a href="{{ route('surveytypes.index') }}" class="nav-link {{ (\Route::is('surveytypes.index')) ? 'active' : '' }} {{ (\Route::is('surveytypes.create')) ? 'active' : '' }} {{ (\Route::is('surveytypes.edit')) ? 'active' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>Survey Type</p>
            </a>
        </li>
        @endif
        
        @if(in_array(App\Models\tbluserrolepages::projectcategory_page_id, $moduleData) || \Auth::user()->admin_right->adminrole==true)
        <li class="nav-item">
            <a href="{{ route('projectcategory.index') }}" class="nav-link {{ (\Route::is('projectcategory.index')) ? 'active' : '' }} {{ (\Route::is('projectcategory.create')) ? 'active' : '' }} {{ (\Route::is('projectcategory.edit')) ? 'active' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>Project Categories</p>
            </a>
        </li>
        @endif
    </ul>
</li>
@endif
{{-- 
<li class="nav-item has-treeview {{ (\Route::is('admin_user.index')) ? 'menu-open' : '' }} {{ (\Route::is('module.index')) ? 'menu-open' : '' }} {{ (\Route::is('module.create')) ? 'menu-open' : '' }} {{ (\Route::is('admin_user.create')) ? 'menu-open' : '' }} {{ (\Route::is('module.edit')) ? 'menu-open' : '' }} {{ (\Route::is('admin_user.edit')) ? 'menu-open' : '' }} {{ (\Route::is('right.index')) ? 'menu-open' : '' }} {{ (\Route::is('right.create')) ? 'menu-open' : '' }} {{ (\Route::is('right.edit')) ? 'menu-open' : '' }}">

    <a href="#" class="nav-link {{ (\Route::is('admin_user.index')) ? 'active' : '' }} {{ (\Route::is('admin_user.edit')) ? 'active' : '' }} {{ (\Route::is('module.edit')) ? 'active' : '' }}  {{ (\Route::is('module.index')) ? 'active' : '' }} {{ (\Route::is('admin_user.create')) ? 'active' : '' }} {{ (\Route::is('module.create')) ? 'active' : '' }}  {{ (\Route::is('right.index')) ? 'active' : '' }} {{ (\Route::is('right.create')) ? 'active' : '' }} {{ (\Route::is('right.edit')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            User Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin_user.index') }}" class="nav-link {{ (\Route::is('admin_user.index')) ? 'active' : '' }} {{ (\Route::is('admin_user.edit')) ? 'active' : '' }} {{ (\Route::is('admin_user.create')) ? 'active' : '' }}">
                <i class="fas fa-user-cog nav-icon"></i>
                <p>Admin/User Management</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('right.index') }}" class="nav-link {{ (\Route::is('right.index')) ? 'active' : '' }} {{ (\Route::is('right.edit')) ? 'active' : '' }} {{ (\Route::is('right.create')) ? 'active' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>Rights Management</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('module.index') }}" class="nav-link {{ (\Route::is('module.index')) ? 'active' : '' }}  {{ (\Route::is('module.edit')) ? 'active' : '' }} {{ (\Route::is('module.create')) ? 'active' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>Modules Management</p>
            </a>
        </li>
    </ul>
</li> --}}