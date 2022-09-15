@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <br />
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" value="{{Auth::user()->id}}" id="username" />
            <select class="form-control select2" id="projectdropdown" name="projectname[]" multiple="multiple" data-placeholder="Select a Project" data-dropdown-css-class="select2-red">
                <option disabled>Select Project</option>
            </select>
        </div>
    </div>
    <br />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Total Projects</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class='fas fa-cloud-download-alt' title="Download"></i>&nbsp;
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="donutchart" class="card-body p-3">
                            <div id="projectpie"></div>
                            <div id="labelOverlay">
                                <p class="used-size" id="totalcountprojects"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Total Surveys by Project</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class='fas fa-cloud-download-alt' title="Download"></i>&nbsp;
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="donutchartsurvey" class="card-body p-3">
                            <div id="projectsurveypie"></div>
                            <div id="labelOverlay">
                                <p class="used-size" id="totalprojectsurveycount"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Total Users by Project</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class='fas fa-cloud-download-alt' title="Download"></i>&nbsp;
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="donutchartuser" class="card-body p-3">
                            <div id="projectuserspie"></div>
                            <div id="labelOverlay">
                                <p class="used-size" id="totalusers"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Project Location Map</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class='fas fa-cloud-download-alt' title="Download"></i>&nbsp;
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div id="projectmap" style="height:90vh;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.homecharts')
@include('scripts.projects')
@include('scripts.multiple')
@endsection